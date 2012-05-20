<?php
session_start();
require_once '/import/twig/lib/Twig/Autoloader.php';
//include ('controller\CNewsController.php');
include ($_SERVER["DOCUMENT_ROOT"].'\model\MNews.php');
include ($_SERVER["DOCUMENT_ROOT"].'\model\MComments.php');
include ($_SERVER["DOCUMENT_ROOT"].'\model\MConnection.php');


Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader, array('cache' => 'twig_cache',));


$newsArray = array();

MConnection::Open();

if ( empty( $_POST ) )
{

    if ( $_GET[ 'type' ] == 1 ) //href='/news.php?type=1&'
    {
        if (isset($_SESSION['session_code']) && $_SESSION['session_code'] == $_COOKIE['session_code'])
            echo $twig->render('addNews.html', array());
        else
            echo $twig->render('not_authed_form.html',array());
    }
    else
    {
        $newsArray = ReadNews();

        if ( $_GET[ 'type' ] == 2 )//href='/news.php?id={id}&type=2&'
        {
            if (isset($_SESSION['session_code']) && $_SESSION['session_code'] == $_COOKIE['session_code'])
                echo $twig->render('editNews.html', array('newsArray' => $newsArray ));
            else
                echo $twig->render('not_authed_form.html',array());
        }
        else //href='/news.php?id={id}&type=0&'
        {
            $commentsArray = array();
            $commentsArray = ReadComments();
            echo $twig->render('showNews.html', array('newsArray' => $newsArray, 'commentsArray' => $commentsArray ));
        }
    }
}
else
{
    if ( empty( $_POST[ 'newsID' ] ) )
        WriteNews( $_POST );
    else
        WriteComments( $_POST );
}

MConnection::Close();




//функция для чтения новостей
function ReadNews()
{
    $mNews = new MNews();

    //ссылки на новость должны иметь формат
    $success = $mNews->Select( $_GET[ 'id' ] );
    if ( $success )
    {
        $newsArray = array();
        $newsArray[ 'id' ] = $_GET[ 'id' ];
        $newsArray[ 'title' ] = $mNews->title;
        $newsArray[ 'summary' ] = $mNews->summary;
        $newsArray[ 'text' ] = $mNews->text;
        $newsArray[ 'newsmaker' ] = $mNews->newsmaker;
        $newsArray[ 'date' ] = $mNews->date;

        return $newsArray;
    }
    else
        echo 'News not found!';

}


//функция для записи новой новости или редактирования старой
function WriteNews( $post )
{
    $mNews = new MNews();
    $mNews->id = $post[ 'id' ];
    $mNews->title = $post[ 'title' ];
    $mNews->summary = $post[ 'summary' ];
    $mNews->text = $post[ 'text' ];

    //to do
    //установи имя пользователя в сессии в переменной userName
    $mNews->newsmaker = $_COOKIE['user_name'];

    //проверь, правильно ли я указал формат даты = null
    $mNews->date = date(null);

    if ( empty( $post[ 'id' ] ) )
        $success = $mNews->Insert();
    else
        $success = $mNews->Update();

    if ( empty( $success ) )
        echo 'Ok';
    else
        echo 'Error! ' . $success;
}

function ReadComments()
{
   $mComments = new MComments();

    //ссылки на новость должны иметь формат href='/addNews.html?id={id}'
    $success = $mComments->Select( $_GET[ 'id' ] );
    if ( $success )
    {

        return $mComments->comments;
    }
    else
        echo 'News not found!';

}

//функция для записи новой новости или редактирования старой
function WriteComments( $post )
{
    $mComments = new MComments();
    $mComments->newsID = $post[ 'newsID' ];
    $mComments->text = $post[ 'commentText' ];

    //to do
    //установи имя пользователя в сессии в переменной userName
    $mComments->newsmaker = $_COOKIE['user_name'];

    //проверь, правильно ли я указал формат даты = null
    $mComments->date = date(null);

  //  if ( empty( $post[ 'id' ] ) )
        $success = $mComments->Insert();
 /*   else
        $success = $mComments->Update();*/

    if ( empty( $success ) )
        echo 'Ok';
    else
        echo 'Error! ' . $success;
}
?>