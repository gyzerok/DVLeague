<?php
class MUserAccess
{
    static function CanUseAdminPanel($name)
    {
        $name = mysql_real_escape_string($name);
        $query = mysql_query("SELECT user_group_have_access FROM user_groups_user_access
                              INNER JOIN user_groups ON user_groups.user_group_id = user_groups_user_access.user_group_id
                              INNER JOIN users ON users.user_group_id = user_groups.user_group_id
                              INNER JOIN user_access ON user_access.user_access_id = user_groups_user_access.user_access_id
                              WHERE users.user_name = '$name'
                            ");
        $query = mysql_fetch_assoc($query);
        if ($query['user_group_have_access'] == 1) return true;
        else return false;
    }
}
?>