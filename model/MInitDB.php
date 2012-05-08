<?php
class MInitDB
{
    static function InitUser()
    {
        mysql_query('CREATE TABLE dvl_db.users (
                    user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                    user_name VARCHAR( 20 ) NOT NULL ,
                    user_pass VARCHAR( 50 ) NOT NULL ,
                    UNIQUE (
                      user_name
                    )
                    )');
        return mysql_errno();
    }
}
?>