<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/model/IMDomainObject.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/model/MGroup.php');

class MUser implements  IMDomainObject
{
    var $id = NULL;
    var $name = NULL;
    var $pass = NULL;
    var $group = NULL;
    var $groupId = NULL;

    function MUser()
    {
        $this->group = new MGroup();
    }

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
            $this->groupId = $query[user_group_id];

            $this->group->Select($this->name);

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
}
?>