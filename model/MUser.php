<?php
include_once('IMDomainObject.php');

class MUser implements  IMDomainObject
{
    var $id = NULL;
    var $name = NULL;
    var $pass = NULL;

    function Init($userName, $userPass)
    {
        $this->name = mysql_real_escape_string($userName);
        $this->pass = mysql_real_escape_string($userPass);
    }

    function Select($userName)
    {
        $userName = mysql_real_escape_string($userName);
        $query = mysql_query("SELECT * FROM users WHERE user_name = '$userName'");
        if(mysql_errno() == 0)
        {
            $query = mysql_fetch_assoc($query);
            $this->id = $query[user_id];
            $this->name = $query[user_name];
            $this->pass = $query[user_pass];
            return true;
        }
        return false;
    }

    function Insert()
    {
        mysql_query("INSERT INTO users (user_name, user_pass) VALUES ('$this->name', '$this->pass')");
        return mysql_errno();
    }

    function Update(){}

    function Delete(){}

    function CheckPass($userPass)
    {
        if ($this->pass == $userPass) return true;
        else return false;
    }
}
?>
