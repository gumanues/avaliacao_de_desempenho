<?php require_once('../conexao.php'); 

$senha = md5($_POST['senha']);
$checklider = $_POST['checklider'];

$selected_option = $_POST['idusuario'];
$exploded_values = explode(', ', $selected_option);

foreach ($exploded_values as $value) {
    list($key, $content) = explode(':', $value);
    
    if ($key === 'idusuario') {
       $idusuario = $content;
    } elseif ($key === 'lider') {
       $lider = $content;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['checklider']) && $_POST['checklider'] === '2') {
        $status = 2; 
    } else {
        $status = 1; 
    }
}

$sql_acesso = "SELECT * FROM usuario where idusuario = $idusuario";
$acesso = mysqli_query($conexao, $sql_acesso);

while ($login = mysqli_fetch_assoc($acesso)) {

$idusuario1 = $login['idusuario'];
$senha1 = $login['senha'];
$setor = $login['setorid'];

}


if ($idusuario == $idusuario1 and $senha == $senha1 and $status == 2 and $lider == 2) {

    session_start();
    $_SESSION['usureferencia'] = 0;
    $_SESSION['login'] = 1;
    $_SESSION['id'] = $idusuario;
    $_SESSION['setor'] = $setor;

	header('Location: ../pages/log-lider.php');


} else {
    $_SESSION['nao_autenticado'] = true;
    header('Location: ../pages/login.php?retorno=erro');
}


$delega_sql = "SELECT * FROM delega_acoes"; // acesso especial Sheila
$delega_query = mysqli_query($conexao, $delega_sql);

while ($delega_acoes = mysqli_fetch_assoc($delega_query)) {
  
      $delega_tipo = $delega_acoes['lid_acess_lid_reter'];
      $delega_tipo_array = explode(",", $delega_tipo);

}


if ($idusuario == $idusuario1 and $senha == $senha1 and $status == 1 /*Evita acesso tania como coordenadora*/  /*Usuária Tânia*/ and (in_array($idusuario1, $delega_tipo_array) or $lider == 1)) {

    session_start();
    $_SESSION['usureferencia'] = 0;
    $_SESSION['login'] = 1;
    $_SESSION['id'] = $idusuario;
    $_SESSION['setor'] = $setor;
	header('Location: ../pages/log-coord.php');	

    
} 
