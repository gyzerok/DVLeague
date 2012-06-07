<?php
session_start();
include ($_SERVER["DOCUMENT_ROOT"].'/controller/CCommandController.php');
include ($_SERVER["DOCUMENT_ROOT"].'/controller/CUserController.php');
require_once '/import/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader, array('cache' => 'twig_cache',));

$commandArray = array();

MConnection::Open();

if ( empty( $_POST ) )
{
    $commandArray = CCommandController::ReadCommands();
    echo $twig->render('command.html', array('commandArray' => $commandArray, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name']));
}
else
{
    if ( empty( $_POST[ 'commandName' ] ) )
        echo $twig->render('addCommand.html', array('authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name']));
    else
    {
        CCommandController::CreateCommand($_POST);
        $commandArray = CCommandController::ReadCommands();
        echo $twig->render('command.html', array('commandArray' => $commandArray, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name']));

    }
}

MConnection::Close();
?>