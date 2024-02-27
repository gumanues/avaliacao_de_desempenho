<?php require_once('../conexao.php'); 

session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] == 1) {
  $data_today = date("Y");

  $id_login = $_SESSION['id'];

  $usu_login_sql = "SELECT * FROM usuario where idusuario = $id_login";
  $usu_login_query = mysqli_query($conexao, $usu_login_sql);
  
  while ($usu_login_fetch = mysqli_fetch_assoc($usu_login_query)) {
  
  $usu_login = $usu_login_fetch['nomecompleto'];
  
  }
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="../css/style_login.css">
  <title>Formulário de Desempenho</title>
  <style>
  .navbar {
    position: relative;
    z-index: 2; /* Coloca a navbar acima de outros elementos */
  }

  .vertical-line {
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    border-left: 1px solid #ccc; /* Cor cinza mais clarinho */
    content: "";
    z-index: 1; /* Coloca a linha abaixo da navbar */
  }
</style>
<link rel="icon" type="image/x-icon" href="../img/pag.ico">
</head>

<body>

  <div>

    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="log-lider.php">Início</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="sair.php">Sair</a>
            </li>
          </ul>
        </div>
        <ul class="navbar-nav text-end">
                <li class="nav-item">
                  <a class="nav-link">Login: <?=$usu_login?></a>
                </li>
              </ul>
      </div>
    </nav>
  </div>


      <!-- Erros -->

  <div id="alertas">
        <?php if(isset($_GET['retorno'])==true && $_GET['retorno']==1){ ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span>Parâmetro Salvo!</span>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

  <!-- Envios -->

        <?php } if(isset($_GET['retorno'])==true && $_GET['retorno']==1.1){ ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span>Houve um problema! Talvez não foi selecionado usuário.</span>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php } ?>
  </div>

  <p class="text-center pt-2">Atenção, para alterar estes parâmetros você precisa selecionar os usuários que já estão no parâmetro e acrescentar ou remover os que deseja editar.</p>



  <div class="vertical-line"></div>



  <div class="container text-center">
  <form action="/funcoes/parametros.php" method="post">
  <div class="row">
    <div class="col pt-5">

<p class="fs-5"> Selecione os Usuários para aplicação no parâmetro </p>


<?php



    $usu_sql = "SELECT * FROM usuario where lider in(1,2)";
    $usu_query = mysqli_query($conexao, $usu_sql);
    
    while ($usu_fetch = mysqli_fetch_assoc($usu_query)) {
        $usu_edt = $usu_fetch['nomecompleto'];
        $id_edt = $usu_fetch['idusuario'];


    $usuarios = [
        ['id' => $id_edt, 'nome' => $usu_edt]
        
    ];

    foreach ($usuarios as $usuario) {
        echo '<input type="checkbox" name="usu_parametro[]" value="' . $usuario['id'] . '"> ' . $usuario['nome'] . '<br>';
    }
   
}





?>






    
    </div>

    <div class="col pt-5">
    <p class="fs-5"> Selecione o parâmetro a editar </p>

<?php

$param_sql = "SELECT * FROM delega_acoes";
$param_query = mysqli_query($conexao, $param_sql);

while ($param_fetch = mysqli_fetch_assoc($param_query)) {

    $avalid_reter = $param_fetch['avalid_reter'];
    $ds_avalid_reter = $param_fetch['ds_avalid_reter'];

    $avausu_reter = $param_fetch['avausu_reter'];
    $ds_avausu_reter = $param_fetch['ds_avausu_reter'];

    $usu_esp_colab = $param_fetch['usu_esp_colab'];
    $ds_usu_esp_colab = $param_fetch['ds_usu_esp_colab'];

    $usu_com_geren = $param_fetch['usu_com_geren'];
    $ds_usu_com_geren = $param_fetch['ds_usu_com_geren'];

    $usu_com_geren_reter = $param_fetch['usu_com_geren_reter'];
    $ds_usu_com_geren_reter = $param_fetch['ds_usu_com_geren_reter'];

    $geren_reter = $param_fetch['geren_reter'];
    $ds_geren_reter = $param_fetch['ds_geren_reter'];

    $acess_av_reter = $param_fetch['acess_av_reter'];
    $ds_acess_av_reter = $param_fetch['ds_acess_av_reter'];

    $lid_acess_lid_reter = $param_fetch['lid_acess_lid_reter'];
    $ds_lid_acess_lid_reter = $param_fetch['ds_lid_acess_lid_reter'];

    $lid_acess_ger_reter = $param_fetch['lid_acess_ger_reter'];
    $ds_lid_acess_ger_reter = $param_fetch['ds_lid_acess_ger_reter'];

    $acess_avaliacao = $param_fetch['acess_avaliacao'];
    $ds_acess_avaliacao = $param_fetch['ds_acess_avaliacao'];

    $login_principal = $param_fetch['login_principal'];
    $ds_login_principal = $param_fetch['ds_login_principal'];

    $gerente = $param_fetch['gerente'];
    $ds_gerente = $param_fetch['ds_gerente'];

    $rh_gerente = $param_fetch['rh_gerente'];
    $ds_rh_gerente = $param_fetch['ds_rh_gerente'];


}

//-------------------- Acesso Especial - Acesso gerênte especial, usuários comuns como gerência de pessoa específica da pagina (gerencia.php)

$usu_sql1 = "SELECT * FROM usuario where idusuario in($usu_com_geren)";
$usu_query1 = mysqli_query($conexao, $usu_sql1);

$nomes_completos = array();

while ($usu_fetch1 = mysqli_fetch_assoc($usu_query1)) {
    $usu_edt1 = $usu_fetch1['nomecompleto'];
    $nomes_completos[] = $usu_edt1;
} 
$nomes_concatenados = implode(', ', $nomes_completos); 




       echo "<div class='form-check'><input class='form-check-input' type='radio' value='4' name='flexRadioDefault' id='flexRadioDefault4'>
             <label class='form-check-label ms-3' for='flexRadioDefault4'>Parâmetro 1: $ds_usu_com_geren. <br> Aplicado em: $nomes_concatenados</label></div><hr>";
//-------------------- Acesso Especial - Acesso gerênte especial, usuários comuns como gerência de pessoa específica da pagina (gerencia.php)



//-------------------- Acesso Especial - Usuários destinado a avaliação do gerênte especial, depende do parâmetro 4 na página (gerencia.php)

$usu_sql1 = "SELECT * FROM usuario where idusuario in($usu_com_geren_reter)";
$usu_query1 = mysqli_query($conexao, $usu_sql1);

$nomes_completos = array();

while ($usu_fetch1 = mysqli_fetch_assoc($usu_query1)) {
    $usu_edt1 = $usu_fetch1['nomecompleto'];
    $nomes_completos[] = $usu_edt1;
} 
$nomes_concatenados = implode(', ', $nomes_completos); 




       echo "<div class='form-check'><input class='form-check-input' type='radio' value='5' name='flexRadioDefault' id='flexRadioDefault5'>
             <label class='form-check-label ms-3' for='flexRadioDefault5'>Parâmetro 2: $ds_usu_com_geren_reter. <br> Aplicado em: $nomes_concatenados</label></div><hr>";
//-------------------- Acesso Especial - Usuários destinado a avaliação do gerênte especial, depende do parâmetro 4 na página (gerencia.php)
             


 //-------------------- Avaliações Colaboradores - Usuários com acesso de gerência para aparecerem na auto-avaliação dos colaboradores da página (colaboradores.php)

 $usu_sql1 = "SELECT * FROM usuario where idusuario in($usu_esp_colab)";
 $usu_query1 = mysqli_query($conexao, $usu_sql1);
 
 $nomes_completos = array();
 
 while ($usu_fetch1 = mysqli_fetch_assoc($usu_query1)) {
     $usu_edt1 = $usu_fetch1['nomecompleto'];
     $nomes_completos[] = $usu_edt1;
 } 
 $nomes_concatenados = implode(', ', $nomes_completos); 

 


        echo "<div class='form-check'><input class='form-check-input' type='radio' value='3' name='flexRadioDefault' id='flexRadioDefault3'>
              <label class='form-check-label ms-3' for='flexRadioDefault3'>Parâmetro 3: $ds_usu_esp_colab. <br> Aplicado em: $nomes_concatenados</label></div><hr>";
//------------------- Avaliações Colaboradores - Usuários com acesso de gerência para aparecerem na auto-avaliação dos colaboradores da página (colaboradores.php)



//------------------- Auto-avaliação Coordenadores - Retem acesso coordenador de realizar a auto-avaliação, *para terceiros* na página (lider-colaboradores.php)

 $usu_sql1 = "SELECT * FROM usuario where idusuario in($acess_av_reter)";
 $usu_query1 = mysqli_query($conexao, $usu_sql1);
 
 $nomes_completos = array();
 
 while ($usu_fetch1 = mysqli_fetch_assoc($usu_query1)) {
     $usu_edt1 = $usu_fetch1['nomecompleto'];
     $nomes_completos[] = $usu_edt1;
 } 
 $nomes_concatenados = implode(', ', $nomes_completos); 

 


        echo "<div class='form-check'><input class='form-check-input' type='radio' value='7' name='flexRadioDefault' id='flexRadioDefault7'>
              <label class='form-check-label ms-3' for='flexRadioDefault7'>Parâmetro 4: $ds_acess_av_reter. <br> Aplicado em: $nomes_concatenados</label></div><hr>";
//------------------- Auto-avaliação Coordenadores - Retem acesso coordenador de realizar a auto-avaliação, *para terceiros* na página (lider-colaboradores.php)


 
 //------------------ Avaliação Gerência - Retem nome de avaliado às *Avaliações da Gerência* na página (gerencia.php) e (lider-gerencia.php)

 $usu_sql1 = "SELECT * FROM usuario where idusuario in($geren_reter)";
 $usu_query1 = mysqli_query($conexao, $usu_sql1);
 
 $nomes_completos = array();
 
 while ($usu_fetch1 = mysqli_fetch_assoc($usu_query1)) {
     $usu_edt1 = $usu_fetch1['nomecompleto'];
     $nomes_completos[] = $usu_edt1;
 } 
 $nomes_concatenados = implode(', ', $nomes_completos); 

 


        echo "<div class='form-check'><input class='form-check-input' type='radio' value='6' name='flexRadioDefault' id='flexRadioDefault6'>
              <label class='form-check-label ms-3' for='flexRadioDefault6'>Parâmetro 5: $ds_geren_reter. <br> Aplicado em: $nomes_concatenados</label></div><hr>";
 //----------------- Avaliação Gerência - Retem nome de avaliado às *Avaliações da Gerência* na página (gerencia.php) e (lider-gerencia.php)



 //----------------- Avaliação Gerência - Concede acesso total à Avaliação *Gerência avalia competência liderança* na pagina (log-lider.php)

 $usu_sql1 = "SELECT * FROM usuario where idusuario in($lid_acess_lid_reter)";
 $usu_query1 = mysqli_query($conexao, $usu_sql1);
 
 $nomes_completos = array();
 
 while ($usu_fetch1 = mysqli_fetch_assoc($usu_query1)) {
     $usu_edt1 = $usu_fetch1['nomecompleto'];
     $nomes_completos[] = $usu_edt1;
 } 
 $nomes_concatenados = implode(', ', $nomes_completos); 



        echo "<div class='form-check'><input class='form-check-input' type='radio' value='8' name='flexRadioDefault' id='flexRadioDefault8'>
              <label class='form-check-label ms-3' for='flexRadioDefault8'>Parâmetro 6: $ds_lid_acess_lid_reter. <br> Aplicado em: $nomes_concatenados</label></div><hr>";
 //------------------ Avaliação Gerência - Concede acesso total à Avaliação *Gerência avalia competência liderança* na pagina (log-lider.php)



 //------------------ Avaliação Gerência - Concede acesso parcial à Avaliação *Gerência avalia competências gerais* na página (log-lider.php)

 $usu_sql1 = "SELECT * FROM usuario where idusuario in($lid_acess_ger_reter)";
 $usu_query1 = mysqli_query($conexao, $usu_sql1);
 
 $nomes_completos = array();
 
 while ($usu_fetch1 = mysqli_fetch_assoc($usu_query1)) {
     $usu_edt1 = $usu_fetch1['nomecompleto'];
     $nomes_completos[] = $usu_edt1;
 } 
 $nomes_concatenados = implode(', ', $nomes_completos); 

 

        echo "<div class='form-check'><input class='form-check-input' type='radio' value='9' name='flexRadioDefault' id='flexRadioDefault9'>
              <label class='form-check-label ms-3' for='flexRadioDefault9'>Parâmetro 7: $ds_lid_acess_ger_reter. <br> Aplicado em: $nomes_concatenados</label></div><hr>";
//------------------ Avaliação Gerência - Concede acesso parcial à Avaliação *Gerência avalia competências gerais* na página (log-lider.php)



//------------------ Estatísticas - Retém nome do avaliado com login de Gerência na avaliação líderes da pagina (avaliacoes_lideres.php)

$usu_sql1 = "SELECT * FROM usuario where idusuario in($avalid_reter)";
$usu_query1 = mysqli_query($conexao, $usu_sql1);

$nomes_completos = array();

while ($usu_fetch1 = mysqli_fetch_assoc($usu_query1)) {
    $usu_edt1 = $usu_fetch1['nomecompleto'];
    $nomes_completos[] = $usu_edt1;
} 
$nomes_concatenados = implode(', ', $nomes_completos); 



        echo "<div class='form-check'><input class='form-check-input' type='radio' value='1' name='flexRadioDefault' id='flexRadioDefault1'>
              <label class='form-check-label ms-3' for='flexRadioDefault1'>Parâmetro 8: $ds_avalid_reter. <br> Aplicado em: $nomes_concatenados</label></div><hr>";
//------------------ Estatísticas - Retém nome do avaliado com login de Gerência na avaliação líderes da pagina (avaliacoes_lideres.php)




 //----------------- Estatísticas - Retém nome de avaliado na avaliações usuários da página (avaliacoes_usuarios.php)
 $usu_sql1 = "SELECT * FROM usuario where idusuario in($avausu_reter)";
 $usu_query1 = mysqli_query($conexao, $usu_sql1);
 
 $nomes_completos = array();
 
 while ($usu_fetch1 = mysqli_fetch_assoc($usu_query1)) {
     $usu_edt1 = $usu_fetch1['nomecompleto'];
     $nomes_completos[] = $usu_edt1;
 } 
 $nomes_concatenados = implode(', ', $nomes_completos); 



        echo "<div class='form-check'><input class='form-check-input' type='radio' value='2' name='flexRadioDefault' id='flexRadioDefault2'>
              <label class='form-check-label ms-3' for='flexRadioDefault2'>Parâmetro 9: $ds_avausu_reter. <br> Aplicado em: $nomes_concatenados</label></div><hr>";
 //----------------- Estatísticas - Retém nome de avaliado na avaliações usuários da página (avaliacoes_usuarios.php)


 //----------------- Estatísticas - Concede acesso às avaliações na página (log-lider.php)
 $usu_sql1 = "SELECT * FROM usuario where idusuario in($acess_avaliacao)";
 $usu_query1 = mysqli_query($conexao, $usu_sql1);
 
 $nomes_completos = array();
 
 while ($usu_fetch1 = mysqli_fetch_assoc($usu_query1)) {
     $usu_edt1 = $usu_fetch1['nomecompleto'];
     $nomes_completos[] = $usu_edt1;
 } 
 $nomes_concatenados = implode(', ', $nomes_completos); 



        echo "<div class='form-check'><input class='form-check-input' type='radio' value='10' name='flexRadioDefault' id='flexRadioDefault10'>
              <label class='form-check-label ms-3' for='flexRadioDefault10'>Parâmetro 10: $ds_acess_avaliacao. <br> Aplicado em: $nomes_concatenados</label></div><hr>";
 //---------------- Estatísticas - Concede acesso às avaliações na página (log-lider.php)

 
//----------------- Login - Retém acesso de usuário especifico no login 
$usu_sql1 = "SELECT * FROM usuario where idusuario in($login_principal)";
$usu_query1 = mysqli_query($conexao, $usu_sql1);

$nomes_completos = array();

while ($usu_fetch1 = mysqli_fetch_assoc($usu_query1)) {
    $usu_edt1 = $usu_fetch1['nomecompleto'];
    $nomes_completos[] = $usu_edt1;
} 
$nomes_concatenados = implode(', ', $nomes_completos); 



       echo "<div class='form-check'><input class='form-check-input' type='radio' value='11' name='flexRadioDefault' id='flexRadioDefault11'>
             <label class='form-check-label ms-3' for='flexRadioDefault11'>Parâmetro 11: $ds_login_principal. <br> Aplicado em: $nomes_concatenados</label></div><hr>";
//---------------- Estatísticas - Concede acesso às avaliações na página (log-lider.php)


//----------------- Informe a gerênte da instituição
$usu_sql1 = "SELECT * FROM usuario where idusuario in($gerente)";
$usu_query1 = mysqli_query($conexao, $usu_sql1);

$nomes_completos = array();

while ($usu_fetch1 = mysqli_fetch_assoc($usu_query1)) {
    $usu_edt1 = $usu_fetch1['nomecompleto'];
    $nomes_completos[] = $usu_edt1;
} 
$nomes_concatenados = implode(', ', $nomes_completos); 



       echo "<div class='form-check'><input class='form-check-input' type='radio' value='12' name='flexRadioDefault' id='flexRadioDefault12'>
             <label class='form-check-label ms-3' for='flexRadioDefault12'>Parâmetro 12: $ds_gerente. <br> Aplicado em: $nomes_concatenados</label></div><hr>";
//---------------- Informe a gerênte da instituição


//----------------- Informe a gerênte e RH da instituição
$usu_sql1 = "SELECT * FROM usuario where idusuario in($rh_gerente)";
$usu_query1 = mysqli_query($conexao, $usu_sql1);

$nomes_completos = array();

while ($usu_fetch1 = mysqli_fetch_assoc($usu_query1)) {
    $usu_edt1 = $usu_fetch1['nomecompleto'];
    $nomes_completos[] = $usu_edt1;
} 
$nomes_concatenados = implode(', ', $nomes_completos); 



       echo "<div class='form-check'><input class='form-check-input' type='radio' value='13' name='flexRadioDefault' id='flexRadioDefault13'>
             <label class='form-check-label ms-3' for='flexRadioDefault13'>Parâmetro 13: $ds_rh_gerente. <br> Aplicado em: $nomes_concatenados</label></div>";
//---------------- Informe a gerênte e RH da instituição



 
?>

   
    </div>

</div>
<hr>
<div class="d-grid gap-2 mt-3">
        <button class="btn btn-secondary" type="submit">Enviar</button>
</div>
<hr>
</form>
</div>







</body>



<?php } else {
  header('Location: login.php');
} ?>