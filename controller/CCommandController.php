<?php
include ($_SERVER["DOCUMENT_ROOT"].'\model\MCommand.php');


class CCommandController
{
    //функция для чтения новостей
    static function CreateCommand( $post )
    {
        $mCommand = new MCommand();

        //ссылки на новость должны иметь формат
        $mCommand->Init($post[ 'commandName' ], $_SESSION[ 'user_name' ]);

        $success = $mCommand->Insert();

        if ( empty( $success ) )
            echo 'Ok';
        else
            echo 'Error! ' . $success;
    }

    static function ReadCommands( )
    {
        $mCommand = new MCommand();

        //ссылки на новость должны иметь формат
        $success = $mCommand->SelectCommands();
        if ( $success )
        {
            return $mCommand->commands;
        }
        else
            echo 'Commands not found!';

    }

    static function CountNews()
    {
        $mNews = new MNews();

        return ceil( $mNews->CountNews() / 10 );
    }

    static function ReadCommandID( $id )
    {
        $mCommand = new MCommand();

        //ссылки на новость должны иметь формат
        $success = $mCommand->Select($id);
        if ( $success )
        {
            $commandArray = array();
            $commandArray[ 'id' ] = $id;
            $commandArray[ 'name' ] = $mCommand->name;
            $commandArray[ 'people' ] = explode(" ", $mCommand->people );
            $commandArray[ 'code' ] = $mCommand->code;
            $commandArray[ 'win' ] = $mCommand->win;
            $commandArray[ 'lose' ] = $mCommand->lose;
            $commandArray[ 'score' ] = $mCommand->score;
            $commandArray[ 'data' ] = $mCommand->data;

            return $commandArray;
        }
        else
            echo 'Command not found!';

    }


//функция для записи новой новости или редактирования старой
    static function SetCode( $post )
    {
        $mCommand = new MCommand();
        $mCommand->SetCode($post['commandSetID'], $post['code']);


        if ( empty( $success ) )
            echo 'Ok';
        else
            echo 'Error! ' . $success;
    }

    static function AddGamer( $post )
    {
        $mCommand = new MCommand();
        $mCommand->Select($post['commandJoinID']);

        if ( $mCommand->code == $post['code'] )
        {
            $mCommand->people = $mCommand->people.' '.$_SESSION['user_name'];
            $mCommand->Update();
        }
    }

    /*static function DeleteNews( $id )
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
/*
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
    }*/

}
