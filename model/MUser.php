<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/model/IMDomainObject.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/model/MGroup.php');

class MUser implements IMDomainObject
{
    var $id = NULL;
    var $name = NULL;
    var $pass = NULL;
    var $group = NULL;
    var $groupId = NULL;
    var $avatar = NULL;
    var $regdate = NULL;
    var $firstname = NULL;
    var $lastname = NULL;
    var $team = NULL;
    var $mail = NULL;
    var $skype = NULL;
    var $icq = NULL;

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
            $this->avatar = $query[user_avatar];
            $this->group->Select($this->name);
            $this->regdate = $query[user_regdate];
            $this->firstname = $query[user_firstname];
            $this->lastname = $query[user_lastname];
            $this->team = $query[user_team];
            $this->mail = $query[user_mail];
            $this->icq = $query[user_icq];
            $this->skype = $query[user_skype];

            return true;
        }
        return false;
    }

    function Insert()
    {
        mysql_query("INSERT INTO users (user_name, user_pass, user_regdate) VALUES ('$this->name', '$this->pass', NOW())");
        return mysql_errno();
    }

    function Update()
    {
        mysql_query("UPDATE users SET
                            user_firstname = '$this->firstname',
                            user_lastname = '$this->lastname',
                            user_mail = '$this->mail',
                            user_icq = '$this->icq',
                            user_skype = '$this->skype',
                            user_avatar = '$this->avatar'
                            WHERE user_id = '$this->id'");
    }

    function Delete($id){}

    function SetAvatar($path)
    {
        return mysql_errno();
    }
}
?>