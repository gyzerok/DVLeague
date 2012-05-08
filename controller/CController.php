<?php
include ('CUserRegistrator.php');
include ("CUserAuth.php");
include ('..\model\MConnection.php');

switch ($_POST['controller'])
{
    case "registration":
        MConnection::Open();
        CUserRegistrator::Register($_POST['user_name'], md5(md5($_POST['user_pass'])));
        MConnection::Close();
        break;
    case "auth":
        MConnection::Open();
        CUserAuth::Auth($_POST['user_name'], $_POST['user_pass'], empty($_POST['cookie']));
        MConnection::Close();
        break;
}
?>