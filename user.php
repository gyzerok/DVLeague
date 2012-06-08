<?php
session_start();
include ($_SERVER["DOCUMENT_ROOT"].'/controller/CUserController.php');
require_once '/import/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader, array('cache' => 'twig_cache',));

$user = new MUser();
$user = CUserController::Show($_GET['name']);
$canEdit = $_SESSION['user_name'] == $_GET['name'];

switch ($_GET['type'])
{
    case 'posts':
        echo $twig->render('user_last_news.html', array('canEdit' => $canEdit, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'], 'user' => $user, 'news' => CUserController::News($_GET['name'])));
        break;
    case 'comments':
        echo $twig->render('user_last_comments.html', array('canEdit' => $canEdit, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'], 'user' => $user, 'comments' => CUserController::Comments($_GET['name'])));
        break;
    case 'edit':
        echo $twig->render('user_edit.html', array('authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'], 'user' => $user, 'comments' => CUserController::Comments($_GET['name'])));
        break;
    default:
        echo $twig->render('user.html', array('canEdit' => $canEdit, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'], 'user' => $user));
        break;
}
?>