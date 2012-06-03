<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/model/IMDomainObject.php');
include($_SERVER["DOCUMENT_ROOT"].'/model/MComments.php');

class MNews implements IMDomainObject
{
    var $id = NULL;
    var $title = NULL;
    var $summary = NULL;
    var $text = NULL;
    var $newsmaker = NULL;
    var $date = NULL;
    var $news = NULL;
    var $views = 0;
    var $comments = 0;

    function Init($id, $title, $summary, $text, $newsmaker, $date)
    {
        $this->id = $id;
        $this->title = mysql_real_escape_string($title);
        $this->summary = mysql_real_escape_string($summary);
        $this->text = mysql_real_escape_string($text);
        $this->newsmaker = mysql_real_escape_string($newsmaker);
        $this->date = mysql_real_escape_string($date);
        $this->views = 0;
    }

    function Select($id)
    {
        $id = mysql_real_escape_string($id);
        $query = mysql_query("SELECT * FROM news INNER JOIN users ON users.user_id = news.news_newsmaker WHERE news_id = '$id'");
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
            $mCooments->Select( $query[news_id] );
            $this->comments = count( $mCooments->comments);
            $this->views++;
            $this->Update();
            $this->newsmaker = $query[user_name];
            return true;
        }
        return false;
    }

    function SelectNews()
    {
        $query = mysql_query("SELECT * FROM news");
        if(mysql_errno() == 0)
        {
            $i = 0;
            while($news = mysql_fetch_array($query))
            {
                $temp = array();

                $temp['id'] = $news[news_id];
                $temp['title'] = $news[news_title];
                $temp['summary'] = $news[news_summary];
                $temp['text'] = $news[news_text];

                $query2 = mysql_query("SELECT * FROM users WHERE user_id = $news[news_newsmaker]");
                $query2 = mysql_fetch_assoc($query2);

                $temp['newsmaker'] = $query2[user_name];
                $temp['date'] = $news[news_date];
                $temp['views'] = $news[news_look];

                $mCooments = new MComments();
                $mCooments->Select( $news[news_id] );
                $temp['comments'] = count( $mCooments->comments);

                $this->news[$i] = $temp;
                $i++;

            }
            return true;
        }
        return false;
    }

    function Insert()
    {
        mysql_query("INSERT INTO news (news_title, news_summary, news_text, news_newsmaker, news_date, news_look)
                     VALUES ('$this->title', '$this->summary', '$this->text', '$this->newsmaker', '$this->date', '$this->views')");
        return mysql_error();
    }
    function Update()
    {
        mysql_query("UPDATE news SET news_title = '$this->title', news_summary = '$this->summary', news_text = '$this->text',
                    news_newsmaker = '$this->newsmaker', news_date = '$this->date', news_look = '$this->views'
                     WHERE news_id = '$this->id'");
        return mysql_error();
    }
    function Delete(){}
}
?>
