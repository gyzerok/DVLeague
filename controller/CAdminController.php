<?php
include ('..\model\MConnection.php');
include ('..\model\MInitDB.php');

MConnection::Open();
echo MInitDB::InitUser();
MConnection::Close();
?>
