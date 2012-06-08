<?php
session_start();
include ($_SERVER["DOCUMENT_ROOT"].'/controller/CNewsController.php');
include ($_SERVER["DOCUMENT_ROOT"].'/controller/CUserController.php');
include ($_SERVER["DOCUMENT_ROOT"].'/controller/CCommandController.php');
require_once '/import/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader, array('cache' => 'twig_cache',));

MConnection::Open();

$newsArray = array();
$newsArray = CNewsController::ReadNews(0);

$commandArray = array();
$commandArray = CCommandController::ReadCommands();
MConnection::Close();

echo $twig->render('index.html', array('newsArray' => $newsArray, 'commandArray' => $commandArray, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name']));
?>