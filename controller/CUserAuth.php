<?php
include_once ('..\model\MUser.php');

class CUserAuth
{
    static function Auth($userName, $userPass, $cookieChecked)
    {
        $user = new MUser();

        if (!isset($_SESSION['user_name']))
        {
            if (isset($_COOKIE['user_name']) && isset($_COOKIE['user_pass']))
            {
                $user->Select($_COOKIE['user_name']);
                if ($user->pass == $_COOKIE['user_pass'])
                {
                    $_SESSION['user_name'] = $user->name;
                    return true;
                }
                setcookie("user_name", "", time() - 3600, "/");
                setcookie("user_pass", "", time() - 3600, "/");
                setcookie("cookie", "", time() - 3600, "/");
            }
            else
            {
                $user->Select($userName);
                if ($user->pass == md5($userPass))
                {
                    $_SESSION['user_name'] = $user->name;
                    if ($cookieChecked)
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
                    return true;
                }
                else return false;
            }
        }
        return true;
    }
}
?>
