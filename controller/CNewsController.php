<?php
include ('..\model\MNews.php');

    if ( empty( $_POST ) )
        ReadNews();
    else
        WriteNews( $_POST );




//функция для чтения новостей
    function ReadNews()
    {
        $mNews = new MNews();

        //ссылки на новость должны иметь формат href='/news.html?id={id}'
        $success = $mNews->Select( $_GET[ 'id' ] );

        if ( $success )
        {
            if ( $_GET[ 'edit' ] == 1 ) //href='/news.html?id={id}&edit=1&'
                echo 'show form';
            else
                echo 'show web page id = ' . $mNews->id;;
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