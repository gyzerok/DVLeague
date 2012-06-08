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
        if (CUserController::CheckUser( $_SESSION[ 'user_name' ], $newsArray[ 'newsmaker' ], 'edit' ))
            echo $twig->render('editNews.html', array('newsArray' => $newsArray, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'] ));
    }
    else if ( $_GET[ 'view' ] == 1 )//href='/news.php?id={id}&view=1&'
    {
        $newsArray = CNewsController::ReadNewsID( $_GET[ 'id' ] );
        $newsArray['accessEdit'] = CUserController::CheckUser( $_SESSION[ 'user_name' ], $newsArray[ 'newsmaker' ], 'edit' );
        $newsArray['accessDelete'] = CUserController::CheckUser( $_SESSION[ 'user_name' ], $newsArray[ 'newsmaker' ], 'delete' );
        $commentsArray = array();
        $commentsArray = CNewsController::ReadComments( $_GET[ 'id' ] );
        echo $twig->render('news_full.html', array('newsArray' => $newsArray, 'commentsArray' => $commentsArray, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'] ));
    }
    else if ( $_GET[ 'delete' ] == 1 )//href='/news.php?id={id}&view=1&'
    {
        CNewsController::DeleteNews( $_GET[ 'id' ] );
        $newsArray = CNewsController::ReadNews( 0 );
        $count = CNewsController::CountNews();

        $pages = array();
        $pages = CNewsController::GetPages($count, 0);

        echo $twig->render('news.html', array('newsArray' => $newsArray, 'commentsArray' => $commentsArray, 'pages' => $pages, 'count' => $count, 'offset' => $offset, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'] ));
    }
    else  //href='/news.php
    {
        if ( empty( $_GET[ 'id' ] ) )
            $offset = 0;
        else
            $offset = $_GET[ 'id' ] * 10;

        $newsArray = CNewsController::ReadNews( $offset );

        for( $i = 0; $i < count( $newsArray ); $i++ )
        {
            $newsArray[$i]['accessEdit'] = CUserController::CheckUser( $_SESSION[ 'user_name' ], $newsArray[$i][ 'newsmaker' ], 'edit' );
            $newsArray[$i]['accessDelete'] = CUserController::CheckUser( $_SESSION[ 'user_name' ], $newsArray[$i][ 'newsmaker' ], 'delete' );

        }

        $count = CNewsController::CountNews();

        $pages = array();
        $pages = CNewsController::GetPages($count, $offset);

        echo $twig->render('news.html', array('newsArray' => $newsArray, 'commentsArray' => $commentsArray, 'pages' => $pages, 'count' => $count, 'offset' => $offset, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'] ));
    }
}
else
{
    if ( empty( $_POST[ 'newsID' ] ) )
    {
        CNewsController::WriteNews( $_POST );

        $newsArray = CNewsController::ReadNews( 0 );
        $count = CNewsController::CountNews();

        $pages = array();
        $pages = CNewsController::GetPages($count, 0);

        echo $twig->render('news.html', array('newsArray' => $newsArray, 'commentsArray' => $commentsArray, 'pages' => $pages, 'count' => $count, 'offset' => $offset, 'authed' => CUserController::Logged(), 'user_name' => $_SESSION['user_name'] ));

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