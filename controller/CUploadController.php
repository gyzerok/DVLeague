<?php
session_start();
include_once ($_SERVER["DOCUMENT_ROOT"].'/model/MConnection.php');
include_once ($_SERVER["DOCUMENT_ROOT"].'/model/MUser.php');
include_once ($_SERVER["DOCUMENT_ROOT"].'/model/MNews.php');

if (!empty($_POST))
    switch($_POST['upload'])
    {
        case 'user':
            CUploadController::User($_SESSION['user_name']);
            CUploadController::Back();
            break;
        case 'news':
            CUploadController::News($_POST['id']);
            CUploadController::Back();
            break;
    }

class CUploadController
{
    static function User($name)
    {
        $uploaddir = $_SERVER["DOCUMENT_ROOT"].'/upload/user_ava/';
        $uploadfile = $uploaddir.basename($_FILES['uploadfile']['name']);
        if (copy($_FILES['uploadfile']['tmp_name'], $uploadfile))
        {
            MConnection::Open();

            $user = new MUser();
            $user->Select($name);
            $path = '/upload/user_ava/'.basename($_FILES['uploadfile']['name']);
            $user->SetAvatar($path);

            MConnection::Close();
        }
    }

    static function News($id)
    {
        $uploaddir = $_SERVER["DOCUMENT_ROOT"].'/upload/news_pic/';
        $uploadfile = $uploaddir.basename($_FILES['uploadfile']['name']);
        if (copy($_FILES['uploadfile']['tmp_name'], $uploadfile))
        {
            MConnection::Open();

            $news = new MNews();
            $news->Select($id);
            $path = '/upload/news_pic/'.basename($_FILES['uploadfile']['name']);
            $news->SetAvatar($path);

            MConnection::Close();
        }
    }

    static function Back()
    {
        if (!empty($_SERVER['HTTP_REFERER']))
            header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}
?>