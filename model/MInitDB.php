<?php
class MInitDB
{
    static function InitUsers()
    {
        $query = mysql_query("SELECT user_group_id FROM user_groups WHERE user_group_name = 'Admin'");
        $query = mysql_fetch_assoc($query);
        mysql_query("CREATE TABLE dvl_db.users (
                    user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                    user_name VARCHAR( 20 ) NOT NULL ,
                    user_pass VARCHAR( 32 ) NOT NULL ,
                    user_group_id INT NOT NULL DEFAULT '$query[user_group_id]' ,
                    FOREIGN KEY (user_group_id) REFERENCES user_groups(user_group_id) ,
                    UNIQUE ( user_name )
                    )");
        return mysql_errno();
    }

    static function InitNews()
    {
        mysql_query("CREATE TABLE dvl_db.news (
                    news_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                    news_title VARCHAR( 50 ) NOT NULL ,
                    news_summary VARCHAR( 100 ) NOT NULL ,
                    news_text TEXT NOT NULL ,
                    news_newsmaker INT NOT NULL ,
                    news_date DATETIME NOT NULL ,
                    FOREIGN KEY (news_newsmaker) REFERENCES users(user_id)
                    )");

        return mysql_errno();
    }

    static function InitUserGroups()
    {
        mysql_query("CREATE TABLE dvl_db.user_groups (
                    user_group_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                    user_group_name VARCHAR( 50 ) NOT NULL ,
                    UNIQUE ( user_group_name )
                    )");
        mysql_query("INSERT INTO user_groups (user_group_name) VALUES ('Admin')");
        mysql_query("INSERT INTO user_groups (user_group_name) VALUES ('User')");

        mysql_query("CREATE TABLE dvl_db.user_access (
                    user_access_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                    user_access_name VARCHAR( 50 ) NOT NULL ,
                    UNIQUE ( user_access_name )
                    )");
        mysql_query("INSERT INTO user_access (user_access_name) VALUES ('can_use_admin_panel')");

        mysql_query("CREATE TABLE dvl_db.user_groups_user_access (
                    user_access_id INT NOT NULL ,
                    user_group_id INT NOT NULL ,
                    user_group_have_access BOOL NOT NULL DEFAULT '0' ,
                    FOREIGN KEY (user_access_id) REFERENCES user_access(user_access_id) ,
                    FOREIGN KEY (user_group_id) REFERENCES user_groups(user_group_id)
                    )");
        $query1 = mysql_query("SELECT user_access_id FROM user_access WHERE user_access_name = 'can_use_admin_panel'");
        $query1 = mysql_fetch_assoc($query1);
        $query2 = mysql_query("SELECT user_group_id FROM user_groups WHERE user_group_name = 'Admin'");
        $query2 = mysql_fetch_assoc($query2);
        mysql_query("INSERT INTO user_groups_user_access (user_access_id, user_group_id, user_group_have_access) VALUES ('$query1[user_access_id]', '$query2[user_group_id]', '1')");

        return mysql_errno();
    }
}
?>