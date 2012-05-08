<?php

/* register.html */
class __TwigTemplate_68382b9aa5b82414a20bf208bb1b0859 extends Twig_Template
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
    <form action=\"../controller/CController.php\" method=\"POST\">
        <p><b>�����������</b></p>
        <p>
            �����
            <input type=\"text\" name=\"login\">
        </p>
        <p>
            ������
            <input type=\"text\" name=\"password\">
        </p>
        <input type=\"hidden\" name=\"controller\" value=\"registration\">
        <p><input type=\"submit\" value=\"������������������\"></p>
    </form>
    ";
        // line 22
        if (isset($context["name"])) { $_name_ = $context["name"]; } else { $_name_ = null; }
        echo twig_escape_filter($this->env, $_name_, "html", null, true);
        echo "
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "register.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  40 => 22,  17 => 1,);
    }
}
