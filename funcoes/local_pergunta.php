
<?php require_once('../conexao.php');


$idpergunta = $_POST['idpergunta'];
$idpergunta1 = $_POST['idpergunta1'];


if ($idpergunta != 'N' and $idpergunta != $idpergunta1) {

    $comando = "UPDATE `modifica_pergunta` SET `lidercoord` = '$idpergunta', `colab` = '$idpergunta' WHERE `modifica_pergunta`.`id` = 1";
    mysqli_query($conexao, $comando);
    header('Location: ../pages/log-lider.php?retorno=5');
    
} else {
    header('Location: ../pages/erro.php');
}


if ($idpergunta1 != 'N' and $idpergunta != $idpergunta1) {

    $comando = "UPDATE `modifica_pergunta` SET `gerencia` = '$idpergunta1', `coord` = '$idpergunta1' WHERE `modifica_pergunta`.`id` = 1";
    mysqli_query($conexao, $comando);
    header('Location: ../pages/log-lider.php?retorno=5');
    
} else {
    header('Location: ../pages/erro.php');
}
    
