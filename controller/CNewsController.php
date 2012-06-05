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

        $mNews->Init($post[ 'id' ], $post[ 'title' ], $post[ 'summary' ], $post[ 'text' ], $_SESSION['user_id'], date("F j, Y g:i a") );

        if ( empty( $post[ 'id' ] ) )
            $success = $mNews->Insert();
        else
            $success = $mNews->Update();

        if ( empty( $success ) )
            echo 'Ok';
        else
            echo 'Error! ' . $success;
    }

    static function DeleteNews( $id )
    {
        $mNews = new MNews();

        $success = $mNews->Delete($id);

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

    static function WriteComments( $post )
    {
        $mComments = new MComments();

        $mComments->Init($post[ 'id' ], $post[ 'newsID' ], $post[ 'commentText' ], $_SESSION['user_id'], date("m.d.y") );

        //  if ( empty( $post[ 'id' ] ) )
        $success = $mComments->Insert();
        /*   else
      $success = $mComments->Update();*/

        if ( empty( $success ) )
            echo 'Ok';
        else
            echo 'Error! ' . $success;
    }

    static function GetPages( $count, $offset )
    {
        $pages = array();
        if( $offset <= 3 )
        {
            $pages[0] = 1;
            $pages[1] = 2;
            $pages[2] = 3;
            $pages[3] = 4;
            $pages[4] = $count;
        }
        elseif( $offset >= $count - 3 )
        {
            $pages[0] = 1;
            $pages[1] = $count - 3;
            $pages[2] = $count - 2;
            $pages[3] = $count - 1;
            $pages[4] = $count;
        }
        else
        {
            $pages[0] = 1;
            $pages[1] = $offset - 1;
            $pages[2] = $offset;
            $pages[3] = $offset + 1;
            $pages[4] = $count;
        }

        return $pages;
    }

}
