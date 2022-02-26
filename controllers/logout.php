<?php 

session_start();
unset($_SESSION['key']);
unset($_SESSION['id']);
session_destroy();

header('Location: ../index');
?>