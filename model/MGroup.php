<?php
class MGroup
{
    var $id;
    var $name;
    var $access_level;
    var $access;

    function Select($userName)
    {
        $query = mysql_query("SELECT * FROM groups_access
                              INNER JOIN user_groups ON user_groups.group_id = groups_access.group_access_group_id
                              INNER JOIN users ON users.user_group_id = user_groups.group_id
                              WHERE user_name = '$userName'
                             ");
        $this->access = mysql_fetch_assoc($query);

        $query = mysql_query("SELECT * FROM user_groups
                              INNER JOIN users ON users.user_group_id = user_groups.group_id
                              WHERE user_name = '$userName'
                             ");
        $query = mysql_fetch_assoc($query);
        $this->id = $query[user_group_id];
        $this->name = $query[user_group_name];
        $this->access_level = $query[user_group_access_level];

        return mysql_errno();
    }
}
?>