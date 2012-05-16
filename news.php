<?php
session_start();
require_once '/import/twig/lib/Twig/Autoloader.php';
//include ('controller\CNewsController.php');
include ($_SERVER["DOCUMENT_ROOT"].'\model\MNews.php');
include ($_SERVER["DOCUMENT_ROOT"].'\model\MConnection.php');


Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader, array('cache' => 'twig_cache',));


$newsArray = array();

MConnection::Open();

if ( empty( $_POST ) )
    $newsArray = ReadNews();
else
    WriteNews( $_POST );

MConnection::Close();

if (isset($_SESSION['session_code']) && $_SESSION['session_code'] == $_COOKIE['session_code'])
    echo $twig->render('news.html', array('newsArray' => $newsArray ));
else
    echo $twig->render('not_authed_form.html',array());


//функция для чтения новостей
function ReadNews()
{
    $mNews = new MNews();

    //ссылки на новость должны иметь формат href='/news.html?id={id}'
    $success = $mNews->Select( $_GET[ 'id' ] );
    if ( $success )
    {
        if ( $_GET[ 'edit' ] == 1 ) //href='/news.html?id={id}&edit=1&'
        {
            $newsArray[ 'id' ] = $_GET[ 'id' ];
            $newsArray[ 'title' ] = $mNews->title;
            $newsArray[ 'summary' ] = $mNews->summary;
            $newsArray[ 'text' ] = $mNews->text;
            $newsArray[ 'newsmaker' ] = $mNews->newsmaker;
            $newsArray[ 'date' ] = $mNews->date;
        }
        else
        {
            $newsArray[ 'id' ] = $_GET[ 'id' ];
        }

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
    $mNews->newsmaker = $_SESSION[ 'userName' ];

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
?>