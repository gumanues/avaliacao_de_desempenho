<?php require_once('../conexao.php'); 


$idpergunta = $_POST['idpergunta'];
$id_tipo = $_POST['id_tipo'];
$id_data = $_POST['id_data'];
$id_usuario = $_POST['id_usuario'];


if ($idpergunta != "" and $id_tipo == 1) {

    $comando = "DELETE FROM coord WHERE `coord`.`id` = $idpergunta";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/avaliacoes_usuarios.php?id_tipo=6&idusuario=$id_usuario&id_data=$id_data");
  
} else {
header("Location: ../pages/avaliacoes_usuarios.php?id_tipo=6&idusuario=$id_usuario&id_data=$id_data");
}

if ($idpergunta != "" and $id_tipo == 2) {

    $comando = "DELETE FROM gerencia WHERE `gerencia`.`id` = $idpergunta";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/avaliacoes_usuarios.php?id_tipo=6&idusuario=$id_usuario&id_data=$id_data");
  
} else {
header("Location: ../pages/avaliacoes_usuarios.php?id_tipo=6&idusuario=$id_usuario&id_data=$id_data");
}

if ($idpergunta != "" and $id_tipo == 3) {

    $comando = "DELETE FROM lidercoord WHERE `lidercoord`.`id` = $idpergunta";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/avaliacoes_usuarios.php?id_tipo=6&idusuario=$id_usuario&id_data=$id_data");
  
} else {
header("Location: ../pages/avaliacoes_usuarios.php?id_tipo=6&idusuario=$id_usuario&id_data=$id_data");
}

if ($idpergunta != "" and $id_tipo == 4) {

    $comando = "DELETE FROM colab WHERE `colab`.`id` = $idpergunta";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/avaliacoes_usuarios.php?id_tipo=6&idusuario=$id_usuario&id_data=$id_data");
  
} else {
header("Location: ../pages/avaliacoes_usuarios.php?id_tipo=6&idusuario=$id_usuario&id_data=$id_data");
}