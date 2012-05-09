<?php

/* not_authed_form.html */
class __TwigTemplate_b48bcec8779b499ae412c7052ff19eec extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"
        \"http://www.w3.org/TR/html4/loose.dtd\">
<html>
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\">
    <title></title>
</head>
<body>
    <form action=\"../controller/CUserController.php\" method=\"POST\">
        <p><b>Авторизация</b></p>
        <p>
            Логин
            <input type=\"text\" name=\"user_name\">
        </p>
        <p>
            Пароль
            <input type=\"password\" name=\"user_pass\">
        </p>
        <p><input type=\"checkbox\" name=\"cookie\">Запомнить меня</p>
        <input type=\"hidden\" name=\"do\" value=\"auth\">
        <p><input type=\"submit\" value=\"Войти\"></p>
    </form>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "not_authed_form.html";
    }

    public function getDebugInfo()
    {
        return array (  17 => 1,);
    }
}
