<?php 
define('HOST', '127.0.0.1:3306');
define('USUARIO', 'root');
define('SENHA', '');
define('BANCO', 'avaliacao');
 
$conexao = mysqli_connect(HOST, USUARIO, SENHA, BANCO);

mysqli_set_charset($conexao, "utf8");

$today = date("Y-m-d");
$hour = date("H-i-s");
