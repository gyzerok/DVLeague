<?php
include_once('IMDomainObject');

class MUser implements  IMDomainObject
{
    var $userId;
    var $userName;
    var $userPass;

    function Init($userName, $userPass)
    {
        $this->userId = NULL;
        $this->userName = $userName;
        $this->userPass = $userPass;
    }

    function Select($userName)
    {
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
}
?>
