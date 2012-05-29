<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/model/IMDomainObject.php');

class MNews implements IMDomainObject
{
    var $id = NULL;
    var $title = NULL;
    var $summary = NULL;
    var $text = NULL;
    var $newsmaker = NULL;
    var $date = NULL;
    var $news = NULL;

    function Init($title, $summary, $text, $newsmaker, $date)
    {
        $this->id = NULL;
        $this->title = mysql_real_escape_string($title);
        $this->summary = mysql_real_escape_string($summary);
        $this->text = mysql_real_escape_string($text);
        $this->newsmaker = mysql_real_escape_string($newsmaker);
        $this->date = mysql_real_escape_string($date);
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
                $temp['newsmaker'] = $news[news_newsmaker];
                $temp['date'] = $news[news_date];

                $this->news[$i] = $temp;
                $i++;

            }
            return true;
        }
        return false;
    }

    function Insert()
    {
        mysql_query("INSERT INTO news (news_title, news_summary, news_text, news_newsmaker, news_date)
                     VALUES ('$this->title', '$this->summary', '$this->text', '$this->newsmaker', '$this->date')");
        return mysql_error();
    }
    function Update()
    {
        mysql_query("UPDATE news SET news_title = '$this->title', news_summary = '$this->summary', news_text = '$this->text',
                    news_newsmaker = '$this->newsmaker', news_date = '$this->date'
                     WHERE news_id = '$this->id'");
        return mysql_error();
    }
    function Delete(){}
}
?>
