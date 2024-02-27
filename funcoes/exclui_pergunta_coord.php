<?php require_once('../conexao.php'); 

$idpergunta = $_POST['idpergunta'];
$id_tipo = $_POST['id_tipo'];
$id_usuario = $_POST['id_usuario'];


if ($idpergunta != "" and $id_tipo == 1) {

    $comando = "DELETE FROM gerencia WHERE `gerencia`.`id` = $idpergunta";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/avaliacoes_lideres.php?id_tipo=6&id_tipo=$id_usuario");
  
} else {
header("Location: ../pages/avaliacoes_lideres.php?id_tipo=6&id_tipo=$id_usuario");
}

if ($idpergunta != "" and $id_tipo == 2) {

    $comando = "DELETE FROM lidercoord WHERE `lidercoord`.`id` = $idpergunta";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/avaliacoes_lideres.php?id_tipo=6&id_tipo=$id_usuario");
  
} else {
header("Location: ../pages/avaliacoes_lideres.php?id_tipo=6&id_tipo=$id_usuario");
}