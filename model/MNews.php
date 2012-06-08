<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/model/IMDomainObject.php');
include($_SERVER["DOCUMENT_ROOT"].'/model/MComments.php');

class MNews implements IMDomainObject
{
    var $id = NULL;
    var $title = NULL;
    var $picture = NULL;
    var $summary = NULL;
    var $text = NULL;
    var $newsmaker = NULL;
    var $date = NULL;
    var $views = 0;
    var $comments = 0;
    var $news;

    function Init($id, $title, $picture, $summary, $text, $newsmaker, $date)
    {
        $this->id = $id;
        $this->title = mysql_real_escape_string($title);
        $this->picture = $picture;
        $this->summary = mysql_real_escape_string($summary);
        $this->text = mysql_real_escape_string($text);
        $this->newsmaker = mysql_real_escape_string($newsmaker);
        $this->date = $date;
        $this->views = 0;
        $this->comments = 0;
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
            $this->picture = $query[news_pic];
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

    function SelectNews( $offset )
    {
        $query = mysql_query("SELECT * FROM news ORDER BY news_date DESC LIMIT $offset, 10");
        if(mysql_errno() == 0)
        {
            $i = 0;
            while($news = mysql_fetch_array($query))
            {
                $temp = array();

                $temp['id'] = $news[news_id];
                $temp['title'] = $news[news_title];
                $temp['picture'] = $news[news_pic];
                $temp['summary'] = $news[news_summary];
                $temp['text'] = $news[news_text];

                $query2 = mysql_query("SELECT * FROM users WHERE user_id = $news[news_newsmaker]");
                $query2 = mysql_fetch_assoc($query2);

                $temp['newsmaker'] = $query2[user_name];
                $temp['date'] = $news[news_date];
                $temp['views'] = $news[news_look];

                $mCooments = new MComments();
                $temp['comments'] = $mCooments->CountCommentsByNews( $news[news_id] );

                $this->news[$i] = $temp;
                $i++;

            }
            return true;
        }
        return false;
    }

    static function SelectByUser($name)
    {
        $query = mysql_query("SELECT * FROM news
                                INNER JOIN users ON news.news_newsmaker = users.user_id
                                WHERE users.user_name = '$name'
                                ORDER BY news.news_date DESC
                                LIMIT 0, 3
                            ");

        $temp = array();
        $i = 0;
        while($news = mysql_fetch_array($query))
        {
            $temp[$i] = $news;
            $i++;
        }
        return $temp;
        /*if(mysql_errno() == 0)
        {
            $i = 0;
            while($news = mysql_fetch_array($query))
            {
                $temp = array();

                $temp['id'] = $news[news_id];
                $temp['title'] = $news[news_title];
                $temp['summary'] = $news[news_summary];
                $temp['text'] = $news[news_text];
                $temp['newsmaker'] = $news[user_name];
                $temp['date'] = $news[news_date];
                $temp['views'] = $news[news_look];

                $mComments = new MComments();
                $temp['comments'] = $mComments->CountCommentsByNews( $news[news_id] );

                $this->news[$i] = $temp;
                $i++;

            }
            return true;
        }
        return false;*/
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
        mysql_query("INSERT INTO news (news_title, news_pic, news_summary, news_text, news_newsmaker, news_date, news_look)
                     VALUES ('$this->title', '$this->picture', '$this->summary', '$this->text', '$this->newsmaker', NOW(), '$this->views')");
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

    function SetPicture($path)
    {
        mysql_query("UPDATE news SET news_pic = '$path' WHERE news_id = '$this->id'");

        return mysql_errno();
    }
}
?>
