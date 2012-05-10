<?php
session_start();
include ('model\MConnection.php');
include ('model\MUserAccess.php');
require_once 'import/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader, array('cache' => 'twig_cache',));

if (isset($_SESSION['session_code']) && $_SESSION['session_code'] == $_COOKIE['session_code'])
{
    MConnection::Open();

    if (MUserAccess::CanUseAdminPanel($_COOKIE['user_name']))
        echo $twig->render('admin.html', array());
    else
        echo "Please login as Admin";

    MConnection::Close();
}
else
    echo "Не пытайся меня наебать!";
?>