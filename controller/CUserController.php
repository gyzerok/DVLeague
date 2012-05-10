<?php
session_start();

include ('..\model\MConnection.php');
include ('..\model\MUser.php');

switch ($_POST['do'])
{
    case "reg":
        Register($_POST);
        break;
    case "auth":
        Auth($_POST);
        break;
    case "quit":
        Quit();
        break;
}

function Register($post)
{
    MConnection::Open();

    $user = new MUser();
    $user->Init($post['user_name'], md5(sha1($post['user_pass'])));
    $user->Insert();

    MConnection::Close();
}

function Auth($post)
{
    MConnection::Open();

    $user = new MUser();

    $code = md5(time() + rand(-99, 99));
    if (isset($_COOKIE['user_name']) && isset($_COOKIE['user_pass']))
    {
        $user->Select($_COOKIE['user_name']);
        if ($user->pass == $_COOKIE['user_pass'])
        {
            $_SESSION['session_code'] = $code;
            setcookie("code", $code, 0, "/");
            return true;
        }
        else
        {
            setcookie("user_name", "", time() - 3600, "/");
            setcookie("user_pass", "", time() - 3600, "/");
            setcookie("cookie", "", time() - 3600, "/");
            setcookie("code", "", time() - 3600, "/");
        }
    }
    else
    {
        $user->Select($post['user_name']);
        if ($user->pass == md5(sha1($post['user_pass'])))
        {
            $_SESSION['session_code'] = $code;
            if (!empty($post['cookie']))
            {
                setcookie("user_name", $user->name, time() + 3600 * 24 * 7 * 30, "/");
                setcookie("user_pass", $user->pass, time() + 3600 * 24 * 7 * 30, "/");
                setcookie("cookie", "true", time() + 3600, "/");
            }
            else
            {
                setcookie("user_name", $user->name, 0, "/");
                setcookie("user_pass", $user->pass, 0, "/");
            }
            setcookie("code", $code, 0, "/");
            return true;
        }
        else return false;
    }

    MConnection::Close();

    return true;
}

function Quit()
{
    setcookie("user_name", "", time() - 3600, "/");
    setcookie("user_pass", "", time() - 3600, "/");
    setcookie("cookie", "", time() - 3600, "/");
    setcookie("code", "", time() - 3600, "/");
    session_destroy();
}

if (!empty($_SERVER['HTTP_REFERER']))
    header('Location: '.$_SERVER['HTTP_REFERER']);
?>