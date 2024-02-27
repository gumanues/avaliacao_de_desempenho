<?php require_once('../conexao.php'); 

session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] == 1) {

  $param_sql = "SELECT * FROM delega_acoes";
  $param_query = mysqli_query($conexao, $param_sql);
  
  while ($param_fetch = mysqli_fetch_assoc($param_query)) {
    $ano_vigente = $param_fetch['ano_vigente'];
  }
  

$id_login = $_SESSION['id'];
$usu_login_sql = "SELECT * FROM usuario where idusuario = $id_login";
$usu_login_query = mysqli_query($conexao, $usu_login_sql);

$id_ano = $ano_vigente;
$data_ano = $id_ano ?? date('Y', strtotime(str_replace("/", "-", $data_today)));

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

  <div class="d-flex justify-content-center pt-2">
    <a href="avaliacoes.php?id_data=6&id_data=null" class="btn btn-secondary btn-lg m-2">Avaliação Geral</a>
    <a href="avaliacoes_setores.php?id_data=6&id_data=null" class="btn btn-secondary btn-lg m-2">Avaliação Por Setor</a>
    <a href="avaliacoes_usuarios.php?id_tipo=null&idusuario=null&id_data=null" class="btn btn-secondary btn-lg m-2">Avaliação Por Usuário</a>
   <a href="avaliacoes_lideres.php?idusuario=null&id_data=null" class="btn btn-secondary btn-lg m-2">Avaliação Por Liderança</a>
    <a href="avaliacoes_nao_realizadas.php?id_data=6&id_data=null" class="btn btn-outline-secondary btn-lg m-2">Usuários Pendentes</a>
  </div>


  <div>
    <label class="fw-bold fs-3 d-flex justify-content-center py-3">Usuários Pendentes de Avaliação</label>
  </div>

  <div class="container py-2">
    <form action="avaliacoes_nao_realizadas.php" method="GET">
    <div>
    <input name="id_data" value="6" type="hidden" id="id_data" checked require>
    </div>
      <div class="mb-3">


        <label for="id_data" class="form-label pt-3">Selecione o Ano:</label>
        <select class="form-select" name="id_data" id="id_data" required>
        <option value='<?=$ano_vigente?>' hidden><?=$ano_vigente?></option>
        <?php
          $ano_atual = date("Y");
          $ano_inicial = 2023;
          $ano_final = 2100;
          while ($ano_inicial <= $ano_final) {
            echo "<option value='$ano_inicial'>$ano_inicial</option>";
            $ano_inicial++;
          }
          ?>
        </select>

        <div class="d-grid gap-2 mt-3">
        <button class="btn btn-secondary" type="submit">Enviar</button>
        </div>
        </form>
      </div>



      <!-- delega tipo de usuário com acesso líder mas não aparece como colaborador na avaliação -->
<?php
          if ($_GET['id_data'] != 'null') {


          $delega_sql = "SELECT * FROM delega_acoes";
          $delega_query = mysqli_query($conexao, $delega_sql);

          while ($delega_acoes = mysqli_fetch_assoc($delega_query)) {

          $delega_tipo = $delega_acoes['usu_esp_colab'];
          $delega_tipo4 = $delega_acoes['rh_gerente'];
          $delega_tipo2 = $delega_acoes['geren_reter'];
          $delega_tipo3 = $delega_acoes['usu_com_geren'];
          $delega_tipo4 = $delega_acoes['acess_av_reter'];
          }


          $id_data = $_GET['id_data'];

          echo "<p class='fw-bold h5'>Colaboradores que não se auto-avaliaram:</p>";

          $colab = "
          SELECT 
          * 
          FROM usuario e, setor a 
          WHERE e.situacao = 1 
          AND e.setorid = a.id
          AND (idusuario in($delega_tipo) or  lider = 0) 
              AND NOT EXISTS (
                  SELECT 1 
                  FROM colab a 
                  WHERE e.idusuario = a.idusuarios  and data = $id_data
              ) 
          order by e.setorid asc
                              ";


          $id_colab = mysqli_query($conexao, $colab);
          
          while ($id_col = mysqli_fetch_assoc($id_colab)) {

          $nomecompleto_b = $id_col['nomecompleto'];
          
          $setorid_b = $id_col['setor'];

          echo "<p><strong>$setorid_b</strong> - $nomecompleto_b</p>";



          
          }

          echo "<hr>";
          echo "<p class='fw-bold h5' >Coordenadores que não se auto-avaliaram:</p>";

          $coord = "
          
          SELECT 
          * 
          FROM usuario e, setor a 
          WHERE e.situacao = 1 
          AND e.setorid = a.id
          AND (idusuario in ($delega_tipo3) or lider = 1)  
          AND idusuario NOT in($delega_tipo,$delega_tipo4) 
              AND NOT EXISTS (
                  SELECT 1 
                  FROM coord b 
                  WHERE e.idusuario = b.idusuarios and data = $id_data
              )
          order by e.setorid asc 
                              
                              ";


          $id_coord = mysqli_query($conexao, $coord);
          
          while ($id_cor = mysqli_fetch_assoc($id_coord)) {

          $nomecompleto_d = $id_cor['nomecompleto'];

          $setorid_d = $id_cor['setor'];

          echo "<p><strong>$setorid_d</strong> - $nomecompleto_d</p>";


          }

          echo "<hr>";
          echo "<p class='fw-bold h5' >Coordenadores não realizaram avaliação do Colaborador:</p>";

          $editar_lidercoord = "
          
          SELECT 
          * 
          FROM usuario e, setor a 
          WHERE e.situacao = 1 
          AND e.setorid = a.id
          AND (idusuario in($delega_tipo) or lider = 0)
              AND NOT EXISTS (
                  SELECT 1 
                  FROM lidercoord c 
                  WHERE data = $id_data and e.idusuario = c.idusuarios or e.idusuario = c.idsupervisor
              )
          order by e.setorid asc
      
                              ";


          $id_lidercoord = mysqli_query($conexao, $editar_lidercoord);
          
          while ($id_lidcord = mysqli_fetch_assoc($id_lidercoord)) {

          $nomecompleto_l = $id_lidcord['nomecompleto'];
          
          $setorid_l = $id_lidcord['setor'];

          echo "<p><strong>$setorid_l</strong> - $nomecompleto_l</p>";


          }
  
          echo "<hr>";
          echo "<p class='fw-bold h5' >Gerência não realizou Avaliação Competência Geral:</p>";

          
          $sql_perguntas1 = "SELECT * FROM modifica_pergunta";
          $id_perguntas1 = mysqli_query($conexao, $sql_perguntas1);

          while ($perguntas_fetch1 = mysqli_fetch_assoc($id_perguntas1)) {

          $pergunta_id1 = $perguntas_fetch1['colab'];
          }

          $gerencia1 = "
          
          SELECT 
          * 
          FROM usuario e, setor a 
          WHERE e.situacao = 1 
          AND e.setorid = a.id
          AND idusuario not in($delega_tipo,$delega_tipo2,$delega_tipo4)
          AND (idusuario in ($delega_tipo3) or lider = 1)  
              AND NOT EXISTS (
                  SELECT 1 
                  FROM gerencia d 
                  WHERE data = $id_data and perguntaid = $pergunta_id1 and e.idusuario = d.idusuarios or e.idusuario = d.idsupervisor 
              )
          order by e.setorid asc
                              
                              ";
     

          $id_gerencia1 = mysqli_query($conexao, $gerencia1);
          
          while ($id_ger1 = mysqli_fetch_assoc($id_gerencia1)) {

          $nomecompleto_g1 = $id_ger1['nomecompleto'];

          $setorid_g1 = $id_ger1['setor'];

          echo "<p><strong>$setorid_g1</strong> - $nomecompleto_g1</p>";


          }

          echo "<hr>";
          echo "<p class='fw-bold h5' >Gerência não realizou Avaliação Competência Liderança:</p>";

          //-----------------------

          $sql_perguntas = "SELECT * FROM modifica_pergunta";
          $id_perguntas = mysqli_query($conexao, $sql_perguntas);
  
          while ($perguntas_fetch = mysqli_fetch_assoc($id_perguntas)) {
  
          $pergunta_id = $perguntas_fetch['coord'];
          }

          $gerencia = "
          
          SELECT 
          * 
          FROM usuario e, setor a 
          WHERE e.situacao = 1 
          AND e.setorid = a.id
          AND idusuario not in ($delega_tipo,$delega_tipo2,$delega_tipo4)
          AND (idusuario in ($delega_tipo3) or lider = 1) 
              AND NOT EXISTS (
                  SELECT 1 
                  FROM gerencia d 
                  WHERE data = $id_data and perguntaid = $pergunta_id and e.idusuario = d.idusuarios or e.idusuario = d.idsupervisor
              )
          order by e.setorid asc
                              
                              ";


          $id_gerencia = mysqli_query($conexao, $gerencia);
          
          while ($id_ger = mysqli_fetch_assoc($id_gerencia)) {

          $nomecompleto_g = $id_ger['nomecompleto'];

          $setorid_g = $id_ger['setor'];

          echo "<p><strong>$setorid_g</strong> - $nomecompleto_g</p>";


          }


?>
 <?php } else {echo "Não há registros para exibir.";} ?>
       



</body>



<?php } else {
  header('Location: login.php');
} ?>