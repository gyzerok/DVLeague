<?php
session_start();
include_once ($_SERVER["DOCUMENT_ROOT"].'/model/MConnection.php');
include ($_SERVER["DOCUMENT_ROOT"].'/model/MGroupsAccess.php');
include ($_SERVER["DOCUMENT_ROOT"].'/controller/CUserController.php');
require_once 'import/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader, array('cache' => 'twig_cache',));

if (CUserController::Logged())
{
    MConnection::Open();



    if (MGroupAccess::CanUseAdminPanel($_COOKIE['user_name']))
        echo $twig->render('admin.html', array());
    else
        echo "Please login as Admin";

    MConnection::Close();
}
?>