<?php
session_start();
require_once '/import/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader, array('cache' => 'twig_cache',));

if (isset($_SESSION['session_code']) && $_SESSION['session_code'] == $_COOKIE['session_code'])
    echo $twig->render('authed_form.html', array('user_name' => $_COOKIE['user_name']));
else
    echo $twig->render('not_authed_form.html',array());
?>