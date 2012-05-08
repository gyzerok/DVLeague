<?php
require_once '/import/twig/lib/Twig/Autoloader.php';
include ('/controller/CUserAuth.php');
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader, array('cache' => 'twig_cache',));

if (CUserAuth::Auth($_COOKIE['user_name'], $_COOKIE['user_pass'], isset($_COOKIE['cookie'])))
    echo $twig->render('authed_form.html', array('user_name' => $_COOKIE['user_name']));
else
    echo $twig->render('not_authed_form.html',array());
?>