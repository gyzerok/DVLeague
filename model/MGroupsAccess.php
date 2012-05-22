<?php
class MGroupsAccess
{
    var $id;
    var $groupName;
    var $access;

    function Select($userName)
    {
        $query = mysql_query("SELECT * FROM groups_access
                              INNER JOIN user_groups ON user_groups.group_id = groups_access.group_access_group_id
                              INNER JOIN users ON users.user_group_id = user_groups.group_id
                              WHERE user_name = '$userName'
                             ");
        $this->access = mysql_fetch_assoc($query);

        return mysql_errno();
    }
}
?>