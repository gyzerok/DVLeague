<?php
session_start();
include_once ($_SERVER["DOCUMENT_ROOT"].'/model/MConnection.php');
include_once ($_SERVER["DOCUMENT_ROOT"].'/model/MUser.php');
include_once ($_SERVER["DOCUMENT_ROOT"].'/model/MNews.php');

class CUploadController
{
    static function User()
    {
        if (basename(!empty($_FILES['uploadfile']['name'])))
        {
            $uploaddir = $_SERVER["DOCUMENT_ROOT"].'/upload/user_ava/';
            $uploadfile = $uploaddir.basename($_FILES['uploadfile']['name']);
            if (copy($_FILES['uploadfile']['tmp_name'], $uploadfile))
            {
                $path = '/upload/user_ava/'.basename($_FILES['uploadfile']['name']);
                return $path;
            }
        }
        return false;
    }

    static function News()
    {
        if (basename(!empty($_FILES['uploadfile']['name'])))
        {
            $uploaddir = $_SERVER["DOCUMENT_ROOT"].'/upload/news_pic/';
            $uploadfile = $uploaddir.basename($_FILES['uploadfile']['name']);
            if (copy($_FILES['uploadfile']['tmp_name'], $uploadfile))
            {
                $path = '/upload/news_pic/'.basename($_FILES['uploadfile']['name']);
                return $path;
            }
        }
        return false;
    }

    static function Team()
    {
        if (basename(!empty($_FILES['uploadfile']['name'])))
        {
            $uploaddir = $_SERVER["DOCUMENT_ROOT"].'/upload/team_pic/';
            $uploadfile = $uploaddir.basename($_FILES['uploadfile']['name']);
            if (copy($_FILES['uploadfile']['tmp_name'], $uploadfile))
            {
                $path = '/upload/team_pic/'.basename($_FILES['uploadfile']['name']);
                return $path;
            }
        }
        return false;
    }

    static function Back()
    {
        if (!empty($_SERVER['HTTP_REFERER']))
            header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}
?>