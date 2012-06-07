<?php
session_start();
include ($_SERVER["DOCUMENT_ROOT"].'/controller/CUserController.php');
require_once '/import/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader, array('cache' => 'twig_cache',));

$user = new MUser();
$user = CUserController::Show($_GET['name']);

echo $twig->render('user.html', array('authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'], 'user' => $user));
?>