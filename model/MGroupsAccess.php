<?php
class MGroupsAccess
{
    var $id;
    var $groupName;
    var $canUseAdminPanel;
    var $canAddNews;
    var $canEditHisNews;
    var $canDeleteHisNews;
    var $canEditLowerRankUserNews;
    var $canDeleteLowerRankUserNews;

    function Select($groupId)
    {
        $query = mysql_query("SELECT * FROM groups_access
                              INNER JOIN user_groups ON user_groups.group_id = groups_access.group_access_group_id
                              WHERE group_name = '$groupId'
                             ");
        $query = mysql_fetch_assoc($query);
        $this->id = $query[group_access_id];
        $this->groupName = $query[user_group_name];
        $this->canUseAdminPanel = $query[group_access_can_use_admin_panel];
        $this->canAddNews = $query[group_access_can_add_news];
        $this->canEditHisNews = $query[group_access_can_edit_his_news];
        $this->canDeleteHisNews = $query[group_access_can_delete_his_news];
        $this->canEditLowerRankUserNews = $query[group_access_can_edit_lower_rank_user_news];
        $this->canDeleteLowerRankUserNews = $query[group_access_can_delete_lower_rank_user_news];

        return mysql_errno();
    }
}
?>