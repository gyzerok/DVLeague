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
    if ( $_GET[ 'view' ] == 1 )//href='/news.php?id={id}&view=1&'
    {
        $commandArray = CCommandController::ReadCommandID( $_GET[ 'id' ] );

        $notJoin = true;
        for($i = 1; $i < count($commandArray['people']); $i++ )
        {
            if ( $commandArray['people'][i] == $_SESSION[ 'user_name' ] )
            {
                $notJoin = false;
                break;
            }
        }

        echo $twig->render('command_full.html', array('commandArray' => $commandArray, 'countUsers' => count($commandArray['people']), 'notJoin' => $notJoin,'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'] ));
    }
    else
    {
        $commandArray = CCommandController::ReadCommands();
        echo $twig->render('command.html', array('commandArray' => $commandArray, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name']));
    }
}
else
{
    if ( empty( $_POST[ 'code' ] ) )
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
    else
    {
        if ( empty( $_POST[ 'commandSetID' ] ) )
        {
            CCommandController::AddGamer($_POST);
        }
        else
        {
            CCommandController::SetCode($_POST);
        }
    }


}

MConnection::Close();
?>