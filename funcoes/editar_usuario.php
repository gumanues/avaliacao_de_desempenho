<?php require_once('../conexao.php'); 

$idusuario = $_POST['idusuario'];
$nomecompleto = $_POST['nomecompleto'];
$situacao = $_POST['flexRadioDefault1'];
$cargo = $_POST['cargo'];
$setor = $_POST['setor'];
$senha = md5($_POST['senha']);
$lider = $_POST['flexRadioDefault'];


 if ($nomecompleto != null) { 
    $comando = "UPDATE `usuario` SET `nomecompleto` = '$nomecompleto' WHERE `usuario`.`idusuario` = $idusuario";
    mysqli_query($conexao, $comando);
    header('Location: ../pages/log-lider.php?retorno=2.2');

}
if ($cargo != null) {
    $comando = "UPDATE `usuario` SET `cargo` = '$cargo' WHERE `usuario`.`idusuario` = $idusuario";
    mysqli_query($conexao, $comando);
    header('Location: ../pages/log-lider.php?retorno=2.2');

}
if ($setor != "") {
    $comando = "UPDATE `usuario` SET `setorid` = '$setor' WHERE `usuario`.`idusuario` = $idusuario";
    mysqli_query($conexao, $comando);
    header('Location: ../pages/log-lider.php?retorno=2.2');

}
if ($senha != "d41d8cd98f00b204e9800998ecf8427e") {
    $comando = "UPDATE `usuario` SET `senha` = '$senha' WHERE `usuario`.`idusuario` = $idusuario";
    mysqli_query($conexao, $comando);
    header('Location: ../pages/log-lider.php?retorno=2.2');

}
if ($lider != 'N') {
    $comando = "UPDATE `usuario` SET `lider` = '$lider' WHERE `usuario`.`idusuario` = $idusuario";
    mysqli_query($conexao, $comando);
    header('Location: ../pages/log-lider.php?retorno=2.2');
}

if ($situacao != 'N') {
    $comando = "UPDATE `usuario` SET `situacao` = '$situacao' WHERE `usuario`.`idusuario` = $idusuario";
    mysqli_query($conexao, $comando);
    header('Location: ../pages/log-lider.php?retorno=2.2');

} 





