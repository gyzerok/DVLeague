<?php
include_once('IMDomainObject.php');

class MUser implements  IMDomainObject
{
    var $userId = NULL;
    var $userName = NULL;
    var $userPass = NULL;

    function Init($userName, $userPass)
    {
        $this->userName = mysql_real_escape_string($userName);
        $this->userPass = mysql_real_escape_string($userPass);
    }

    function Select($userName)
    {
        $userName = mysql_real_escape_string($userName);
        $query = mysql_query("SELECT * FROM users WHERE user_name = '$userName'");
        if(mysql_errno() == 0)
        {
            $query = mysql_fetch_assoc($query);
            $this->userId = $query[user_id];
            $this->userName = $query[user_name];
            $this->userPass = $query[user_pass];
        }
        return mysql_errno();
    }

    function Insert()
    {
        mysql_query("INSERT INTO users (user_name, user_pass) VALUES ('$this->userName', '$this->userPass')");
        return mysql_errno();
    }

    function Update(){}

    function Delete(){}

    function CheckPass($userPass)
    {
        if ($this->userPass == $userPass) return true;
        else return false;
    }
}
?>
