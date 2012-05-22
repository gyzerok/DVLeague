<?php
include ('..\model\MConnection.php');
include ('..\model\MInitDB.php');

MConnection::Open();

if (!empty($_POST['user_groups']))
    echo MInitDB::InitUserGroups() . "<br />";
if (!empty($_POST['users']))
    echo MInitDB::InitUsers() . "<br />";
if (!empty($_POST['news']))
    echo MInitDB::InitNews() . "<br />";

MConnection::Close();

class CAdminController
{
    static function CanUse($userName)
    {

    }
}
?>
