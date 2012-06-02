<?php
session_start();

include_once ($_SERVER["DOCUMENT_ROOT"].'/model/MConnection.php');
include ($_SERVER["DOCUMENT_ROOT"].'/model/MUser.php');

switch ($_POST['do'])
{
    case "reg":
        CUserController::Register($_POST);
        CUserController::Back();
        break;
    case "auth":
        CUserController::Auth($_POST);
        CUserController::Back();
        break;
    case "quit":
        CUserController::Quit();
        CUserController::Back();
        break;
}

class CUserController
{
    static function Logged()
    {
        if (isset($_SESSION['user_name']) && !empty($_SESSION['user_name']))
            return true;

        else if (isset($_COOKIE['user_name']) && isset($_COOKIE['user_pass']))
        {
            $post = NULL;
            return CUserController::Auth($post);
        }
        else return false;
    }

    static function Register($post)
    {
        MConnection::Open();

        if ($post['user_pass'] == $post['Confirm_Password'])
        {
            $user = new MUser();
            $user->Init($post['user_name'], md5(sha1($post['user_pass'])));
            $user->Insert();
        }
        //TODO Нормальная проверка существования логина, проверка повторного пароля, валидация имейла
        //TODO Подтверждение регистрации
        //TODO Подтверждение регистрации

        MConnection::Close();
    }

    static function Auth($post)
    {
        MConnection::Open();

        $user = new MUser();

        $code = md5(time() + rand(-99, 99));
        if (isset($_COOKIE['user_name']) && isset($_COOKIE['user_pass']))
        {
            $user->Select($_COOKIE['user_name']);
            if ($user->pass == $_COOKIE['user_pass'])
            {
                $_SESSION['user_name'] = $user->name;
                $_SESSION['user_id'] = $user->id;
                return true;
            }
            else
            {
                setcookie("user_name", "", time() - 3600, "/");
                setcookie("user_pass", "", time() - 3600, "/");
                return false;
            }
        }
        else
        {
            $user->Select($post['user_name']);
            if ($user->pass == md5(sha1($post['user_pass'])))
            {
                $_SESSION['user_name'] = $user->name;
                $_SESSION['user_id'] = $user->id;
                if (!empty($post['cookie']))
                {
                    setcookie("user_name", $user->name, time() + 3600 * 24 * 7, "/");
                    setcookie("user_pass", $user->pass, time() + 3600 * 24 * 7, "/");
                }
                else
                {
                    setcookie("user_name", $user->name, 0, "/");
                    setcookie("user_pass", $user->pass, 0, "/");
                }
                return true;
            }
            else return false;
        }

        MConnection::Close();
    }

    static function Quit()
    {
        setcookie("user_name", "", time() - 3600, "/");
        setcookie("user_pass", "", time() - 3600, "/");
        setcookie("cookie", "", time() - 3600, "/");
        setcookie("session_code", "", time() - 3600, "/");
        session_destroy();
    }

    static function Back()
    {
        if (!empty($_SERVER['HTTP_REFERER']))
            header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}
?>