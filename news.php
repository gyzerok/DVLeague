<?php
session_start();
require_once '/import/twig/lib/Twig/Autoloader.php';
include ($_SERVER["DOCUMENT_ROOT"].'/controller/CNewsController.php');
include ($_SERVER["DOCUMENT_ROOT"].'/controller/CUserController.php');

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader, array('cache' => 'twig_cache',));

$newsArray = array();

MConnection::Open();

if ( empty( $_POST ) )
{
    if ( $_GET[ 'create' ] == 1 ) //href='/news.php?create=1&'
    {
        if (CUserController::Logged())
            echo $twig->render('addNews.html', array('authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name']));
    }
    else if ( $_GET[ 'edit' ] == 1 )//href='/news.php?id={id}&edit=1&'
    {
        $newsArray = CNewsController::ReadNewsID( $_GET[ 'id' ] );
        if (CUserController::Logged())
            echo $twig->render('editNews.html', array('newsArray' => $newsArray, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'] ));
    }
    else
    {
        if ( $_GET[ 'view' ] == 1 )//href='/news.php?id={id}&view=1&'
        {
            $newsArray = CNewsController::ReadNewsID( $_GET[ 'id' ] );
            $commentsArray = array();
            $commentsArray = CNewsController::ReadComments( $_GET[ 'id' ] );
            echo $twig->render('news_full.html', array('newsArray' => $newsArray, 'commentsArray' => $commentsArray, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'] ));
        }
        else  //href='/news.php
        {
            $newsArray = CNewsController::ReadNews();
            echo $twig->render('news.html', array('newsArray' => $newsArray, 'commentsArray' => $commentsArray, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'] ));
        }
    }
}
else
{
    if ( empty( $_POST[ 'newsID' ] ) )
    {
        CNewsController::WriteNews( $_POST );

        $newsArray = CNewsController::ReadNews();
        echo $twig->render('news.html', array('newsArray' => $newsArray, 'commentsArray' => $commentsArray, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'] ));

    }
    else
    {
        CNewsController::WriteComments( $_POST );
        $newsArray = CNewsController::ReadNewsID( $_POST[ 'newsID' ] );
        $commentsArray = array();
        $commentsArray = CNewsController::ReadComments( $_POST[ 'newsID' ] );
        echo $twig->render('news_full.html', array('newsArray' => $newsArray, 'commentsArray' => $commentsArray, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'] ));

    }
}

MConnection::Close();
?>