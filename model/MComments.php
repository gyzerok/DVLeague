<?php
include_once('IMDomainObject.php');

class MComments implements IMDomainObject
{
    var $id = NULL;
    var $newsID = NULL;
    var $text = NULL;
    var $newsmaker = NULL;
    var $date = NULL;
    var $comments = NULL;

    function Init($id, $newsID, $text, $newsmaker, $date)
    {
        $this->id = mysql_real_escape_string($id);;
        $this->newsID = mysql_real_escape_string($newsID);
        $this->text = mysql_real_escape_string($text);
        $this->newsmaker = mysql_real_escape_string($newsmaker);
        $this->date = mysql_real_escape_string($date);
        $this->comments = NULL;
    }

    function Select($newsID)
    {
        $newsID = mysql_real_escape_string($newsID);
        $query = mysql_query("SELECT * FROM comments WHERE comments_newsID = '$newsID'");
        if(mysql_errno() == 0)
        {
            $i = 0;
            while($comment = mysql_fetch_array($query))
            {
                $temp = array();

                $temp['id'] = $comment[comments_id];
                $temp['newsID'] = $comment[comments_newsID];
                $temp['text'] = $comment[comments_text];
                $temp['newsmaker'] = $comment[comments_newsmaker];

                $query2 = mysql_query("SELECT * FROM users WHERE user_id = $comment[comments_newsmaker]");
                $query2 = mysql_fetch_assoc($query2);

                $temp['newsmaker'] = $query2[user_name];
                $temp['avatar'] = $query2[user_avatar];

                $temp['date'] = $comment[comments_date];

                $this->comments[$i] = $temp;
                $i++;

            }

            return true;
        }
        return false;
    }

    static function SelectByUser($name)
    {
        $query = mysql_query("SELECT * FROM comments
                                INNER JOIN users ON users.user_id = comments.comments_newsmaker
                                WHERE users.user_name = '$name'
                                ORDER BY comments_date DESC
                                LIMIT 0, 10
                             ");

        $temp = array();
        $i = 0;
        while($comments = mysql_fetch_array($query))
        {
            $temp[$i] = $comments;
            $i++;
        }
        return $temp;
    }

    function CountCommentsByNews($newsID)
    {
        $newsID = mysql_real_escape_string($newsID);
        $query = mysql_query("SELECT COUNT(*) FROM comments WHERE comments_newsID = '$newsID'");
        if(mysql_errno() == 0)
        {
            $query = mysql_fetch_assoc($query);
            return $query['COUNT(*)'];
        }
    }

   function Insert()
    {
        mysql_query("INSERT INTO comments (comments_newsID, comments_text, comments_newsmaker, comments_date)
                     VALUES ('$this->newsID', '$this->text', '$this->newsmaker', NOW())");
        return mysql_error();
    }
    function Update()
    {
        mysql_query("UPDATE news SET news_title = '$this->title', news_summary = '$this->summary', news_text = '$this->text',
                    news_newsmaker = '$this->newsmaker', news_date = '$this->date'
                     WHERE news_id = '$this->id'");
        return mysql_error();
    }
    function Delete($id){}
}
?>
