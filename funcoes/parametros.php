<?php require_once('../conexao.php'); 



if (isset($_POST['flexRadioDefault'])) {
    $flexRadioDefault = $_POST['flexRadioDefault'];
} else {
    header("Location: ../pages/parametros.php?retorno=1.1");
    exit();
}

if (isset($_POST['usu_parametro'])) {
    $valores_selecionados = implode(',', $_POST['usu_parametro']);
} else {
    header("Location: ../pages/parametros.php?retorno=1.1");
    exit(); 
}





if ($flexRadioDefault == 1) {

    $comando = "UPDATE `delega_acoes` SET `avalid_reter` = '$valores_selecionados' WHERE `delega_acoes`.`id` = 1;";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/parametros.php?retorno=1");
  
}

if ($flexRadioDefault == 2) {

    $comando = "UPDATE `delega_acoes` SET `avausu_reter` = '$valores_selecionados' WHERE `delega_acoes`.`id` = 1;";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/parametros.php?retorno=1");
  
}

if ($flexRadioDefault == 3) {

    $comando = "UPDATE `delega_acoes` SET `usu_esp_colab` = '$valores_selecionados' WHERE `delega_acoes`.`id` = 1;";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/parametros.php?retorno=1");
  
}

if ($flexRadioDefault == 4) {

    $comando = "UPDATE `delega_acoes` SET `usu_com_geren` = '$valores_selecionados' WHERE `delega_acoes`.`id` = 1;";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/parametros.php?retorno=1");
  
}

if ($flexRadioDefault == 5) {

    $comando = "UPDATE `delega_acoes` SET `usu_com_geren_reter` = '$valores_selecionados' WHERE `delega_acoes`.`id` = 1;";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/parametros.php?retorno=1");
  
}

if ($flexRadioDefault == 6) {

    $comando = "UPDATE `delega_acoes` SET `geren_reter` = '$valores_selecionados' WHERE `delega_acoes`.`id` = 1;";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/parametros.php?retorno=1");
  
}

if ($flexRadioDefault == 7) {

    $comando = "UPDATE `delega_acoes` SET `acess_av_reter` = '$valores_selecionados' WHERE `delega_acoes`.`id` = 1;";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/parametros.php?retorno=1");
  
}

if ($flexRadioDefault == 8) {

    $comando = "UPDATE `delega_acoes` SET `lid_acess_lid_reter` = '$valores_selecionados' WHERE `delega_acoes`.`id` = 1;";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/parametros.php?retorno=1");
  
}

if ($flexRadioDefault == 9) {

    $comando = "UPDATE `delega_acoes` SET `lid_acess_ger_reter` = '$valores_selecionados' WHERE `delega_acoes`.`id` = 1;";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/parametros.php?retorno=1");
  
}

if ($flexRadioDefault == 10) {

    $comando = "UPDATE `delega_acoes` SET `acess_avaliacao` = '$valores_selecionados' WHERE `delega_acoes`.`id` = 1;";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/parametros.php?retorno=1");
  
}

if ($flexRadioDefault == 11) {

    $comando = "UPDATE `delega_acoes` SET `login_principal` = '$valores_selecionados' WHERE `delega_acoes`.`id` = 1;";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/parametros.php?retorno=1");
  
}

if ($flexRadioDefault == 12) {

    $comando = "UPDATE `delega_acoes` SET `gerente` = '$valores_selecionados' WHERE `delega_acoes`.`id` = 1;";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/parametros.php?retorno=1");
  
}

if ($flexRadioDefault == 13) {

    $comando = "UPDATE `delega_acoes` SET `rh_gerente` = '$valores_selecionados' WHERE `delega_acoes`.`id` = 1;";
    mysqli_query($conexao, $comando);
    header("Location: ../pages/parametros.php?retorno=1");
  
}




