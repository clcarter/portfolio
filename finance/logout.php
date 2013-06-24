<?php 
session_start();

unset($_SESSION);
unset($_POST);
session_destroy();

header('Location:index.php');
?>