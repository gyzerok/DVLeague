<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/model/IMDomainObject.php');
include($_SERVER["DOCUMENT_ROOT"].'/model/MComments.php');

class MCommand implements IMDomainObject
{
    var $id = NULL;
    var $name = NULL;
    var $people = NULL;
    var $win = 0;
    var $lose = 0;
    var $score = 0;
    var $date = null;
    var $commands = array();

    function Init($name, $people)
    {
        $this->name = mysql_real_escape_string($name);
        $this->people = mysql_real_escape_string($people);
        $this->win = 0;
        $this->lose = 0;
        $this->score = 0;
        $this->date = date(null);
        $this->commands = null;
    }

    function Select($id)
    {
        $id = mysql_real_escape_string($id);
        $query = mysql_query("SELECT * FROM commands WHERE command_id = '$id'");
        if(mysql_errno() == 0)
        {
            $query = mysql_fetch_assoc($query);
            $this->id = $query[command_id];
            $this->name = $query[command_name];
            $this->people = explode(" ", $query[command_people] );
            $this->win = $query[command_win];
            $this->lose = $query[command_lose];
            $this->score = $query[command_score];
            $this->date = $query[command_date];
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
                $temp['people'] = explode(" ", $command[command_people] );
                $temp['win'] = $command[command_win];
                $temp['lose'] = $command[command_lose];
                $temp['score'] = $command[command_score];
                $temp['data'] = $command[command_data];

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
        mysql_query("INSERT INTO commands (command_name, command_people, command_win, command_lose, command_score, command_date)
                     VALUES ('$this->name', '$this->people', '$this->win', '$this->lose' , '$this->score' , '$this->date') ");
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
