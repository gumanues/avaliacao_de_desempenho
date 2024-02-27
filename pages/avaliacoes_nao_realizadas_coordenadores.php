<?php require_once('../conexao.php'); 

session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] == 1) {

  $param_sql = "SELECT * FROM delega_acoes";
  $param_query = mysqli_query($conexao, $param_sql);
  
  while ($param_fetch = mysqli_fetch_assoc($param_query)) {
    $ano_vigente = $param_fetch['ano_vigente'];
  }

$id_login = $_SESSION['id'];
$setor_logado = $_SESSION['setor'];


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
  <link rel="icon" type="image/x-icon" href="../img/pag.ico">
</head>

<body>

  <div>

    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="log-coord.php">Início</a>
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
  <a href="avaliacoes_usuarios_coordenadores.php?id_tipo=null&idusuario=null&id_data=null" class="btn btn-outline-secondary btn-lg m-2">Avaliação Por Usuário</a>
  <a href="avaliacoes_nao_realizadas_coordenadores.php?id_data=6&id_data=null" class="btn btn-secondary btn-lg m-2">Usuários Pendentes</a>
  </div>


  <div>
    <label class="fw-bold fs-3 d-flex justify-content-center py-3">Usuários Pendentes de Avaliação</label>
  </div>

  <div class="container py-2">
    <form action="avaliacoes_nao_realizadas_coordenadores.php" method="GET">
    <div>
    <input name="id_data" value="6" type="hidden" id="id_data" checked require>
    </div>
      <div class="mb-3">


        <label for="id_data" class="form-label pt-3">Selecione o Ano:</label>
        <select class="form-select" name="id_data" id="id_data" required>
          <option value="<?=$ano_vigente?>" hidden><?=$ano_vigente?></option>
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


          }


          $id_data = $_GET['id_data'];

          echo "<p class='fw-bold'>Colaboradores que não se auto-avaliaram:</p>";


          $delega_sql = "SELECT * FROM delega_acoes";
          $delega_query = mysqli_query($conexao, $delega_sql);

          while ($delega_acoes = mysqli_fetch_assoc($delega_query)) {


          $delega_tipo1 = $delega_acoes['rh_gerente'];

          }

          $colab = "
          
          SELECT 
          * 
          FROM usuario e 
          WHERE e.situacao = 1 
          AND (idusuario in($delega_tipo) or  lider = 0) 
          AND e.setorid = $setor_logado
              AND NOT EXISTS (
                  SELECT 1 
                  FROM colab a 
                  WHERE e.idusuario = a.idusuarios  and data = $id_data
              ) 
          order by e.nomecompleto asc

                              ";



          $id_colab = mysqli_query($conexao, $colab);
          
          while ($id_col = mysqli_fetch_assoc($id_colab)) {

          $nomecompleto_b = $id_col['nomecompleto'];


          echo "<p>$nomecompleto_b</p>";


          
          }

          echo "<hr>";
  
          echo "<p class='fw-bold' >Sem avaliação Coordenador:</p>";

          $editar_lidercoord = "
          
          SELECT 
          * 
          FROM usuario e 
          WHERE e.situacao = 1 
          AND lider = 0
          AND idusuario not in($delega_tipo1)
          AND e.setorid = $setor_logado
              AND NOT EXISTS (
                  SELECT 1 
                  FROM lidercoord c 
                  WHERE data = $id_data and e.idusuario = c.idusuarios or e.idusuario = c.idsupervisor
              )
          order by e.nomecompleto asc
      
                              ";


          $id_lidercoord = mysqli_query($conexao, $editar_lidercoord);
          
          while ($id_lidcord = mysqli_fetch_assoc($id_lidercoord)) {

          $nomecompleto_l = $id_lidcord['nomecompleto'];

          echo "<p>$nomecompleto_l</p>";


          }
  



?>
       
       <?php } else {echo "Não há registros para exibir.";} ?>


</body>



<?php } else {
  header('Location: login.php');
} ?>