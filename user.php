<?php
session_start();
include ($_SERVER["DOCUMENT_ROOT"].'/controller/CUserController.php');
require_once '/import/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader, array('cache' => 'twig_cache',));

$user = new MUser();
$user = CUserController::Show($_GET['name']);

switch ($_GET['type'])
{
    case 'posts':
        echo $twig->render('user_last_news.html', array('authed' => CUserController::Logged(), 'user' => $user, 'news' => CUserController::News($_GET['name'])));
        break;
    case 'comments':
        break;
    default:
        echo $twig->render('user.html', array('authed' => CUserController::Logged(), 'user' => $user));
        break;
}
?>