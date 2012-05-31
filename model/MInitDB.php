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
        mysql_query("CREATE TABLE dvl_db.comments (
                    comments_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                    comments_newsID INT NOT NULL ,
                    comments_text TEXT NOT NULL ,
                    comments_newsmaker INT NOT NULL ,
                    comments_date DATETIME NOT NULL ,
                    FOREIGN KEY (comments_newsmaker) REFERENCES users(user_id)
                    )");

        mysql_query("CREATE TABLE dvl_db.news (
                    news_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                    news_title VARCHAR( 50 ) NOT NULL ,
                    news_summary VARCHAR( 100 ) NOT NULL ,
                    news_text TEXT NOT NULL ,
                    news_newsmaker INT NOT NULL ,
                    news_date DATETIME NOT NULL ,
                    news_look INT NOT NULL ,
                    FOREIGN KEY (news_newsmaker) REFERENCES users(user_id)
                    )");



        return mysql_errno();
    }

    static function InitUserGroups()
    {
        mysql_query("CREATE TABLE dvl_db.user_groups (
                    user_group_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                    user_group_name VARCHAR( 50 ) NOT NULL ,
                    user_group_access_level INT NOT NULL ,
                    UNIQUE ( user_group_name )
                    )");
        mysql_query("INSERT INTO user_groups (user_group_name, user_group_access_level) VALUES ('Admin', 100)");
        mysql_query("INSERT INTO user_groups (user_group_name, user_group_access_level) VALUES ('User', 1)");

        mysql_query("CREATE TABLE dvl_db.groups_access (
                    group_access_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                    group_access_group_id INT NOT NULL ,
                    can_use_admin_panel BOOL NOT NULL DEFAULT '0' ,
                    can_add_news BOOL NOT NULL DEFAULT '0' ,
                    can_edit_his_news BOOL NOT NULL DEFAULT '0' ,
                    can_delete_his_news BOOL NOT NULL DEFAULT '0' ,
                    can_edit_lower_rank_user_news BOOL NOT NULL DEFAULT '0' ,
                    can_delete_lower_rank_user_news BOOL NOT NULL DEFAULT '0' ,
                    FOREIGN KEY (group_access_group_id) REFERENCES user_groups(user_group_id) ,
                    UNIQUE ( group_access_group_id )
                    )");

        $query = mysql_query("SELECT user_group_id FROM user_groups");
        $i = 0;
        while ($i < mysql_num_rows($query))
        {
            mysql_query("INSERT INTO groups_access (group_access_group_id) VALUES ('mysql_result($query, $i)')");
            $i++;
        }
        mysql_query("INSERT INTO groups_access (can_use_admin_panel) VALUES ('1') WHERE group_access_group_id = '1'");
        mysql_query("UPDATE groups_access SET can_use_admin_panel = '1' WHERE group_access_group_id = '1'");

        return mysql_error();
    }
}
?>