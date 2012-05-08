<?php
include ('CUserRegistrator.php');
include ('..\model\MConnection.php');

switch ($_POST['controller'])
{
    case "registration":
        MConnection::Open();
        CUserRegistrator::Register($_POST['login'], md5($_POST['password']));
        MConnection::Close();
        break;
}
?>