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
                if ($user->userPass == $_COOKIE['user_pass'])
                {
                    $_SESSION['user_name'] = $user->userName;
                    return true;
                }
                setcookie("user_name", "", time() - 3600, "/");
                setcookie("user_pass", "", time() - 3600, "/");
                setcookie("cookie", "", time() - 3600, "/");
            }
            else
            {
                $user->Select($userName);
                if ($user->userPass == md5($userPass))
                {
                    $_SESSION['user_name'] = $user->userName;
                    if ($cookieChecked)
                    {
                        setcookie("user_name", $user->userName, time() + 3600 * 24 * 7 * 30, "/");
                        setcookie("user_pass", $user->userPass, time() + 3600 * 24 * 7 * 30, "/");
                        setcookie("cookie", "true", time() + 3600, "/");
                    }
                    else
                    {
                        setcookie("user_name", $user->userName, 0, "/");
                        setcookie("user_pass", $user->userPass, 0, "/");
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
