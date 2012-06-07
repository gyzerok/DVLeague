<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/model/IMDomainObject.php');
include($_SERVER["DOCUMENT_ROOT"].'/model/MComments.php');

class MCommand implements IMDomainObject
{
    var $id = NULL;
    var $name = NULL;
    var $people = NULL;
    var $games = 0;
    var $win = 0;
    var $lose = 0;
    var $commands = array();

    function Init($id, $name, $people)
    {
        $this->id = $id;
        $this->name = mysql_real_escape_string($name);
        $this->people = mysql_real_escape_string($people);
        $this->games = 0;
        $this->win = 0;
        $this->lose = 0;
        $this->views = 0;
        $this->comments = 0;
    }

    function Select($id)
    {
        $id = mysql_real_escape_string($id);
        $query = mysql_query("SELECT * FROM command WHERE news_id = '$id'");
        if(mysql_errno() == 0)
        {
            $query = mysql_fetch_assoc($query);
            $this->id = $query[news_id];
            $this->title = $query[news_title];
            $this->summary = $query[news_summary];
            $this->text = $query[news_text];
            $this->newsmaker = $query[news_newsmaker];
            $this->date = $query[news_date];
            $this->views = $query[news_look];

            $mCooments = new MComments();
            $this->comments = $mCooments->CountCommentsByNews( $query[news_id] );
            $this->views++;
            $this->Update();
            $this->newsmaker = $query[user_name];
            return true;
        }
        return false;
    }

    function SelectCommands()
    {
        $query = mysql_query("SELECT * FROM commands ");
        if(mysql_errno() == 0)
        {
            $i = 0;
            while($command = mysql_fetch_array($query))
            {
                $temp = array();

                $temp['id'] = $command[command_id];
                $temp['name'] = $command[command_name];
                $temp['people'] = explode(" ", $command[command_people] ) ;
                $temp['games'] = $command[command_games];
                $temp['win'] = $command[command_win];
                $temp['lose'] = $command[command_lose];

                $this->commands[$i] = $temp;
                $i++;

            }
            return true;
        }
        return false;
    }

    function CountNews()
    {
        $query = mysql_query("SELECT COUNT(*) FROM news");
        if(mysql_errno() == 0)
        {
            $query = mysql_fetch_assoc($query);
            return $query['COUNT(*)'];
        }
    }

    function Insert()
    {
        mysql_query("INSERT INTO commands (command_name, command_people, command_games, command_win, command_lose)
                     VALUES ('$this->name', '$this->people', '$this->games', '$this->win', '$this->lose')");
        return mysql_error();
    }
    function Update()
    {
        mysql_query("UPDATE news SET news_title = '$this->title', news_summary = '$this->summary', news_text = '$this->text',
                    news_newsmaker = '$this->newsmaker', news_date = '$this->date', news_look = '$this->views'
                     WHERE news_id = '$this->id'");
        return mysql_error();
    }
    function Delete($id)
    {
        $query = mysql_query("DELETE  FROM news WHERE news_id = '$id'");
        return mysql_error();
    }
}
?>
