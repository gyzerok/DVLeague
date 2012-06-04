<?php
include ($_SERVER["DOCUMENT_ROOT"].'\model\MNews.php');
//include ($_SERVER["DOCUMENT_ROOT"].'\model\MComments.php');


class CNewsController
{
    //функция для чтения новостей
    static function ReadNews( $offset )
    {
        $mNews = new MNews();

        //ссылки на новость должны иметь формат
        $success = $mNews->SelectNews($offset);
        if ( $success )
        {
            return $mNews->news;
        }
        else
            echo 'News not found!';

    }

    static function CountNews()
    {
        $mNews = new MNews();

        return ceil( $mNews->CountNews() / 10 );
    }

    static function ReadNewsID( $id )
    {
        $mNews = new MNews();

        //ссылки на новость должны иметь формат
        $success = $mNews->Select($id);
        if ( $success )
        {
            $newsArray = array();
            $newsArray[ 'id' ] = $id;
            $newsArray[ 'title' ] = $mNews->title;
            $newsArray[ 'summary' ] = $mNews->summary;
            $newsArray[ 'text' ] = $mNews->text;
            $newsArray[ 'newsmaker' ] = $mNews->newsmaker;
            $newsArray[ 'date' ] = $mNews->date;
            $newsArray[ 'views' ] = $mNews->views;
            $newsArray[ 'comments' ] = $mNews->comments;

            return $newsArray;
        }
        else
            echo 'News not found!';

    }


//функция для записи новой новости или редактирования старой
    static function WriteNews( $post )
    {
        $mNews = new MNews();
        $mNews->id = $post[ 'id' ];
        $mNews->title = $post[ 'title' ];
        $mNews->summary = $post[ 'summary' ];
        $mNews->text = $post[ 'text' ];

        //to do
        //установи имя пользователя в сессии в переменной userName
        $mNews->newsmaker = $_SESSION['user_id'];

        //проверь, правильно ли я указал формат даты = null
        $mNews->date = date("m.d.y");

        if ( empty( $post[ 'id' ] ) )
            $success = $mNews->Insert();
        else
            $success = $mNews->Update();

        if ( empty( $success ) )
            echo 'Ok';
        else
            echo 'Error! ' . $success;
    }

    static function ReadComments($id)
    {
        $mComments = new MComments();

        //ссылки на новость должны иметь формат href='/addNews.html?id={id}'
        $success = $mComments->Select( $id );
        if ( $success )
        {

            return $mComments->comments;
        }
        else
            echo 'News not found!';

    }

//функция для записи новой новости или редактирования старой
    static function WriteComments( $post )
    {
        $mComments = new MComments();
        $mComments->newsID = $post[ 'newsID' ];
        $mComments->text = $post[ 'commentText' ];

        //to do
        //установи имя пользователя в сессии в переменной userName
        $mComments->newsmaker = $_SESSION['user_id'];

        //проверь, правильно ли я указал формат даты = null
        $mComments->date = date(m.d.y);

        //  if ( empty( $post[ 'id' ] ) )
        $success = $mComments->Insert();
        /*   else
      $success = $mComments->Update();*/

        if ( empty( $success ) )
            echo 'Ok';
        else
            echo 'Error! ' . $success;
    }

}
