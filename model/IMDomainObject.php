<?php
interface IMDomainObject
{
    function Select($attribute);
    function Insert();
    function Update();
    function Delete($id);
}
?>