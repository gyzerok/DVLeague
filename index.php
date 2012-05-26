<?php
session_start();
include ($_SERVER["DOCUMENT_ROOT"].'/controller/CUserController.php');
require_once '/import/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader, array('cache' => 'twig_cache',));

echo $twig->render('index.html', array('authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name']));