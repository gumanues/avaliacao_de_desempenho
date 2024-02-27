<?php 

session_start();

unset($_SESSION['usureferencia']);
unset($_SESSION['login']);
unset($_SESSION['id']);
unset($_SESSION['setorid']);

header("Location: login.php");