<?php
class MInitDB
{
    static function InitUser()
    {
        mysql_query("CREATE TABLE dvl_db.users (
                    user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                    user_name VARCHAR( 20 ) NOT NULL ,
                    user_pass VARCHAR( 32 ) NOT NULL ,
                    UNIQUE ( user_name )
                    )");
        return mysql_errno();
    }

    static  function InitNews()
    {
        mysql_query("CREATE TABLE dvl_db.news (
                    news_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                    user_title VARCHAR( 50 ) NOT NULL ,
                    news_summary VARCHAR( 100 ) NOT NULL ,
                    news_text TEXT NOT NULL ,
                    news_newsmaker INT NOT NULL ,
                    news_date DATETIME NOT NULL ,
                    FOREIGN KEY (news_newsmaker) REFERENCES users(user_id)
                    )");
        return mysql_errno();
    }
}
?>