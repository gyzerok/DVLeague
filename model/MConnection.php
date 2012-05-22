<?php
class MConnection
{
    public static function Open()
    {
        mysql_connect ("localhost", "root", "");
        mysql_query("SET NAMES 'cp1251';");
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