<?php
include_once('IMDomainObject.php');

class MNews implements IMDomainObject
{
    var $id = NULL;
    var $title = NULL;
    var $summary = NULL;
    var $text = NULL;
    var $newsmaker = NULL;
    var $date = NULL;

    function Select($id)
    {
        $id = mysql_real_escape_string($id);
        $query = mysql_query("SELECT * FROM users WHERE news_id = '$id'");
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
    function Insert()
    {
        mysql_query("INSERT INTO news (news_title, user_summary, news_text, news_newsmaker, news_date)
                     VALUES ('$this->title', '$this->summary', '$this->text', '$this->newsmaker', '$this->date')");
        return mysql_errno();
    }
    function Update(){}
    function Delete(){}
}
?>
