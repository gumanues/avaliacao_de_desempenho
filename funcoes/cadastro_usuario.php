<?php require_once('../conexao.php'); 

$nomecompleto = $_POST['nomecompleto'];
$cargo = $_POST['cargo'];
$setor = $_POST['setor'];
$senha = $_POST['senha'];
$lider = $_POST['flexRadioDefault'];


if ($nomecompleto != "") {

    $comando = "INSERT INTO `usuario` (`idusuario`, `nomecompleto`, `situacao`, `cargo`, `senha`, `lider`, `setorid`) VALUES (NULL, '$nomecompleto', '1', '$cargo', '$senha', '$lider', '$setor')";
    mysqli_query($conexao, $comando);
    header('Location: ../pages/log-lider.php?retorno=1.1');
  
} else {
    header('Location: ../pages/erro.php');
}
