<?php
class MConnection
{
    public static function Open()
    {
        mysql_connect ("localhost", "root", "");
        if (mysql_errno() == 0)
        {
            mysql_select_db("dvl_db");
            return mysql_errno();
        }
        return mysql_errno();
    }
    public static function Close()
    {
        mysql_close();
    }
}
?>