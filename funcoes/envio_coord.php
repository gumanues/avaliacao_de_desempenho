<?php require_once('../conexao.php'); 

$param_sql = "SELECT * FROM delega_acoes";
$param_query = mysqli_query($conexao, $param_sql);

while ($param_fetch = mysqli_fetch_assoc($param_query)) {
echo $ano_vigente = $param_fetch['ano_vigente'];
}


$sql_perguntas = "SELECT * FROM modifica_pergunta";
$id_perguntas = mysqli_query($conexao, $sql_perguntas);

while ($perguntas_fetch = mysqli_fetch_assoc($id_perguntas)) {

$pergunta_id = $perguntas_fetch['coord'];

}

$sql_col= "SELECT (
    IF(a.pergunta1 <> '', 1, 0) +
    IF(a.pergunta2 <> '', 1, 0) +
    IF(a.pergunta3 <> '', 1, 0) +
    IF(a.pergunta4 <> '', 1, 0) +
    IF(a.pergunta5 <> '', 1, 0) +
    IF(a.pergunta6 <> '', 1, 0) +
    IF(a.pergunta7 <> '', 1, 0) +
    IF(a.pergunta8 <> '', 1, 0) +
    IF(a.pergunta9 <> '', 1, 0) +
    IF(a.pergunta10 <> '', 1, 0)
  ) qt_col
  FROM pergunta a, modifica_pergunta b
  WHERE a.id = b.lidercoord
  LIMIT 1
  ";
      
  $col_query = mysqli_query($conexao, $sql_col);
  while ($fetch_col = mysqli_fetch_assoc($col_query)) {
  
  $quantidade = $fetch_col['qt_col']; 
  
  }
  

    $nota1 = $_POST['nota1'];
    $nota2 = $_POST['nota2'];
    $nota3 = $_POST['nota3'];
    $nota4 = $_POST['nota4'];
    $nota5 = ($quantidade >= 5 && $quantidade <= 10) ? $_POST['nota5'] : $_POST['nota5'];
    $nota6 = ($quantidade >= 6 && $quantidade <= 10) ? $_POST['nota6'] : $_POST['nota6'];
    $nota7 = ($quantidade >= 7 && $quantidade <= 10) ? $_POST['nota7'] : $_POST['nota7'];
    $nota8 = ($quantidade >= 8 && $quantidade <= 10) ? $_POST['nota8'] : $_POST['nota8'];
    $nota9 = ($quantidade >= 9 && $quantidade <= 10) ? $_POST['nota9'] : $_POST['nota9'];
    $nota10 = ($quantidade >= 10 && $quantidade <= 10) ? $_POST['nota10'] : $_POST['nota10'];


$selected_option = $_POST['idusuario'];
$exploded_values = explode(', ', $selected_option);

foreach ($exploded_values as $value) {
    list($key, $content) = explode(':', $value);
    
    if ($key === 'idusuario') {
       $idusuario = $content;
    } elseif ($key === 'setorid') {
       $setorid = $content;
    }
}


$data_today = date("Y");


if ($idusuario != "") {
    
    $comando = "INSERT INTO `coord` (`id`, `nota1`, `nota2`, `nota3`, `nota4`, `nota5`, `nota6`, `nota7`, `nota8`, `nota9`, `nota10`, `setor`, `data`, `idsupervisor`, `idusuarios`, `perguntaid`)
    VALUES (
        NULL, 
        NULLIF('$nota1', 0),
        NULLIF('$nota2', 0),
        NULLIF('$nota3', 0),
        NULLIF('$nota4', 0),
        NULLIF('$nota5', 0),
        NULLIF('$nota6', 0),
        NULLIF('$nota7', 0),
        NULLIF('$nota8', 0),
        NULLIF('$nota9', 0),
        NULLIF('$nota10', 0),
        '$setorid',
        '$ano_vigente',
        NULL,
        '$idusuario',
        '$pergunta_id')";
    mysqli_query($conexao, $comando);
    session_start();
    $_SESSION['usureferencia'] = $idusuario;
    header('Location: ../pages/lider-colaboradores.php?retorno=9');
    
} else {
    header('Location: ../pages/erro.php');
}
 


