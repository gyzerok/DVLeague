<?php
session_start();
require_once '/import/twig/lib/Twig/Autoloader.php';
include ('controller\CNewsController.php');
include ($_SERVER["DOCUMENT_ROOT"].'/controller/CUserController.php');

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader, array('cache' => 'twig_cache',));

$newsArray = array();

MConnection::Open();

if ( empty( $_POST ) )
{
    if ( $_GET[ 'type' ] == 1 ) //href='/news.php?type=1&'
    {
        if (CUserController::Logged())
            echo $twig->render('addNews.html', array('authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name']));
    }
    else
    {
        $newsArray = CNewsController::ReadNews();

        if ( $_GET[ 'type' ] == 2 )//href='/news.php?id={id}&type=2&'
        {
            if (CUserController::Logged())
                echo $twig->render('editNews.html', array('newsArray' => $newsArray, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'] ));
        }
        else //href='/news.php?id={id}&type=0&'
        {
            $commentsArray = array();
            $commentsArray = CNewsController::ReadComments();
            echo $twig->render('news_id.html', array('newsArray' => $newsArray, 'commentsArray' => $commentsArray, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'] ));
        }
    }
}
else
{
    if ( empty( $_POST[ 'newsID' ] ) )
        CNewsController::WriteNews( $_POST );
    else
        CNewsController::WriteComments( $_POST );
}

MConnection::Close();
?>