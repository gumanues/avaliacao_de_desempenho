<?php require_once('../conexao.php'); 

session_start();


if (isset($_SESSION['login']) && $_SESSION['login'] == 1) {


    

$id_login = $_SESSION['id'];

$usu_login_sql = "SELECT * FROM usuario where idusuario = $id_login";
$usu_login_query = mysqli_query($conexao, $usu_login_sql);

while ($usu_login_fetch = mysqli_fetch_assoc($usu_login_query)) {

$usu_login = $usu_login_fetch['nomecompleto'];

}

  $param_sql = "SELECT * FROM delega_acoes";
  $param_query = mysqli_query($conexao, $param_sql);

  while ($param_fetch = mysqli_fetch_assoc($param_query)) {
    $ano_vigente = $param_fetch['ano_vigente'];
  }

  if ($_GET['id_data'] == 'null') {
    $data_ano = $ano_vigente;
  } else {
    $data_ano = $ano_vigente;
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
    <style>
    body {
    background: linear-gradient(to bottom, white, white);
}
    </style>
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
    <a href="avaliacoes_setores.php?id_data=6&id_data=null" class="btn btn-outline-secondary btn-lg m-2">Avaliação Por Setor</a>
    <a href="avaliacoes_usuarios.php?id_tipo=null&idusuario=null&id_data=null" class="btn btn-secondary btn-lg m-2">Avaliação Por Usuário</a>
    <a href="avaliacoes_lideres.php?idusuario=null&id_data=null" class="btn btn-secondary btn-lg m-2">Avaliação Por Liderança</a>
    <a href="avaliacoes_nao_realizadas.php?id_data=6&id_data=null" class="btn btn-secondary btn-lg m-2">Usuários Pendentes</a>
  </div>




  <div>
    <label class="fw-bold fs-3 d-flex justify-content-center py-3">Avaliações por Setor</label>
  </div>
  <!--   -->



  <div class="container py-2">
    <form action="avaliacoes_setores.php" method="GET">
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




  <!-- Colaborador se auto-avalia -->
  <?php
          $data = $_GET['id_data'];
          $recepcao = "



                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM colab
                      WHERE 1=1
                      AND data = $data
                      AND setor = 5
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `colab` WHERE `data` = $data AND setor = 5
                  ) a,
                  `colab` c
              WHERE 1=1
              AND c.`data` = $data
              AND c.setor = 5



          ";
          $recepcao_sql = mysqli_query($conexao, $recepcao);
          
          while ($recepcao_assoc = mysqli_fetch_assoc($recepcao_sql)) {

          $recepcao_inteiro = number_format($recepcao_assoc['nota_tt6'], 2, '.', ''); 

            
          }

          //----

          $data = $_GET['id_data'];
          $farmacia = "

          SELECT 
          nvl(
              (
                  (
                      sum(
                          nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                          nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                          nvl(c.nota9, 0) + nvl(c.nota10, 0)
                      ) / b.qt_col
                  ) / a.qtd
              ), 0
          ) nota_tt6,
          nvl(a.qtd, 0) qtd
      FROM 
          (
              SELECT 
                  (
                      IF(nota1 IS NOT NULL, 1, 0) +
                      IF(nota2 IS NOT NULL, 1, 0) +
                      IF(nota3 IS NOT NULL, 1, 0) +
                      IF(nota4 IS NOT NULL, 1, 0) +
                      IF(nota5 IS NOT NULL, 1, 0) +
                      IF(nota6 IS NOT NULL, 1, 0) +
                      IF(nota7 IS NOT NULL, 1, 0) +
                      IF(nota8 IS NOT NULL, 1, 0) +
                      IF(nota9 IS NOT NULL, 1, 0) +
                      IF(nota10 IS NOT NULL, 1, 0)
                  ) qt_col
              FROM colab
              WHERE 1=1
              AND data = $data
              AND setor = 6
              LIMIT 1
          ) b,
          (
              SELECT sum(1) qtd from `colab` WHERE `data` = $data AND setor = 6
          ) a,
          `colab` c
      WHERE 1=1
      AND c.`data` = $data
      AND c.setor = 6

          ";
          $farmacia_sql = mysqli_query($conexao, $farmacia);
          
          while ($farmacia_assoc = mysqli_fetch_assoc($farmacia_sql)) {

            $farmacia_inteiro = number_format($farmacia_assoc['nota_tt6'], 2, '.', ''); 

          }

         //----

         $data = $_GET['id_data'];
         $rh = "

         SELECT 
         nvl(
             (
                 (
                     sum(
                         nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                         nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                         nvl(c.nota9, 0) + nvl(c.nota10, 0)
                     ) / b.qt_col
                 ) / a.qtd
             ), 0
         ) nota_tt6,
         nvl(a.qtd, 0) qtd
     FROM 
         (
             SELECT 
                 (
                     IF(nota1 IS NOT NULL, 1, 0) +
                     IF(nota2 IS NOT NULL, 1, 0) +
                     IF(nota3 IS NOT NULL, 1, 0) +
                     IF(nota4 IS NOT NULL, 1, 0) +
                     IF(nota5 IS NOT NULL, 1, 0) +
                     IF(nota6 IS NOT NULL, 1, 0) +
                     IF(nota7 IS NOT NULL, 1, 0) +
                     IF(nota8 IS NOT NULL, 1, 0) +
                     IF(nota9 IS NOT NULL, 1, 0) +
                     IF(nota10 IS NOT NULL, 1, 0)
                 ) qt_col
             FROM colab
             WHERE 1=1
             AND data = $data
             AND setor = 8
             LIMIT 1
         ) b,
         (
             SELECT sum(1) qtd from `colab` WHERE `data` = $data AND setor = 8
         ) a,
         `colab` c
     WHERE 1=1
     AND c.`data` = $data
     AND c.setor = 8

         ";
         $rh_sql = mysqli_query($conexao, $rh);
         
         while ($rh_assoc = mysqli_fetch_assoc($rh_sql)) {

          $rh_inteiro = number_format($rh_assoc['nota_tt6'], 2, '.', ''); 

         
         }

                  //----

                  $data = $_GET['id_data'];
                  $ti = "
         
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM colab
                      WHERE 1=1
                      AND data = $data
                      AND setor = 9
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `colab` WHERE `data` = $data AND setor = 9
                  ) a,
                  `colab` c
              WHERE 1=1
              AND c.`data` = $data
              AND c.setor = 9
         
                  ";
                  $ti_sql = mysqli_query($conexao, $ti);
                  
                  while ($ti_assoc = mysqli_fetch_assoc($ti_sql)) {
         
                    $ti_inteiro = number_format($ti_assoc['nota_tt6'], 2, '.', ''); 
                  
                  }

                  
                  //----

                  $data = $_GET['id_data'];
                  $cc = "
         
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM colab
                      WHERE 1=1
                      AND data = $data
                      AND setor = 2
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `colab` WHERE `data` = $data AND setor = 2
                  ) a,
                  `colab` c
              WHERE 1=1
              AND c.`data` = $data
              AND c.setor = 2
         
                  ";
                  $cc_sql = mysqli_query($conexao, $cc);
                  
                  while ($cc_assoc = mysqli_fetch_assoc($cc_sql)) {
                    $qtdcc = $cc_assoc['qtd'];
                
                    $cc_inteiro = number_format($cc_assoc['nota_tt6'], 2, '.', ''); 
                  
                  }

                                    
                  //----

                  $data = $_GET['id_data'];
                  $sala_pa = "
         
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM colab
                      WHERE 1=1
                      AND data = $data
                      AND setor = 1
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `colab` WHERE `data` = $data AND setor = 1
                  ) a,
                  `colab` c
              WHERE 1=1
              AND c.`data` = $data
              AND c.setor = 1
         
                  ";
                  $sala_pa_sql = mysqli_query($conexao, $sala_pa);
                  
                  while ($sala_pa_assoc = mysqli_fetch_assoc($sala_pa_sql)) {
         
                  $sala_pa_inteiro = number_format($sala_pa_assoc['nota_tt6'], 2, '.', ''); 

                  }
                                    
                  //----

                  $data = $_GET['id_data'];
                  $faturamento = "
         
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM colab
                      WHERE 1=1
                      AND data = $data
                      AND setor = 3
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `colab` WHERE `data` = $data AND setor = 3
                  ) a,
                  `colab` c
              WHERE 1=1
              AND c.`data` = $data
              AND c.setor = 3
         
                  ";
                  $faturamento_sql = mysqli_query($conexao, $faturamento);
                  
                  while ($faturamento_assoc = mysqli_fetch_assoc($faturamento_sql)) {
         
                    $faturamento_inteiro = number_format($faturamento_assoc['nota_tt6'], 2, '.', ''); 

                  
                  }
                  //----

                  $data = $_GET['id_data'];
                  $financeiro = "
          
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM colab
                      WHERE 1=1
                      AND data = $data
                      AND setor = 11
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `colab` WHERE `data` = $data AND setor = 11
                  ) a,
                  `colab` c
              WHERE 1=1
              AND c.`data` = $data
              AND c.setor = 11
          
                  ";
                  $financeiro_sql = mysqli_query($conexao, $financeiro);
                  
                  while ($financeiro_assoc = mysqli_fetch_assoc($financeiro_sql)) {
          
                  $financeiro_inteiro = number_format($financeiro_assoc['nota_tt6'], 2, '.', ''); 
                  
                  }

                  //----

                  $data = $_GET['id_data'];
                  $qualidade = "
          
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM colab
                      WHERE 1=1
                      AND data = $data
                      AND setor = 7
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `colab` WHERE `data` = $data AND setor = 7
                  ) a,
                  `colab` c
              WHERE 1=1
              AND c.`data` = $data
              AND c.setor = 7
          
                  ";
                  $qualidade_sql = mysqli_query($conexao, $qualidade);
                  
                  while ($qualidade_assoc = mysqli_fetch_assoc($qualidade_sql)) {
          
                    $qualidade_inteiro = number_format($qualidade_assoc['nota_tt6'], 2, '.', ''); 
        
                  
                  }

                  
                  //----

                  $data = $_GET['id_data'];
                  $compras = "
          
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM colab
                      WHERE 1=1
                      AND data = $data
                      AND setor = 4
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `colab` WHERE `data` = $data AND setor = 4
                  ) a,
                  `colab` c
              WHERE 1=1
              AND c.`data` = $data
              AND c.setor = 4
          
                  ";
                  $compras_sql = mysqli_query($conexao, $compras);
                  
                  while ($compras_assoc = mysqli_fetch_assoc($compras_sql)) {
          
                  $compras_inteiro = number_format($compras_assoc['nota_tt6'], 2, '.', ''); 
                    
                 
                  }


          

          echo "   
            <div class='d-flex justify-content-center ps-5'>
            <div class='row'>

              <div class='col'>
                <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
                <script type='text/javascript'>
                  google.charts.load('current', { 'packages': ['corechart'] });
                  google.charts.setOnLoadCallback(drawChart);

                  function drawChart() {

                    var data = google.visualization.arrayToDataTable([
                      ['Task', 'Hours per Day'],
                      ['$recepcao_inteiro Recepção', $recepcao_inteiro],
                      ['$farmacia_inteiro Farmácia', $farmacia_inteiro],
                      ['$rh_inteiro Recursos Humanos', $rh_inteiro],
                      ['$ti_inteiro Tec da Informação', $ti_inteiro],
                      ['$cc_inteiro Centro Cirurgico', $cc_inteiro],
                      ['$sala_pa_inteiro Sala de Proc Amb', $sala_pa_inteiro],
                      ['$faturamento_inteiro Faturamento', $faturamento_inteiro],
                      ['$financeiro_inteiro Financeiro', $financeiro_inteiro],
                      ['$compras_inteiro Compras', $compras_inteiro],
                      ['$qualidade_inteiro Qualidade', $qualidade_inteiro]
                    ]);

                    var options = {
                      title: 'Colaborador se auto-avalia'
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('piechart1'));

                    chart.draw(data, options);
                  }
                </script>
                <div>
                  <div id='piechart1' style='width: 800px; height: 400px;'></div>
                </div>
              </div>
            </div>  
";

?>

  <!-- Colaborador se auto-avalia -->

  <!-- Coordenador avalia Colaboradore -->

      <?php
          $data3 = $_GET['id_data'];
          $recepcao1 = "


                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM lidercoord
                      WHERE 1=1
                      AND data = $data3
                      AND setor = 5
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `lidercoord` WHERE `data` = $data3 AND setor = 5
                  ) a,
                  `lidercoord` c
              WHERE 1=1
              AND c.`data` = $data3
              AND idusuarios != idsupervisor
              AND c.setor = 5




          ";
          $recepcao1_sql = mysqli_query($conexao, $recepcao1);
          
          while ($recepcao1_assoc = mysqli_fetch_assoc($recepcao1_sql)) {

          $recepcao1_inteiro = number_format($recepcao1_assoc['nota_tt6'], 2, '.', ''); 

          }

          //----

          $data = $_GET['id_data'];
          $farmacia1 = "

          SELECT 
          nvl(
              (
                  (
                      sum(
                          nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                          nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                          nvl(c.nota9, 0) + nvl(c.nota10, 0)
                      ) / b.qt_col
                  ) / a.qtd
              ), 0
          ) nota_tt6,
          nvl(a.qtd, 0) qtd
      FROM 
          (
              SELECT 
                  (
                      IF(nota1 IS NOT NULL, 1, 0) +
                      IF(nota2 IS NOT NULL, 1, 0) +
                      IF(nota3 IS NOT NULL, 1, 0) +
                      IF(nota4 IS NOT NULL, 1, 0) +
                      IF(nota5 IS NOT NULL, 1, 0) +
                      IF(nota6 IS NOT NULL, 1, 0) +
                      IF(nota7 IS NOT NULL, 1, 0) +
                      IF(nota8 IS NOT NULL, 1, 0) +
                      IF(nota9 IS NOT NULL, 1, 0) +
                      IF(nota10 IS NOT NULL, 1, 0)
                  ) qt_col
              FROM lidercoord
              WHERE 1=1
              AND data = $data3
              AND setor = 6
              LIMIT 1
          ) b,
          (
              SELECT sum(1) qtd from `lidercoord` WHERE `data` = $data3 AND setor = 6
          ) a,
          `lidercoord` c
      WHERE 1=1
      AND c.`data` = $data3
      AND c.setor = 6

          ";
          $farmacia1_sql = mysqli_query($conexao, $farmacia1);
          
          while ($farmacia1_assoc = mysqli_fetch_assoc($farmacia1_sql)) {

          $farmacia1_inteiro = number_format($farmacia1_assoc['nota_tt6'], 2, '.', ''); 

          
          }

         //----

         $data = $_GET['id_data'];
         $rh1 = "

         SELECT 
         nvl(
             (
                 (
                     sum(
                         nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                         nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                         nvl(c.nota9, 0) + nvl(c.nota10, 0)
                     ) / b.qt_col
                 ) / a.qtd
             ), 0
         ) nota_tt6,
         nvl(a.qtd, 0) qtd
     FROM 
         (
             SELECT 
                 (
                     IF(nota1 IS NOT NULL, 1, 0) +
                     IF(nota2 IS NOT NULL, 1, 0) +
                     IF(nota3 IS NOT NULL, 1, 0) +
                     IF(nota4 IS NOT NULL, 1, 0) +
                     IF(nota5 IS NOT NULL, 1, 0) +
                     IF(nota6 IS NOT NULL, 1, 0) +
                     IF(nota7 IS NOT NULL, 1, 0) +
                     IF(nota8 IS NOT NULL, 1, 0) +
                     IF(nota9 IS NOT NULL, 1, 0) +
                     IF(nota10 IS NOT NULL, 1, 0)
                 ) qt_col
             FROM lidercoord
             WHERE 1=1
             AND data = $data3
             AND setor = 8
             LIMIT 1
         ) b,
         (
             SELECT sum(1) qtd from `lidercoord` WHERE `data` = $data3 AND setor = 8
         ) a,
         `lidercoord` c
     WHERE 1=1
     AND c.`data` = $data3
     AND c.setor = 8

         ";
         $rh1_sql = mysqli_query($conexao, $rh1);
         
         while ($rh1_assoc = mysqli_fetch_assoc($rh1_sql)) {

          $rh1_inteiro = number_format($rh1_assoc['nota_tt6'], 2, '.', ''); 

         
         }

                  //----

                  $data = $_GET['id_data'];
                  $ti1 = "
         
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM lidercoord
                      WHERE 1=1
                      AND data = $data3
                      AND setor = 9
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `lidercoord` WHERE `data` = $data3 AND setor = 9
                  ) a,
                  `lidercoord` c
              WHERE 1=1
              AND c.`data` = $data3
              AND idusuarios != idsupervisor
              AND c.setor = 9
         
                  ";
                  $ti1_sql = mysqli_query($conexao, $ti1);
                  
                  while ($ti1_assoc = mysqli_fetch_assoc($ti1_sql)) {
         
                    $ti1_inteiro = number_format($ti1_assoc['nota_tt6'], 2, '.', ''); 

                  
                  }

                  
                  //----

                  $data = $_GET['id_data'];
                  $cc1 = "
         
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM lidercoord
                      WHERE 1=1
                      AND data = $data3
                      AND setor = 2
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `lidercoord` WHERE `data` = $data3 AND setor = 2
                  ) a,
                  `lidercoord` c
              WHERE 1=1
              AND c.`data` = $data3
              AND idusuarios != idsupervisor
              AND c.setor = 2
         
                  ";
                  $cc1_sql = mysqli_query($conexao, $cc1);
                  
                  while ($cc1_assoc = mysqli_fetch_assoc($cc1_sql)) {
         
                    $cc1_inteiro = number_format($cc1_assoc['nota_tt6'], 2, '.', ''); 
   
                  
                  }

                                    
                  //----

                  $data = $_GET['id_data'];
                  $sala_pa1 = "
         
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM lidercoord
                      WHERE 1=1
                      AND data = $data3
                      AND setor = 1
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `lidercoord` WHERE `data` = $data3 AND setor = 1
                  ) a,
                  `lidercoord` c
              WHERE 1=1
              AND c.`data` = $data3
              AND idusuarios != idsupervisor
              AND c.setor = 1
         
                  ";
                  $sala_pa1_sql = mysqli_query($conexao, $sala_pa1);
                  
                  while ($sala_pa1_assoc = mysqli_fetch_assoc($sala_pa1_sql)) {
         
                    $sala_pa1_inteiro = number_format($sala_pa1_assoc['nota_tt6'], 2, '.', ''); 

                  }
                                    
                  //----

                  $data = $_GET['id_data'];
                  $faturamento1 = "
         
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM lidercoord
                      WHERE 1=1
                      AND data = $data3
                      AND setor = 3
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `lidercoord` WHERE `data` = $data3 AND setor = 3
                  ) a,
                  `lidercoord` c
              WHERE 1=1
              AND c.`data` = $data3
              AND idusuarios != idsupervisor
              AND c.setor = 3
                  ";
                  $faturamento1_sql = mysqli_query($conexao, $faturamento1);
                  
                  while ($faturamento1_assoc = mysqli_fetch_assoc($faturamento1_sql)) {
         
                    $faturamento1_inteiro = number_format($faturamento1_assoc['nota_tt6'], 2, '.', ''); 

                  
                  }
                  //----

                  $data = $_GET['id_data'];
                  $financeiro1 = "
          
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM lidercoord
                      WHERE 1=1
                      AND data = $data3
                      AND setor = 11
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `lidercoord` WHERE `data` = $data3 AND setor = 11
                  ) a,
                  `lidercoord` c
              WHERE 1=1
              AND c.`data` = $data3
              AND idusuarios != idsupervisor
              AND c.setor = 11
          
                  ";
                  $financeiro1_sql = mysqli_query($conexao, $financeiro1);
                  
                  while ($financeiro1_assoc = mysqli_fetch_assoc($financeiro1_sql)) {
          
                    $financeiro1_inteiro = number_format($financeiro1_assoc['nota_tt6'], 2, '.', ''); 

                  
                  }

                  //----

                  $data = $_GET['id_data'];
                  $qualidade1 = "
          
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM lidercoord
                      WHERE 1=1
                      AND data = $data3
                      AND setor = 7
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `lidercoord` WHERE `data` = $data3 AND setor = 7
                  ) a,
                  `lidercoord` c
              WHERE 1=1
              AND c.`data` = $data3
              AND idusuarios != idsupervisor
              AND c.setor = 7
          
                  ";
                  $qualidade1_sql = mysqli_query($conexao, $qualidade1);
                  
                  while ($qualidade1_assoc = mysqli_fetch_assoc($qualidade1_sql)) {
          
                    $qualidade1_inteiro = number_format($qualidade1_assoc['nota_tt6'], 2, '.', ''); 
        
                  
                  }

                  
                  //----

                  $data = $_GET['id_data'];
                  $compras1 = "
          
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM lidercoord
                      WHERE 1=1
                      AND data = $data3
                      AND setor = 4
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `lidercoord` WHERE `data` = $data3 AND setor = 4
                  ) a,
                  `lidercoord` c
              WHERE 1=1
              AND c.`data` = $data3
              AND idusuarios != idsupervisor
              AND c.setor = 4
          
                  ";
                  $compras1_sql = mysqli_query($conexao, $compras1);
                  
                  while ($compras1_assoc = mysqli_fetch_assoc($compras1_sql)) {
          
                    $compras1_inteiro = number_format($compras1_assoc['nota_tt6'], 2, '.', ''); 
                    
                 
                  }


          

          echo "
              <div class='col'>
                <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
                <script type='text/javascript'>
                  google.charts.load('current', { 'packages': ['corechart'] });
                  google.charts.setOnLoadCallback(drawChart);

                  function drawChart() {

                    var data = google.visualization.arrayToDataTable([
                      ['Task', 'Hours per Day'],
                      ['$recepcao1_inteiro Recepção', $recepcao1_inteiro],
                      ['$farmacia1_inteiro Farmácia', $farmacia1_inteiro],
                      ['$rh1_inteiro Recursos Humanos', $rh1_inteiro],
                      ['$ti1_inteiro Tec da Informação', $ti1_inteiro],
                      ['$cc1_inteiro Centro Cirurgico', $cc1_inteiro],
                      ['$sala_pa1_inteiro Sala de Proc Amb', $sala_pa1_inteiro],
                      ['$faturamento1_inteiro Faturamento', $faturamento1_inteiro],
                      ['$financeiro1_inteiro Financeiro', $financeiro1_inteiro],
                      ['$compras1_inteiro Compras', $compras1_inteiro],
                      ['$qualidade1_inteiro Qualidade', $qualidade1_inteiro]
                    ]);

                    var options = {
                      title: 'Coordenador avalia Colaboradores'
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('piechart3'));

                    chart.draw(data, options);
                  }
                </script>
                <div>
                  <div id='piechart3' style='width: 800px; height: 400px;'></div>
                </div>
              </div>
    
";

?>

    </div>

    <div class="d-flex justify-content-center ps-5">
        <div class="row">
<!-- Coordenador avalia Colaboradore -->

<!-- Coordenador se auto-avalia  -->
<?php
$data2 = $_GET['id_data'];
$recepcao2 = "



SELECT 
    COALESCE(SUM(nvl(nota_tt6, 0)), 0)/2 AS nota_tt6,
    COALESCE(SUM(qtd), 0)/2 AS qtd
FROM (
    -- Subconsulta 1
    SELECT 
        COALESCE(
            (
                SUM(
                    COALESCE(nvl(c.nota1, 0), 0) + 
                    COALESCE(nvl(c.nota2, 0), 0) + 
                    COALESCE(nvl(c.nota3, 0), 0) + 
                    COALESCE(nvl(c.nota4, 0), 0) +
                    COALESCE(nvl(c.nota5, 0), 0) + 
                    COALESCE(nvl(c.nota6, 0), 0) + 
                    COALESCE(nvl(c.nota7, 0), 0) + 
                    COALESCE(nvl(c.nota8, 0), 0) +
                    COALESCE(nvl(c.nota9, 0), 0) + 
                    COALESCE(nvl(c.nota10, 0), 0)
                ) / b.qt_col / a.qtd
            ), 
        0) AS nota_tt6,
        COALESCE(a.qtd, 0) AS qtd
    FROM 
        (
            SELECT 
                (
                    IF(nota1 IS NOT NULL, 1, 0) +
                    IF(nota2 IS NOT NULL, 1, 0) +
                    IF(nota3 IS NOT NULL, 1, 0) +
                    IF(nota4 IS NOT NULL, 1, 0) +
                    IF(nota5 IS NOT NULL, 1, 0) +
                    IF(nota6 IS NOT NULL, 1, 0) +
                    IF(nota7 IS NOT NULL, 1, 0) +
                    IF(nota8 IS NOT NULL, 1, 0) +
                    IF(nota9 IS NOT NULL, 1, 0) +
                    IF(nota10 IS NOT NULL, 1, 0)
                ) AS qt_col
            FROM coord
            WHERE 1=1
            AND data = $data2
            AND setor = 5
            LIMIT 1
        ) b
    CROSS JOIN 
        (
            SELECT COUNT(*) AS qtd FROM coord WHERE `data` = $data2 AND setor = 5
        ) a
    LEFT JOIN `coord` c ON c.`data` = $data2 AND c.setor = 5

    UNION ALL

    -- Subconsulta 2
    SELECT 
        COALESCE(
            (
                SUM(
                    COALESCE(nvl(c.nota1, 0), 0) + 
                    COALESCE(nvl(c.nota2, 0), 0) + 
                    COALESCE(nvl(c.nota3, 0), 0) + 
                    COALESCE(nvl(c.nota4, 0), 0) +
                    COALESCE(nvl(c.nota5, 0), 0) + 
                    COALESCE(nvl(c.nota6, 0), 0) + 
                    COALESCE(nvl(c.nota7, 0), 0) + 
                    COALESCE(nvl(c.nota8, 0), 0) +
                    COALESCE(nvl(c.nota9, 0), 0) + 
                    COALESCE(nvl(c.nota10, 0), 0)
                ) / b.qt_col / a.qtd
            ), 
        0) AS nota_tt6,
        COALESCE(a.qtd, 0) AS qtd
    FROM 
        (
            SELECT 
                (
                    IF(nota1 IS NOT NULL, 1, 0) +
                    IF(nota2 IS NOT NULL, 1, 0) +
                    IF(nota3 IS NOT NULL, 1, 0) +
                    IF(nota4 IS NOT NULL, 1, 0) +
                    IF(nota5 IS NOT NULL, 1, 0) +
                    IF(nota6 IS NOT NULL, 1, 0) +
                    IF(nota7 IS NOT NULL, 1, 0) +
                    IF(nota8 IS NOT NULL, 1, 0) +
                    IF(nota9 IS NOT NULL, 1, 0) +
                    IF(nota10 IS NOT NULL, 1, 0)
                ) AS qt_col
            FROM lidercoord
            WHERE 1=1
            AND data = $data2
            AND setor = 5
            LIMIT 1
        ) b
    CROSS JOIN 
        (
            SELECT COUNT(*) AS qtd FROM `lidercoord` WHERE `data` = $data2 AND setor = 5
        ) a
    LEFT JOIN `lidercoord` c ON c.`data` = $data2 AND idusuarios = idsupervisor AND c.setor = 5
) AS combined_data




";
$recepcao2_sql = mysqli_query($conexao, $recepcao2);

while ($recepcao2_assoc = mysqli_fetch_assoc($recepcao2_sql)) {

$recepcao2_inteiro = number_format($recepcao2_assoc['nota_tt6'], 2, '.', ''); 


}

//----

$data2 = $_GET['id_data'];
$farmacia2 = "

SELECT 
    COALESCE(SUM(nvl(nota_tt6, 0)), 0)/2 AS nota_tt6,
    COALESCE(SUM(qtd), 0)/2 AS qtd
FROM (
    -- Subconsulta 1
    SELECT 
        COALESCE(
            (
                SUM(
                    COALESCE(nvl(c.nota1, 0), 0) + 
                    COALESCE(nvl(c.nota2, 0), 0) + 
                    COALESCE(nvl(c.nota3, 0), 0) + 
                    COALESCE(nvl(c.nota4, 0), 0) +
                    COALESCE(nvl(c.nota5, 0), 0) + 
                    COALESCE(nvl(c.nota6, 0), 0) + 
                    COALESCE(nvl(c.nota7, 0), 0) + 
                    COALESCE(nvl(c.nota8, 0), 0) +
                    COALESCE(nvl(c.nota9, 0), 0) + 
                    COALESCE(nvl(c.nota10, 0), 0)
                ) / b.qt_col / a.qtd
            ), 
        0) AS nota_tt6,
        COALESCE(a.qtd, 0) AS qtd
    FROM 
        (
            SELECT 
                (
                    IF(nota1 IS NOT NULL, 1, 0) +
                    IF(nota2 IS NOT NULL, 1, 0) +
                    IF(nota3 IS NOT NULL, 1, 0) +
                    IF(nota4 IS NOT NULL, 1, 0) +
                    IF(nota5 IS NOT NULL, 1, 0) +
                    IF(nota6 IS NOT NULL, 1, 0) +
                    IF(nota7 IS NOT NULL, 1, 0) +
                    IF(nota8 IS NOT NULL, 1, 0) +
                    IF(nota9 IS NOT NULL, 1, 0) +
                    IF(nota10 IS NOT NULL, 1, 0)
                ) AS qt_col
            FROM coord
            WHERE 1=1
            AND data = $data2
            AND setor = 6
            LIMIT 1
        ) b
    CROSS JOIN 
        (
            SELECT COUNT(*) AS qtd FROM coord WHERE `data` = $data2 AND setor = 6
        ) a
    LEFT JOIN `coord` c ON c.`data` = $data2 AND c.setor = 6

    UNION ALL

    -- Subconsulta 2
    SELECT 
        COALESCE(
            (
                SUM(
                    COALESCE(nvl(c.nota1, 0), 0) + 
                    COALESCE(nvl(c.nota2, 0), 0) + 
                    COALESCE(nvl(c.nota3, 0), 0) + 
                    COALESCE(nvl(c.nota4, 0), 0) +
                    COALESCE(nvl(c.nota5, 0), 0) + 
                    COALESCE(nvl(c.nota6, 0), 0) + 
                    COALESCE(nvl(c.nota7, 0), 0) + 
                    COALESCE(nvl(c.nota8, 0), 0) +
                    COALESCE(nvl(c.nota9, 0), 0) + 
                    COALESCE(nvl(c.nota10, 0), 0)
                ) / b.qt_col / a.qtd
            ), 
        0) AS nota_tt6,
        COALESCE(a.qtd, 0) AS qtd
    FROM 
        (
            SELECT 
                (
                    IF(nota1 IS NOT NULL, 1, 0) +
                    IF(nota2 IS NOT NULL, 1, 0) +
                    IF(nota3 IS NOT NULL, 1, 0) +
                    IF(nota4 IS NOT NULL, 1, 0) +
                    IF(nota5 IS NOT NULL, 1, 0) +
                    IF(nota6 IS NOT NULL, 1, 0) +
                    IF(nota7 IS NOT NULL, 1, 0) +
                    IF(nota8 IS NOT NULL, 1, 0) +
                    IF(nota9 IS NOT NULL, 1, 0) +
                    IF(nota10 IS NOT NULL, 1, 0)
                ) AS qt_col
            FROM lidercoord
            WHERE 1=1
            AND data = $data2
            AND setor = 6
            LIMIT 1
        ) b
    CROSS JOIN 
        (
            SELECT COUNT(*) AS qtd FROM `lidercoord` WHERE `data` = $data2 AND setor = 6
        ) a
    LEFT JOIN `lidercoord` c ON c.`data` = $data2 AND idusuarios = idsupervisor AND c.setor = 6
) AS combined_data

";
$farmacia2_sql = mysqli_query($conexao, $farmacia2);

while ($farmacia2_assoc = mysqli_fetch_assoc($farmacia2_sql)) {

  $farmacia2_inteiro = number_format($farmacia2_assoc['nota_tt6'], 2, '.', ''); 


}

//----

$data2 = $_GET['id_data'];
$rh2 = "

SELECT 
    COALESCE(SUM(nvl(nota_tt6, 0)), 0)/2 AS nota_tt6,
    COALESCE(SUM(qtd), 0)/2 AS qtd
FROM (
    -- Subconsulta 1
    SELECT 
        COALESCE(
            (
                SUM(
                    COALESCE(nvl(c.nota1, 0), 0) + 
                    COALESCE(nvl(c.nota2, 0), 0) + 
                    COALESCE(nvl(c.nota3, 0), 0) + 
                    COALESCE(nvl(c.nota4, 0), 0) +
                    COALESCE(nvl(c.nota5, 0), 0) + 
                    COALESCE(nvl(c.nota6, 0), 0) + 
                    COALESCE(nvl(c.nota7, 0), 0) + 
                    COALESCE(nvl(c.nota8, 0), 0) +
                    COALESCE(nvl(c.nota9, 0), 0) + 
                    COALESCE(nvl(c.nota10, 0), 0)
                ) / b.qt_col / a.qtd
            ), 
        0) AS nota_tt6,
        COALESCE(a.qtd, 0) AS qtd
    FROM 
        (
            SELECT 
                (
                    IF(nota1 IS NOT NULL, 1, 0) +
                    IF(nota2 IS NOT NULL, 1, 0) +
                    IF(nota3 IS NOT NULL, 1, 0) +
                    IF(nota4 IS NOT NULL, 1, 0) +
                    IF(nota5 IS NOT NULL, 1, 0) +
                    IF(nota6 IS NOT NULL, 1, 0) +
                    IF(nota7 IS NOT NULL, 1, 0) +
                    IF(nota8 IS NOT NULL, 1, 0) +
                    IF(nota9 IS NOT NULL, 1, 0) +
                    IF(nota10 IS NOT NULL, 1, 0)
                ) AS qt_col
            FROM coord
            WHERE 1=1
            AND data = $data2
            AND setor = 8
            LIMIT 1
        ) b
    CROSS JOIN 
        (
            SELECT COUNT(*) AS qtd FROM coord WHERE `data` = $data2 AND setor = 8
        ) a
    LEFT JOIN `coord` c ON c.`data` = $data2 AND c.setor = 8

    UNION ALL

    -- Subconsulta 2
    SELECT 
        COALESCE(
            (
                SUM(
                    COALESCE(nvl(c.nota1, 0), 0) + 
                    COALESCE(nvl(c.nota2, 0), 0) + 
                    COALESCE(nvl(c.nota3, 0), 0) + 
                    COALESCE(nvl(c.nota4, 0), 0) +
                    COALESCE(nvl(c.nota5, 0), 0) + 
                    COALESCE(nvl(c.nota6, 0), 0) + 
                    COALESCE(nvl(c.nota7, 0), 0) + 
                    COALESCE(nvl(c.nota8, 0), 0) +
                    COALESCE(nvl(c.nota9, 0), 0) + 
                    COALESCE(nvl(c.nota10, 0), 0)
                ) / b.qt_col / a.qtd
            ), 
        0) AS nota_tt6,
        COALESCE(a.qtd, 0) AS qtd
    FROM 
        (
            SELECT 
                (
                    IF(nota1 IS NOT NULL, 1, 0) +
                    IF(nota2 IS NOT NULL, 1, 0) +
                    IF(nota3 IS NOT NULL, 1, 0) +
                    IF(nota4 IS NOT NULL, 1, 0) +
                    IF(nota5 IS NOT NULL, 1, 0) +
                    IF(nota6 IS NOT NULL, 1, 0) +
                    IF(nota7 IS NOT NULL, 1, 0) +
                    IF(nota8 IS NOT NULL, 1, 0) +
                    IF(nota9 IS NOT NULL, 1, 0) +
                    IF(nota10 IS NOT NULL, 1, 0)
                ) AS qt_col
            FROM lidercoord
            WHERE 1=1
            AND data = $data2
            AND setor = 8
            LIMIT 1
        ) b
    CROSS JOIN 
        (
            SELECT COUNT(*) AS qtd FROM `lidercoord` WHERE `data` = $data2 AND setor = 8
        ) a
    LEFT JOIN `lidercoord` c ON c.`data` = $data2 AND idusuarios = idsupervisor AND c.setor = 8
) AS combined_data

";
$rh2_sql = mysqli_query($conexao, $rh2);

while ($rh2_assoc = mysqli_fetch_assoc($rh2_sql)) {

$rh2_inteiro = number_format($rh2_assoc['nota_tt6'], 2, '.', ''); 


}

        //----

        $data2 = $_GET['id_data'];
        $ti2 = "

        SELECT 
        COALESCE(SUM(nvl(nota_tt6, 0)), 0)/2 AS nota_tt6,
        COALESCE(SUM(qtd), 0)/2 AS qtd
    FROM (
        -- Subconsulta 1
        SELECT 
            COALESCE(
                (
                    SUM(
                        COALESCE(nvl(c.nota1, 0), 0) + 
                        COALESCE(nvl(c.nota2, 0), 0) + 
                        COALESCE(nvl(c.nota3, 0), 0) + 
                        COALESCE(nvl(c.nota4, 0), 0) +
                        COALESCE(nvl(c.nota5, 0), 0) + 
                        COALESCE(nvl(c.nota6, 0), 0) + 
                        COALESCE(nvl(c.nota7, 0), 0) + 
                        COALESCE(nvl(c.nota8, 0), 0) +
                        COALESCE(nvl(c.nota9, 0), 0) + 
                        COALESCE(nvl(c.nota10, 0), 0)
                    ) / b.qt_col / a.qtd
                ), 
            0) AS nota_tt6,
            COALESCE(a.qtd, 0) AS qtd
        FROM 
            (
                SELECT 
                    (
                        IF(nota1 IS NOT NULL, 1, 0) +
                        IF(nota2 IS NOT NULL, 1, 0) +
                        IF(nota3 IS NOT NULL, 1, 0) +
                        IF(nota4 IS NOT NULL, 1, 0) +
                        IF(nota5 IS NOT NULL, 1, 0) +
                        IF(nota6 IS NOT NULL, 1, 0) +
                        IF(nota7 IS NOT NULL, 1, 0) +
                        IF(nota8 IS NOT NULL, 1, 0) +
                        IF(nota9 IS NOT NULL, 1, 0) +
                        IF(nota10 IS NOT NULL, 1, 0)
                    ) AS qt_col
                FROM coord
                WHERE 1=1
                AND data = $data2
                AND setor = 9
                LIMIT 1
            ) b
        CROSS JOIN 
            (
                SELECT COUNT(*) AS qtd FROM coord WHERE `data` = $data2 AND setor = 9
            ) a
        LEFT JOIN `coord` c ON c.`data` = $data2 AND c.setor = 9
    
        UNION ALL
    
        -- Subconsulta 2
        SELECT 
            COALESCE(
                (
                    SUM(
                        COALESCE(nvl(c.nota1, 0), 0) + 
                        COALESCE(nvl(c.nota2, 0), 0) + 
                        COALESCE(nvl(c.nota3, 0), 0) + 
                        COALESCE(nvl(c.nota4, 0), 0) +
                        COALESCE(nvl(c.nota5, 0), 0) + 
                        COALESCE(nvl(c.nota6, 0), 0) + 
                        COALESCE(nvl(c.nota7, 0), 0) + 
                        COALESCE(nvl(c.nota8, 0), 0) +
                        COALESCE(nvl(c.nota9, 0), 0) + 
                        COALESCE(nvl(c.nota10, 0), 0)
                    ) / b.qt_col / a.qtd
                ), 
            0) AS nota_tt6,
            COALESCE(a.qtd, 0) AS qtd
        FROM 
            (
                SELECT 
                    (
                        IF(nota1 IS NOT NULL, 1, 0) +
                        IF(nota2 IS NOT NULL, 1, 0) +
                        IF(nota3 IS NOT NULL, 1, 0) +
                        IF(nota4 IS NOT NULL, 1, 0) +
                        IF(nota5 IS NOT NULL, 1, 0) +
                        IF(nota6 IS NOT NULL, 1, 0) +
                        IF(nota7 IS NOT NULL, 1, 0) +
                        IF(nota8 IS NOT NULL, 1, 0) +
                        IF(nota9 IS NOT NULL, 1, 0) +
                        IF(nota10 IS NOT NULL, 1, 0)
                    ) AS qt_col
                FROM lidercoord
                WHERE 1=1
                AND data = $data2
                AND setor = 9
                LIMIT 1
            ) b
        CROSS JOIN 
            (
                SELECT COUNT(*) AS qtd FROM `lidercoord` WHERE `data` = $data2 AND setor = 9
            ) a
        LEFT JOIN `lidercoord` c ON c.`data` = $data2 AND idusuarios = idsupervisor AND c.setor = 9
    ) AS combined_data

        ";
        $ti2_sql = mysqli_query($conexao, $ti2);
        
        while ($ti2_assoc = mysqli_fetch_assoc($ti2_sql)) {

          $ti2_inteiro = number_format($ti2_assoc['nota_tt6'], 2, '.', '');  

        
        }

        
        //----

        $data2 = $_GET['id_data'];
        $cc2 = "

        SELECT 
        COALESCE(SUM(nvl(nota_tt6, 0)), 0)/2 AS nota_tt6,
        COALESCE(SUM(qtd), 0)/2 AS qtd
    FROM (
        -- Subconsulta 1
        SELECT 
            COALESCE(
                (
                    SUM(
                        COALESCE(nvl(c.nota1, 0), 0) + 
                        COALESCE(nvl(c.nota2, 0), 0) + 
                        COALESCE(nvl(c.nota3, 0), 0) + 
                        COALESCE(nvl(c.nota4, 0), 0) +
                        COALESCE(nvl(c.nota5, 0), 0) + 
                        COALESCE(nvl(c.nota6, 0), 0) + 
                        COALESCE(nvl(c.nota7, 0), 0) + 
                        COALESCE(nvl(c.nota8, 0), 0) +
                        COALESCE(nvl(c.nota9, 0), 0) + 
                        COALESCE(nvl(c.nota10, 0), 0)
                    ) / b.qt_col / a.qtd
                ), 
            0) AS nota_tt6,
            COALESCE(a.qtd, 0) AS qtd
        FROM 
            (
                SELECT 
                    (
                        IF(nota1 IS NOT NULL, 1, 0) +
                        IF(nota2 IS NOT NULL, 1, 0) +
                        IF(nota3 IS NOT NULL, 1, 0) +
                        IF(nota4 IS NOT NULL, 1, 0) +
                        IF(nota5 IS NOT NULL, 1, 0) +
                        IF(nota6 IS NOT NULL, 1, 0) +
                        IF(nota7 IS NOT NULL, 1, 0) +
                        IF(nota8 IS NOT NULL, 1, 0) +
                        IF(nota9 IS NOT NULL, 1, 0) +
                        IF(nota10 IS NOT NULL, 1, 0)
                    ) AS qt_col
                FROM coord
                WHERE 1=1
                AND data = $data2
                AND setor = 2
                LIMIT 1
            ) b
        CROSS JOIN 
            (
                SELECT COUNT(*) AS qtd FROM coord WHERE `data` = $data2 AND setor = 2
            ) a
        LEFT JOIN `coord` c ON c.`data` = $data2 AND c.setor = 2
    
        UNION ALL
    
        -- Subconsulta 2
        SELECT 
            COALESCE(
                (
                    SUM(
                        COALESCE(nvl(c.nota1, 0), 0) + 
                        COALESCE(nvl(c.nota2, 0), 0) + 
                        COALESCE(nvl(c.nota3, 0), 0) + 
                        COALESCE(nvl(c.nota4, 0), 0) +
                        COALESCE(nvl(c.nota5, 0), 0) + 
                        COALESCE(nvl(c.nota6, 0), 0) + 
                        COALESCE(nvl(c.nota7, 0), 0) + 
                        COALESCE(nvl(c.nota8, 0), 0) +
                        COALESCE(nvl(c.nota9, 0), 0) + 
                        COALESCE(nvl(c.nota10, 0), 0)
                    ) / b.qt_col / a.qtd
                ), 
            0) AS nota_tt6,
            COALESCE(a.qtd, 0) AS qtd
        FROM 
            (
                SELECT 
                    (
                        IF(nota1 IS NOT NULL, 1, 0) +
                        IF(nota2 IS NOT NULL, 1, 0) +
                        IF(nota3 IS NOT NULL, 1, 0) +
                        IF(nota4 IS NOT NULL, 1, 0) +
                        IF(nota5 IS NOT NULL, 1, 0) +
                        IF(nota6 IS NOT NULL, 1, 0) +
                        IF(nota7 IS NOT NULL, 1, 0) +
                        IF(nota8 IS NOT NULL, 1, 0) +
                        IF(nota9 IS NOT NULL, 1, 0) +
                        IF(nota10 IS NOT NULL, 1, 0)
                    ) AS qt_col
                FROM lidercoord
                WHERE 1=1
                AND data = $data2
                AND setor = 2
                LIMIT 1
            ) b
        CROSS JOIN 
            (
                SELECT COUNT(*) AS qtd FROM `lidercoord` WHERE `data` = $data2 AND setor = 2
            ) a
        LEFT JOIN `lidercoord` c ON c.`data` = $data2 AND idusuarios = idsupervisor AND c.setor = 2
    ) AS combined_data

        ";
        $cc2_sql = mysqli_query($conexao, $cc2);
        
        while ($cc2_assoc = mysqli_fetch_assoc($cc2_sql)) {

          $cc2_inteiro = number_format($cc2_assoc['nota_tt6'], 2, '.', ''); 

        
        }

                          
        //----

        $data2 = $_GET['id_data'];
        $sala_pa2 = "

        SELECT 
        COALESCE(SUM(nvl(nota_tt6, 0)), 0)/2 AS nota_tt6,
        COALESCE(SUM(qtd), 0)/2 AS qtd
    FROM (
        -- Subconsulta 1
        SELECT 
            COALESCE(
                (
                    SUM(
                        COALESCE(nvl(c.nota1, 0), 0) + 
                        COALESCE(nvl(c.nota2, 0), 0) + 
                        COALESCE(nvl(c.nota3, 0), 0) + 
                        COALESCE(nvl(c.nota4, 0), 0) +
                        COALESCE(nvl(c.nota5, 0), 0) + 
                        COALESCE(nvl(c.nota6, 0), 0) + 
                        COALESCE(nvl(c.nota7, 0), 0) + 
                        COALESCE(nvl(c.nota8, 0), 0) +
                        COALESCE(nvl(c.nota9, 0), 0) + 
                        COALESCE(nvl(c.nota10, 0), 0)
                    ) / b.qt_col / a.qtd
                ), 
            0) AS nota_tt6,
            COALESCE(a.qtd, 0) AS qtd
        FROM 
            (
                SELECT 
                    (
                        IF(nota1 IS NOT NULL, 1, 0) +
                        IF(nota2 IS NOT NULL, 1, 0) +
                        IF(nota3 IS NOT NULL, 1, 0) +
                        IF(nota4 IS NOT NULL, 1, 0) +
                        IF(nota5 IS NOT NULL, 1, 0) +
                        IF(nota6 IS NOT NULL, 1, 0) +
                        IF(nota7 IS NOT NULL, 1, 0) +
                        IF(nota8 IS NOT NULL, 1, 0) +
                        IF(nota9 IS NOT NULL, 1, 0) +
                        IF(nota10 IS NOT NULL, 1, 0)
                    ) AS qt_col
                FROM coord
                WHERE 1=1
                AND data = $data2
                AND setor = 1
                LIMIT 1
            ) b
        CROSS JOIN 
            (
                SELECT COUNT(*) AS qtd FROM coord WHERE `data` = $data2 AND setor = 1
            ) a
        LEFT JOIN `coord` c ON c.`data` = $data2 AND c.setor = 1
    
        UNION ALL
    
        -- Subconsulta 2
        SELECT 
            COALESCE(
                (
                    SUM(
                        COALESCE(nvl(c.nota1, 0), 0) + 
                        COALESCE(nvl(c.nota2, 0), 0) + 
                        COALESCE(nvl(c.nota3, 0), 0) + 
                        COALESCE(nvl(c.nota4, 0), 0) +
                        COALESCE(nvl(c.nota5, 0), 0) + 
                        COALESCE(nvl(c.nota6, 0), 0) + 
                        COALESCE(nvl(c.nota7, 0), 0) + 
                        COALESCE(nvl(c.nota8, 0), 0) +
                        COALESCE(nvl(c.nota9, 0), 0) + 
                        COALESCE(nvl(c.nota10, 0), 0)
                    ) / b.qt_col / a.qtd
                ), 
            0) AS nota_tt6,
            COALESCE(a.qtd, 0) AS qtd
        FROM 
            (
                SELECT 
                    (
                        IF(nota1 IS NOT NULL, 1, 0) +
                        IF(nota2 IS NOT NULL, 1, 0) +
                        IF(nota3 IS NOT NULL, 1, 0) +
                        IF(nota4 IS NOT NULL, 1, 0) +
                        IF(nota5 IS NOT NULL, 1, 0) +
                        IF(nota6 IS NOT NULL, 1, 0) +
                        IF(nota7 IS NOT NULL, 1, 0) +
                        IF(nota8 IS NOT NULL, 1, 0) +
                        IF(nota9 IS NOT NULL, 1, 0) +
                        IF(nota10 IS NOT NULL, 1, 0)
                    ) AS qt_col
                FROM lidercoord
                WHERE 1=1
                AND data = $data2
                AND setor = 1
                LIMIT 1
            ) b
        CROSS JOIN 
            (
                SELECT COUNT(*) AS qtd FROM `lidercoord` WHERE `data` = $data2 AND setor = 1
            ) a
        LEFT JOIN `lidercoord` c ON c.`data` = $data2 AND idusuarios = idsupervisor AND c.setor = 1
    ) AS combined_data

        ";
        $sala_pa2_sql = mysqli_query($conexao, $sala_pa2);
        
        while ($sala_pa2_assoc = mysqli_fetch_assoc($sala_pa2_sql)) {

          $sala_pa2_inteiro = number_format($sala_pa2_assoc['nota_tt6'], 2, '.', ''); 
        }
                          
        //----

        $data2 = $_GET['id_data'];
        $faturamento2 = "

        SELECT 
        COALESCE(SUM(nvl(nota_tt6, 0)), 0)/2 AS nota_tt6,
        COALESCE(SUM(qtd), 0)/2 AS qtd
    FROM (
        -- Subconsulta 1
        SELECT 
            COALESCE(
                (
                    SUM(
                        COALESCE(nvl(c.nota1, 0), 0) + 
                        COALESCE(nvl(c.nota2, 0), 0) + 
                        COALESCE(nvl(c.nota3, 0), 0) + 
                        COALESCE(nvl(c.nota4, 0), 0) +
                        COALESCE(nvl(c.nota5, 0), 0) + 
                        COALESCE(nvl(c.nota6, 0), 0) + 
                        COALESCE(nvl(c.nota7, 0), 0) + 
                        COALESCE(nvl(c.nota8, 0), 0) +
                        COALESCE(nvl(c.nota9, 0), 0) + 
                        COALESCE(nvl(c.nota10, 0), 0)
                    ) / b.qt_col / a.qtd
                ), 
            0) AS nota_tt6,
            COALESCE(a.qtd, 0) AS qtd
        FROM 
            (
                SELECT 
                    (
                        IF(nota1 IS NOT NULL, 1, 0) +
                        IF(nota2 IS NOT NULL, 1, 0) +
                        IF(nota3 IS NOT NULL, 1, 0) +
                        IF(nota4 IS NOT NULL, 1, 0) +
                        IF(nota5 IS NOT NULL, 1, 0) +
                        IF(nota6 IS NOT NULL, 1, 0) +
                        IF(nota7 IS NOT NULL, 1, 0) +
                        IF(nota8 IS NOT NULL, 1, 0) +
                        IF(nota9 IS NOT NULL, 1, 0) +
                        IF(nota10 IS NOT NULL, 1, 0)
                    ) AS qt_col
                FROM coord
                WHERE 1=1
                AND data = $data2
                AND setor = 3
                LIMIT 1
            ) b
        CROSS JOIN 
            (
                SELECT COUNT(*) AS qtd FROM coord WHERE `data` = $data2 AND setor = 3
            ) a
        LEFT JOIN `coord` c ON c.`data` = $data2 AND c.setor = 3
    
        UNION ALL
    
        -- Subconsulta 2
        SELECT 
            COALESCE(
                (
                    SUM(
                        COALESCE(nvl(c.nota1, 0), 0) + 
                        COALESCE(nvl(c.nota2, 0), 0) + 
                        COALESCE(nvl(c.nota3, 0), 0) + 
                        COALESCE(nvl(c.nota4, 0), 0) +
                        COALESCE(nvl(c.nota5, 0), 0) + 
                        COALESCE(nvl(c.nota6, 0), 0) + 
                        COALESCE(nvl(c.nota7, 0), 0) + 
                        COALESCE(nvl(c.nota8, 0), 0) +
                        COALESCE(nvl(c.nota9, 0), 0) + 
                        COALESCE(nvl(c.nota10, 0), 0)
                    ) / b.qt_col / a.qtd
                ), 
            0) AS nota_tt6,
            COALESCE(a.qtd, 0) AS qtd
        FROM 
            (
                SELECT 
                    (
                        IF(nota1 IS NOT NULL, 1, 0) +
                        IF(nota2 IS NOT NULL, 1, 0) +
                        IF(nota3 IS NOT NULL, 1, 0) +
                        IF(nota4 IS NOT NULL, 1, 0) +
                        IF(nota5 IS NOT NULL, 1, 0) +
                        IF(nota6 IS NOT NULL, 1, 0) +
                        IF(nota7 IS NOT NULL, 1, 0) +
                        IF(nota8 IS NOT NULL, 1, 0) +
                        IF(nota9 IS NOT NULL, 1, 0) +
                        IF(nota10 IS NOT NULL, 1, 0)
                    ) AS qt_col
                FROM lidercoord
                WHERE 1=1
                AND data = $data2
                AND setor = 3
                LIMIT 1
            ) b
        CROSS JOIN 
            (
                SELECT COUNT(*) AS qtd FROM `lidercoord` WHERE `data` = $data2 AND setor = 3
            ) a
        LEFT JOIN `lidercoord` c ON c.`data` = $data2 AND idusuarios = idsupervisor AND c.setor = 3
    ) AS combined_data
        ";
        $faturamento2_sql = mysqli_query($conexao, $faturamento2);
        
        while ($faturamento2_assoc = mysqli_fetch_assoc($faturamento2_sql)) {

          $faturamento2_inteiro = number_format($faturamento2_assoc['nota_tt6'], 2, '.', '');  

        
        }
        //----

        $data2 = $_GET['id_data'];
        $financeiro2 = "

        SELECT 
        COALESCE(SUM(nvl(nota_tt6, 0)), 0)/2 AS nota_tt6,
        COALESCE(SUM(qtd), 0)/2 AS qtd
    FROM (
        -- Subconsulta 1
        SELECT 
            COALESCE(
                (
                    SUM(
                        COALESCE(nvl(c.nota1, 0), 0) + 
                        COALESCE(nvl(c.nota2, 0), 0) + 
                        COALESCE(nvl(c.nota3, 0), 0) + 
                        COALESCE(nvl(c.nota4, 0), 0) +
                        COALESCE(nvl(c.nota5, 0), 0) + 
                        COALESCE(nvl(c.nota6, 0), 0) + 
                        COALESCE(nvl(c.nota7, 0), 0) + 
                        COALESCE(nvl(c.nota8, 0), 0) +
                        COALESCE(nvl(c.nota9, 0), 0) + 
                        COALESCE(nvl(c.nota10, 0), 0)
                    ) / b.qt_col / a.qtd
                ), 
            0) AS nota_tt6,
            COALESCE(a.qtd, 0) AS qtd
        FROM 
            (
                SELECT 
                    (
                        IF(nota1 IS NOT NULL, 1, 0) +
                        IF(nota2 IS NOT NULL, 1, 0) +
                        IF(nota3 IS NOT NULL, 1, 0) +
                        IF(nota4 IS NOT NULL, 1, 0) +
                        IF(nota5 IS NOT NULL, 1, 0) +
                        IF(nota6 IS NOT NULL, 1, 0) +
                        IF(nota7 IS NOT NULL, 1, 0) +
                        IF(nota8 IS NOT NULL, 1, 0) +
                        IF(nota9 IS NOT NULL, 1, 0) +
                        IF(nota10 IS NOT NULL, 1, 0)
                    ) AS qt_col
                FROM coord
                WHERE 1=1
                AND data = $data2
                AND setor = 11
                LIMIT 1
            ) b
        CROSS JOIN 
            (
                SELECT COUNT(*) AS qtd FROM coord WHERE `data` = $data2 AND setor = 11
            ) a
        LEFT JOIN `coord` c ON c.`data` = $data2 AND c.setor = 11
    
        UNION ALL
    
        -- Subconsulta 2
        SELECT 
            COALESCE(
                (
                    SUM(
                        COALESCE(nvl(c.nota1, 0), 0) + 
                        COALESCE(nvl(c.nota2, 0), 0) + 
                        COALESCE(nvl(c.nota3, 0), 0) + 
                        COALESCE(nvl(c.nota4, 0), 0) +
                        COALESCE(nvl(c.nota5, 0), 0) + 
                        COALESCE(nvl(c.nota6, 0), 0) + 
                        COALESCE(nvl(c.nota7, 0), 0) + 
                        COALESCE(nvl(c.nota8, 0), 0) +
                        COALESCE(nvl(c.nota9, 0), 0) + 
                        COALESCE(nvl(c.nota10, 0), 0)
                    ) / b.qt_col / a.qtd
                ), 
            0) AS nota_tt6,
            COALESCE(a.qtd, 0) AS qtd
        FROM 
            (
                SELECT 
                    (
                        IF(nota1 IS NOT NULL, 1, 0) +
                        IF(nota2 IS NOT NULL, 1, 0) +
                        IF(nota3 IS NOT NULL, 1, 0) +
                        IF(nota4 IS NOT NULL, 1, 0) +
                        IF(nota5 IS NOT NULL, 1, 0) +
                        IF(nota6 IS NOT NULL, 1, 0) +
                        IF(nota7 IS NOT NULL, 1, 0) +
                        IF(nota8 IS NOT NULL, 1, 0) +
                        IF(nota9 IS NOT NULL, 1, 0) +
                        IF(nota10 IS NOT NULL, 1, 0)
                    ) AS qt_col
                FROM lidercoord
                WHERE 1=1
                AND data = $data2
                AND setor = 11
                LIMIT 1
            ) b
        CROSS JOIN 
            (
                SELECT COUNT(*) AS qtd FROM `lidercoord` WHERE `data` = $data2 AND setor = 11
            ) a
        LEFT JOIN `lidercoord` c ON c.`data` = $data2 AND idusuarios = idsupervisor AND c.setor = 11
    ) AS combined_data

        ";
        $financeiro2_sql = mysqli_query($conexao, $financeiro2);
        
        while ($financeiro2_assoc = mysqli_fetch_assoc($financeiro2_sql)) {

          $financeiro2_inteiro = number_format($financeiro2_assoc['nota_tt6'], 2, '.', ''); 

        
        }

        //----

        $data2 = $_GET['id_data'];
        $qualidade2 = "

        SELECT 
        COALESCE(SUM(nvl(nota_tt6, 0)), 0)/2 AS nota_tt6,
        COALESCE(SUM(qtd), 0)/2 AS qtd
    FROM (
        -- Subconsulta 1
        SELECT 
            COALESCE(
                (
                    SUM(
                        COALESCE(nvl(c.nota1, 0), 0) + 
                        COALESCE(nvl(c.nota2, 0), 0) + 
                        COALESCE(nvl(c.nota3, 0), 0) + 
                        COALESCE(nvl(c.nota4, 0), 0) +
                        COALESCE(nvl(c.nota5, 0), 0) + 
                        COALESCE(nvl(c.nota6, 0), 0) + 
                        COALESCE(nvl(c.nota7, 0), 0) + 
                        COALESCE(nvl(c.nota8, 0), 0) +
                        COALESCE(nvl(c.nota9, 0), 0) + 
                        COALESCE(nvl(c.nota10, 0), 0)
                    ) / b.qt_col / a.qtd
                ), 
            0) AS nota_tt6,
            COALESCE(a.qtd, 0) AS qtd
        FROM 
            (
                SELECT 
                    (
                        IF(nota1 IS NOT NULL, 1, 0) +
                        IF(nota2 IS NOT NULL, 1, 0) +
                        IF(nota3 IS NOT NULL, 1, 0) +
                        IF(nota4 IS NOT NULL, 1, 0) +
                        IF(nota5 IS NOT NULL, 1, 0) +
                        IF(nota6 IS NOT NULL, 1, 0) +
                        IF(nota7 IS NOT NULL, 1, 0) +
                        IF(nota8 IS NOT NULL, 1, 0) +
                        IF(nota9 IS NOT NULL, 1, 0) +
                        IF(nota10 IS NOT NULL, 1, 0)
                    ) AS qt_col
                FROM coord
                WHERE 1=1
                AND data = $data2
                AND setor = 7
                LIMIT 1
            ) b
        CROSS JOIN 
            (
                SELECT COUNT(*) AS qtd FROM coord WHERE `data` = $data2 AND setor = 7
            ) a
        LEFT JOIN `coord` c ON c.`data` = $data2 AND c.setor = 7
    
        UNION ALL
    
        -- Subconsulta 2
        SELECT 
            COALESCE(
                (
                    SUM(
                        COALESCE(nvl(c.nota1, 0), 0) + 
                        COALESCE(nvl(c.nota2, 0), 0) + 
                        COALESCE(nvl(c.nota3, 0), 0) + 
                        COALESCE(nvl(c.nota4, 0), 0) +
                        COALESCE(nvl(c.nota5, 0), 0) + 
                        COALESCE(nvl(c.nota6, 0), 0) + 
                        COALESCE(nvl(c.nota7, 0), 0) + 
                        COALESCE(nvl(c.nota8, 0), 0) +
                        COALESCE(nvl(c.nota9, 0), 0) + 
                        COALESCE(nvl(c.nota10, 0), 0)
                    ) / b.qt_col / a.qtd
                ), 
            0) AS nota_tt6,
            COALESCE(a.qtd, 0) AS qtd
        FROM 
            (
                SELECT 
                    (
                        IF(nota1 IS NOT NULL, 1, 0) +
                        IF(nota2 IS NOT NULL, 1, 0) +
                        IF(nota3 IS NOT NULL, 1, 0) +
                        IF(nota4 IS NOT NULL, 1, 0) +
                        IF(nota5 IS NOT NULL, 1, 0) +
                        IF(nota6 IS NOT NULL, 1, 0) +
                        IF(nota7 IS NOT NULL, 1, 0) +
                        IF(nota8 IS NOT NULL, 1, 0) +
                        IF(nota9 IS NOT NULL, 1, 0) +
                        IF(nota10 IS NOT NULL, 1, 0)
                    ) AS qt_col
                FROM lidercoord
                WHERE 1=1
                AND data = $data2
                AND setor = 7
                LIMIT 1
            ) b
        CROSS JOIN 
            (
                SELECT COUNT(*) AS qtd FROM `lidercoord` WHERE `data` = $data2 AND setor = 7
            ) a
        LEFT JOIN `lidercoord` c ON c.`data` = $data2 AND idusuarios = idsupervisor AND c.setor = 7
    ) AS combined_data

        ";
        $qualidade2_sql = mysqli_query($conexao, $qualidade2);
        
        while ($qualidade2_assoc = mysqli_fetch_assoc($qualidade2_sql)) {

          $qualidade2_inteiro = number_format($qualidade2_assoc['nota_tt6'], 2, '.', ''); 

        
        }

        
        //----

        $data2 = $_GET['id_data'];
        $compras2 = "

        SELECT 
        COALESCE(SUM(nvl(nota_tt6, 0)), 0)/2 AS nota_tt6,
        COALESCE(SUM(qtd), 0)/2 AS qtd
    FROM (
        -- Subconsulta 1
        SELECT 
            COALESCE(
                (
                    SUM(
                        COALESCE(nvl(c.nota1, 0), 0) + 
                        COALESCE(nvl(c.nota2, 0), 0) + 
                        COALESCE(nvl(c.nota3, 0), 0) + 
                        COALESCE(nvl(c.nota4, 0), 0) +
                        COALESCE(nvl(c.nota5, 0), 0) + 
                        COALESCE(nvl(c.nota6, 0), 0) + 
                        COALESCE(nvl(c.nota7, 0), 0) + 
                        COALESCE(nvl(c.nota8, 0), 0) +
                        COALESCE(nvl(c.nota9, 0), 0) + 
                        COALESCE(nvl(c.nota10, 0), 0)
                    ) / b.qt_col / a.qtd
                ), 
            0) AS nota_tt6,
            COALESCE(a.qtd, 0) AS qtd
        FROM 
            (
                SELECT 
                    (
                        IF(nota1 IS NOT NULL, 1, 0) +
                        IF(nota2 IS NOT NULL, 1, 0) +
                        IF(nota3 IS NOT NULL, 1, 0) +
                        IF(nota4 IS NOT NULL, 1, 0) +
                        IF(nota5 IS NOT NULL, 1, 0) +
                        IF(nota6 IS NOT NULL, 1, 0) +
                        IF(nota7 IS NOT NULL, 1, 0) +
                        IF(nota8 IS NOT NULL, 1, 0) +
                        IF(nota9 IS NOT NULL, 1, 0) +
                        IF(nota10 IS NOT NULL, 1, 0)
                    ) AS qt_col
                FROM coord
                WHERE 1=1
                AND data = $data2
                AND setor = 4
                LIMIT 1
            ) b
        CROSS JOIN 
            (
                SELECT COUNT(*) AS qtd FROM coord WHERE `data` = $data2 AND setor = 4
            ) a
        LEFT JOIN `coord` c ON c.`data` = $data2 AND c.setor = 4
    
        UNION ALL
    
        -- Subconsulta 2
        SELECT 
            COALESCE(
                (
                    SUM(
                        COALESCE(nvl(c.nota1, 0), 0) + 
                        COALESCE(nvl(c.nota2, 0), 0) + 
                        COALESCE(nvl(c.nota3, 0), 0) + 
                        COALESCE(nvl(c.nota4, 0), 0) +
                        COALESCE(nvl(c.nota5, 0), 0) + 
                        COALESCE(nvl(c.nota6, 0), 0) + 
                        COALESCE(nvl(c.nota7, 0), 0) + 
                        COALESCE(nvl(c.nota8, 0), 0) +
                        COALESCE(nvl(c.nota9, 0), 0) + 
                        COALESCE(nvl(c.nota10, 0), 0)
                    ) / b.qt_col / a.qtd
                ), 
            0) AS nota_tt6,
            COALESCE(a.qtd, 0) AS qtd
        FROM 
            (
                SELECT 
                    (
                        IF(nota1 IS NOT NULL, 1, 0) +
                        IF(nota2 IS NOT NULL, 1, 0) +
                        IF(nota3 IS NOT NULL, 1, 0) +
                        IF(nota4 IS NOT NULL, 1, 0) +
                        IF(nota5 IS NOT NULL, 1, 0) +
                        IF(nota6 IS NOT NULL, 1, 0) +
                        IF(nota7 IS NOT NULL, 1, 0) +
                        IF(nota8 IS NOT NULL, 1, 0) +
                        IF(nota9 IS NOT NULL, 1, 0) +
                        IF(nota10 IS NOT NULL, 1, 0)
                    ) AS qt_col
                FROM lidercoord
                WHERE 1=1
                AND data = $data2
                AND setor = 4
                LIMIT 1
            ) b
        CROSS JOIN 
            (
                SELECT COUNT(*) AS qtd FROM `lidercoord` WHERE `data` = $data2 AND setor = 4
            ) a
        LEFT JOIN `lidercoord` c ON c.`data` = $data2 AND idusuarios = idsupervisor AND c.setor = 4
    ) AS combined_data

        ";
        $compras2_sql = mysqli_query($conexao, $compras2);
        
        while ($compras2_assoc = mysqli_fetch_assoc($compras2_sql)) {

          $compras2_inteiro = number_format($compras2_assoc['nota_tt6'], 2, '.', ''); 
          
       
        }




echo "
    <div class='col'>
      <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
      <script type='text/javascript'>
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

          var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['$recepcao2_inteiro Recepção', $recepcao2_inteiro],
            ['$farmacia2_inteiro Farmácia', $farmacia2_inteiro],
            ['$rh2_inteiro Recursos Humanos', $rh2_inteiro],
            ['$ti2_inteiro Tec da Informação', $ti2_inteiro],
            ['$cc2_inteiro Centro Cirurgico', $cc2_inteiro],
            ['$sala_pa2_inteiro Sala de Proc Amb', $sala_pa2_inteiro],
            ['$faturamento2_inteiro Faturamento', $faturamento2_inteiro],
            ['$financeiro2_inteiro Financeiro', $financeiro2_inteiro],
            ['$compras2_inteiro Compras', $compras2_inteiro],
            ['$qualidade2_inteiro Qualidade', $qualidade2_inteiro]
          ]);

          var options = {
            title: 'Coordenador se auto-avalia'
          };

          var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

          chart.draw(data, options);
        }
      </script>
      <div>
        <div id='piechart2' style='width: 800px; height: 400px;'></div>
      </div>
    </div>

  
  
";

?>

</div>
<!-- Coordenador se auto-avalia  -->
<!-- Gerente avalia Coordenador -->


    <?php

    echo"<!-- Seleciona Pergunra -->";

        $sql_perguntas = "SELECT * FROM modifica_pergunta";
        $id_perguntas = mysqli_query($conexao, $sql_perguntas);

        while ($perguntas_fetch = mysqli_fetch_assoc($id_perguntas)) {

        $pergunta_id = $perguntas_fetch['gerencia'];

        }
    echo"<!-- Seleciona Pergunra -->";

          $data4 = $_GET['id_data'];
          $recepcao3 = "

        
          SELECT 
          nvl(
              (
                  (
                      sum(
                          nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                          nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                          nvl(c.nota9, 0) + nvl(c.nota10, 0)
                      ) / b.qt_col
                  ) / a.qtd
              ), 0
          ) nota_tt6,
          nvl(a.qtd, 0) qtd
      FROM 
          (
              SELECT 
                  (
                      IF(nota1 IS NOT NULL, 1, 0) +
                      IF(nota2 IS NOT NULL, 1, 0) +
                      IF(nota3 IS NOT NULL, 1, 0) +
                      IF(nota4 IS NOT NULL, 1, 0) +
                      IF(nota5 IS NOT NULL, 1, 0) +
                      IF(nota6 IS NOT NULL, 1, 0) +
                      IF(nota7 IS NOT NULL, 1, 0) +
                      IF(nota8 IS NOT NULL, 1, 0) +
                      IF(nota9 IS NOT NULL, 1, 0) +
                      IF(nota10 IS NOT NULL, 1, 0)
                  ) qt_col
              FROM gerencia
              WHERE 1=1
              AND data = $data4
              AND perguntaid = $pergunta_id
              AND setor = 5
              LIMIT 1
          ) b,
          (
              SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id AND setor = 5
          ) a,
          `gerencia` c
      WHERE 1=1
      AND c.`data` = $data4
      AND perguntaid = $pergunta_id
      AND c.setor = 5

          ";
          $recepcao3_sql = mysqli_query($conexao, $recepcao3);
          
          while ($recepcao3_assoc = mysqli_fetch_assoc($recepcao3_sql)) {

            $recepcao3_inteiro = number_format($recepcao3_assoc['nota_tt6'], 2, '.', ''); 


          }

          //----

          $data2 = $_GET['id_data'];
          $farmacia3 = "

          SELECT 
          nvl(
              (
                  (
                      sum(
                          nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                          nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                          nvl(c.nota9, 0) + nvl(c.nota10, 0)
                      ) / b.qt_col
                  ) / a.qtd
              ), 0
          ) nota_tt6,
          nvl(a.qtd, 0) qtd
      FROM 
          (
              SELECT 
                  (
                      IF(nota1 IS NOT NULL, 1, 0) +
                      IF(nota2 IS NOT NULL, 1, 0) +
                      IF(nota3 IS NOT NULL, 1, 0) +
                      IF(nota4 IS NOT NULL, 1, 0) +
                      IF(nota5 IS NOT NULL, 1, 0) +
                      IF(nota6 IS NOT NULL, 1, 0) +
                      IF(nota7 IS NOT NULL, 1, 0) +
                      IF(nota8 IS NOT NULL, 1, 0) +
                      IF(nota9 IS NOT NULL, 1, 0) +
                      IF(nota10 IS NOT NULL, 1, 0)
                  ) qt_col
              FROM gerencia
              WHERE 1=1
              AND data = $data4
              AND perguntaid = $pergunta_id
              AND setor = 6
              LIMIT 1
          ) b,
          (
              SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id AND setor = 6
          ) a,
          `gerencia` c
      WHERE 1=1
      AND c.`data` = $data4
      AND perguntaid = $pergunta_id
      AND c.setor = 6

          ";
          $farmacia3_sql = mysqli_query($conexao, $farmacia3);
          
          while ($farmacia3_assoc = mysqli_fetch_assoc($farmacia3_sql)) {

            $farmacia3_inteiro = number_format($farmacia3_assoc['nota_tt6'], 2, '.', ''); 

          
          }

         //----

         $data2 = $_GET['id_data'];
         $rh3 = "

         SELECT 
         nvl(
             (
                 (
                     sum(
                         nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                         nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                         nvl(c.nota9, 0) + nvl(c.nota10, 0)
                     ) / b.qt_col
                 ) / a.qtd
             ), 0
         ) nota_tt6,
         nvl(a.qtd, 0) qtd
     FROM 
         (
             SELECT 
                 (
                     IF(nota1 IS NOT NULL, 1, 0) +
                     IF(nota2 IS NOT NULL, 1, 0) +
                     IF(nota3 IS NOT NULL, 1, 0) +
                     IF(nota4 IS NOT NULL, 1, 0) +
                     IF(nota5 IS NOT NULL, 1, 0) +
                     IF(nota6 IS NOT NULL, 1, 0) +
                     IF(nota7 IS NOT NULL, 1, 0) +
                     IF(nota8 IS NOT NULL, 1, 0) +
                     IF(nota9 IS NOT NULL, 1, 0) +
                     IF(nota10 IS NOT NULL, 1, 0)
                 ) qt_col
             FROM gerencia
             WHERE 1=1
             AND data = $data4
             AND perguntaid = $pergunta_id
             AND setor = 8
             LIMIT 1
         ) b,
         (
             SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id AND setor = 8
         ) a,
         `gerencia` c
     WHERE 1=1
     AND c.`data` = $data4
     AND perguntaid = $pergunta_id
     AND c.setor = 8

         ";
         $rh3_sql = mysqli_query($conexao, $rh3);
         
         while ($rh3_assoc = mysqli_fetch_assoc($rh3_sql)) {

          $rh3_inteiro = number_format($rh3_assoc['nota_tt6'], 2, '.', ''); 

         
         }

                  //----

                  $data2 = $_GET['id_data'];
                  $ti3 = "
         
                  SELECT 
          nvl(
              (
                  (
                      sum(
                          nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                          nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                          nvl(c.nota9, 0) + nvl(c.nota10, 0)
                      ) / b.qt_col
                  ) / a.qtd
              ), 0
          ) nota_tt6,
          nvl(a.qtd, 0) qtd
      FROM 
          (
              SELECT 
                  (
                      IF(nota1 IS NOT NULL, 1, 0) +
                      IF(nota2 IS NOT NULL, 1, 0) +
                      IF(nota3 IS NOT NULL, 1, 0) +
                      IF(nota4 IS NOT NULL, 1, 0) +
                      IF(nota5 IS NOT NULL, 1, 0) +
                      IF(nota6 IS NOT NULL, 1, 0) +
                      IF(nota7 IS NOT NULL, 1, 0) +
                      IF(nota8 IS NOT NULL, 1, 0) +
                      IF(nota9 IS NOT NULL, 1, 0) +
                      IF(nota10 IS NOT NULL, 1, 0)
                  ) qt_col
              FROM gerencia
              WHERE 1=1
              AND data = $data4
              AND perguntaid = $pergunta_id
              AND setor = 9
              LIMIT 1
          ) b,
          (
              SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id AND setor = 9
          ) a,
          `gerencia` c
      WHERE 1=1
      AND c.`data` = $data4
      AND perguntaid = $pergunta_id
      AND c.setor = 9
         
                  ";
                  $ti3_sql = mysqli_query($conexao, $ti3);
                  
                  while ($ti3_assoc = mysqli_fetch_assoc($ti3_sql)) {
         
                    $ti3_inteiro = number_format($ti3_assoc['nota_tt6'], 2, '.', ''); 

                  
                  }

                  
                  //----

                  $data2 = $_GET['id_data'];
                  $cc3 = "
         
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM gerencia
                      WHERE 1=1
                      AND data = $data4
                      AND perguntaid = $pergunta_id
                      AND setor = 2
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id AND setor = 2
                  ) a,
                  `gerencia` c
              WHERE 1=1
              AND c.`data` = $data4
              AND perguntaid = $pergunta_id
              AND c.setor = 2
         
                  ";
                  $cc3_sql = mysqli_query($conexao, $cc3);
                  
                  while ($cc3_assoc = mysqli_fetch_assoc($cc3_sql)) {
         
                    $cc3_inteiro = number_format($cc3_assoc['nota_tt6'], 2, '.', ''); 
                  
                  }

                                    
                  //----

                  $data2 = $_GET['id_data'];
                  $sala_pa3 = "
         
                  SELECT 
          nvl(
              (
                  (
                      sum(
                          nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                          nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                          nvl(c.nota9, 0) + nvl(c.nota10, 0)
                      ) / b.qt_col
                  ) / a.qtd
              ), 0
          ) nota_tt6,
          nvl(a.qtd, 0) qtd
      FROM 
          (
              SELECT 
                  (
                      IF(nota1 IS NOT NULL, 1, 0) +
                      IF(nota2 IS NOT NULL, 1, 0) +
                      IF(nota3 IS NOT NULL, 1, 0) +
                      IF(nota4 IS NOT NULL, 1, 0) +
                      IF(nota5 IS NOT NULL, 1, 0) +
                      IF(nota6 IS NOT NULL, 1, 0) +
                      IF(nota7 IS NOT NULL, 1, 0) +
                      IF(nota8 IS NOT NULL, 1, 0) +
                      IF(nota9 IS NOT NULL, 1, 0) +
                      IF(nota10 IS NOT NULL, 1, 0)
                  ) qt_col
              FROM gerencia
              WHERE 1=1
              AND data = $data4
              AND perguntaid = $pergunta_id
              AND setor = 1
              LIMIT 1
          ) b,
          (
              SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id AND setor = 1
          ) a,
          `gerencia` c
      WHERE 1=1
      AND c.`data` = $data4
      AND perguntaid = $pergunta_id
      AND c.setor = 1
         
                  ";
                  $sala_pa3_sql = mysqli_query($conexao, $sala_pa3);
                  
                  while ($sala_pa3_assoc = mysqli_fetch_assoc($sala_pa3_sql)) {
         
                    $sala_pa3_inteiro = number_format($sala_pa3_assoc['nota_tt6'], 2, '.', ''); 

                  }
                                    
                  //----

                  $data2 = $_GET['id_data'];
                  $faturamento3 = "
         
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM gerencia
                      WHERE 1=1
                      AND data = $data4
                      AND perguntaid = $pergunta_id
                      AND setor = 3
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id AND setor = 3
                  ) a,
                  `gerencia` c
              WHERE 1=1
              AND c.`data` = $data4
              AND perguntaid = $pergunta_id
              AND c.setor = 3
         
                  ";
                  $faturamento3_sql = mysqli_query($conexao, $faturamento3);
                  
                  while ($faturamento3_assoc = mysqli_fetch_assoc($faturamento3_sql)) {
         
                    $faturamento3_inteiro = number_format($faturamento3_assoc['nota_tt6'], 2, '.', ''); 

                  
                  }
                  //----

                  $data2 = $_GET['id_data'];
                  $financeiro3 = "
          
                  SELECT 
          nvl(
              (
                  (
                      sum(
                          nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                          nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                          nvl(c.nota9, 0) + nvl(c.nota10, 0)
                      ) / b.qt_col
                  ) / a.qtd
              ), 0
          ) nota_tt6,
          nvl(a.qtd, 0) qtd
      FROM 
          (
              SELECT 
                  (
                      IF(nota1 IS NOT NULL, 1, 0) +
                      IF(nota2 IS NOT NULL, 1, 0) +
                      IF(nota3 IS NOT NULL, 1, 0) +
                      IF(nota4 IS NOT NULL, 1, 0) +
                      IF(nota5 IS NOT NULL, 1, 0) +
                      IF(nota6 IS NOT NULL, 1, 0) +
                      IF(nota7 IS NOT NULL, 1, 0) +
                      IF(nota8 IS NOT NULL, 1, 0) +
                      IF(nota9 IS NOT NULL, 1, 0) +
                      IF(nota10 IS NOT NULL, 1, 0)
                  ) qt_col
              FROM gerencia
              WHERE 1=1
              AND data = $data4
              AND perguntaid = $pergunta_id
              AND setor = 11
              LIMIT 1
          ) b,
          (
              SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id AND setor = 11
          ) a,
          `gerencia` c
      WHERE 1=1
      AND c.`data` = $data4
      AND perguntaid = $pergunta_id
      AND c.setor = 11
          
                  ";
                  $financeiro3_sql = mysqli_query($conexao, $financeiro3);
                  
                  while ($financeiro3_assoc = mysqli_fetch_assoc($financeiro3_sql)) {
          
                    $financeiro3_inteiro = number_format($financeiro3_assoc['nota_tt6'], 2, '.', ''); 

                  
                  }

                  //----

                  $data2 = $_GET['id_data'];
                  $qualidade3 = "
          
                  SELECT 
          nvl(
              (
                  (
                      sum(
                          nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                          nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                          nvl(c.nota9, 0) + nvl(c.nota10, 0)
                      ) / b.qt_col
                  ) / a.qtd
              ), 0
          ) nota_tt6,
          nvl(a.qtd, 0) qtd
      FROM 
          (
              SELECT 
                  (
                      IF(nota1 IS NOT NULL, 1, 0) +
                      IF(nota2 IS NOT NULL, 1, 0) +
                      IF(nota3 IS NOT NULL, 1, 0) +
                      IF(nota4 IS NOT NULL, 1, 0) +
                      IF(nota5 IS NOT NULL, 1, 0) +
                      IF(nota6 IS NOT NULL, 1, 0) +
                      IF(nota7 IS NOT NULL, 1, 0) +
                      IF(nota8 IS NOT NULL, 1, 0) +
                      IF(nota9 IS NOT NULL, 1, 0) +
                      IF(nota10 IS NOT NULL, 1, 0)
                  ) qt_col
              FROM gerencia
              WHERE 1=1
              AND data = $data4
              AND perguntaid = $pergunta_id
              AND setor = 7
              LIMIT 1
          ) b,
          (
              SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id AND setor = 7
          ) a,
          `gerencia` c
      WHERE 1=1
      AND c.`data` = $data4
      AND perguntaid = $pergunta_id
      AND c.setor = 7
          
                  ";
                  $qualidade3_sql = mysqli_query($conexao, $qualidade3);
                  
                  while ($qualidade3_assoc = mysqli_fetch_assoc($qualidade3_sql)) {
          
                    $qualidade3_inteiro = number_format($qualidade3_assoc['nota_tt6'], 2, '.', ''); 
        
                  
                  }

                  
                  //----

                  $data2 = $_GET['id_data'];
                  $compras3 = "
          
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM gerencia
                      WHERE 1=1
                      AND data = $data4
                      AND perguntaid = $pergunta_id
                      AND setor = 4
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id AND setor = 4
                  ) a,
                  `gerencia` c
              WHERE 1=1
              AND c.`data` = $data4
              AND perguntaid = $pergunta_id
              AND c.setor = 4
          
                  ";
                  $compras3_sql = mysqli_query($conexao, $compras3);
                  
                  while ($compras3_assoc = mysqli_fetch_assoc($compras3_sql)) {
          
                    $compras3_inteiro = number_format($compras3_assoc['nota_tt6'], 2, '.', ''); 
                    
                 
                  }


          

          echo "
              <div class='col'>
                <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
                <script type='text/javascript'>
                  google.charts.load('current', { 'packages': ['corechart'] });
                  google.charts.setOnLoadCallback(drawChart);

                  function drawChart() {

                    var data = google.visualization.arrayToDataTable([
                      ['Task', 'Hours per Day'],
                      ['$recepcao3_inteiro Recepção', $recepcao3_inteiro],
                      ['$farmacia3_inteiro Farmácia', $farmacia3_inteiro],
                      ['$rh3_inteiro Recursos Humanos', $rh3_inteiro],
                      ['$ti3_inteiro Tec da Informação', $ti3_inteiro],
                      ['$cc3_inteiro Centro Cirurgico', $cc3_inteiro],
                      ['$sala_pa3_inteiro Sala de Proc Amb', $sala_pa3_inteiro],
                      ['$faturamento3_inteiro Faturamento', $faturamento3_inteiro],
                      ['$financeiro3_inteiro Financeiro', $financeiro3_inteiro],
                      ['$compras3_inteiro Compras', $compras3_inteiro],
                      ['$qualidade3_inteiro Qualidade', $qualidade3_inteiro]
                    ]);

                    var options = {
                      title: 'Gerênte avalia Competência Liderança'
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('piechart4'));

                    chart.draw(data, options);
                  }
                </script>
                <div>
                  <div id='piechart4' style='width: 800px; height: 400px;'></div>
                </div>
              </div>     
";

?>




  </div>
<!--  Gerente avalia Coordenador -->
<!-- Gerencia avalia coordenadores como colaboradores -->

<div class="d-flex justify-content-center ps-5">
        <div class="row">

<?php
    echo"<!-- Seleciona Pergunra -->";

    $sql_perguntas2 = "SELECT * FROM modifica_pergunta";
    $id_perguntas2 = mysqli_query($conexao, $sql_perguntas2);

    while ($perguntas_fetch2 = mysqli_fetch_assoc($id_perguntas2)) {

    $pergunta_id2 = $perguntas_fetch2['colab'];

    }
echo"<!-- Seleciona Pergunra -->";



          $data4 = $_GET['id_data'];
          $recepcao3 = "

        
          SELECT 
          nvl(
              (
                  (
                      sum(
                          nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                          nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                          nvl(c.nota9, 0) + nvl(c.nota10, 0)
                      ) / b.qt_col
                  ) / a.qtd
              ), 0
          ) nota_tt6,
          nvl(a.qtd, 0) qtd
      FROM 
          (
              SELECT 
                  (
                      IF(nota1 IS NOT NULL, 1, 0) +
                      IF(nota2 IS NOT NULL, 1, 0) +
                      IF(nota3 IS NOT NULL, 1, 0) +
                      IF(nota4 IS NOT NULL, 1, 0) +
                      IF(nota5 IS NOT NULL, 1, 0) +
                      IF(nota6 IS NOT NULL, 1, 0) +
                      IF(nota7 IS NOT NULL, 1, 0) +
                      IF(nota8 IS NOT NULL, 1, 0) +
                      IF(nota9 IS NOT NULL, 1, 0) +
                      IF(nota10 IS NOT NULL, 1, 0)
                  ) qt_col
              FROM gerencia
              WHERE 1=1
              AND data = $data4
              AND perguntaid = $pergunta_id2
              AND setor = 5
              LIMIT 1
          ) b,
          (
              SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND setor = 5
          ) a,
          `gerencia` c
      WHERE 1=1
      AND c.`data` = $data4
      AND perguntaid = $pergunta_id
      AND c.setor = 5

          ";
          $recepcao3_sql = mysqli_query($conexao, $recepcao3);
          
          while ($recepcao3_assoc = mysqli_fetch_assoc($recepcao3_sql)) {

            $recepcao3_inteiro = number_format($recepcao3_assoc['nota_tt6'], 2, '.', ''); 


          }

          //----

          $data2 = $_GET['id_data'];
          $farmacia3 = "

          SELECT 
          nvl(
              (
                  (
                      sum(
                          nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                          nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                          nvl(c.nota9, 0) + nvl(c.nota10, 0)
                      ) / b.qt_col
                  ) / a.qtd
              ), 0
          ) nota_tt6,
          nvl(a.qtd, 0) qtd
      FROM 
          (
              SELECT 
                  (
                      IF(nota1 IS NOT NULL, 1, 0) +
                      IF(nota2 IS NOT NULL, 1, 0) +
                      IF(nota3 IS NOT NULL, 1, 0) +
                      IF(nota4 IS NOT NULL, 1, 0) +
                      IF(nota5 IS NOT NULL, 1, 0) +
                      IF(nota6 IS NOT NULL, 1, 0) +
                      IF(nota7 IS NOT NULL, 1, 0) +
                      IF(nota8 IS NOT NULL, 1, 0) +
                      IF(nota9 IS NOT NULL, 1, 0) +
                      IF(nota10 IS NOT NULL, 1, 0)
                  ) qt_col
              FROM gerencia
              WHERE 1=1
              AND data = $data4
              AND perguntaid = $pergunta_id2
              AND setor = 6
              LIMIT 1
          ) b,
          (
              SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id2 AND setor = 6
          ) a,
          `gerencia` c
      WHERE 1=1
      AND c.`data` = $data4
      AND perguntaid = $pergunta_id2
      AND c.setor = 6

          ";
          $farmacia3_sql = mysqli_query($conexao, $farmacia3);
          
          while ($farmacia3_assoc = mysqli_fetch_assoc($farmacia3_sql)) {

            $farmacia3_inteiro = number_format($farmacia3_assoc['nota_tt6'], 2, '.', ''); 

          
          }

         //----

         $data2 = $_GET['id_data'];
         $rh3 = "

         SELECT 
         nvl(
             (
                 (
                     sum(
                         nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                         nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                         nvl(c.nota9, 0) + nvl(c.nota10, 0)
                     ) / b.qt_col
                 ) / a.qtd
             ), 0
         ) nota_tt6,
         nvl(a.qtd, 0) qtd
     FROM 
         (
             SELECT 
                 (
                     IF(nota1 IS NOT NULL, 1, 0) +
                     IF(nota2 IS NOT NULL, 1, 0) +
                     IF(nota3 IS NOT NULL, 1, 0) +
                     IF(nota4 IS NOT NULL, 1, 0) +
                     IF(nota5 IS NOT NULL, 1, 0) +
                     IF(nota6 IS NOT NULL, 1, 0) +
                     IF(nota7 IS NOT NULL, 1, 0) +
                     IF(nota8 IS NOT NULL, 1, 0) +
                     IF(nota9 IS NOT NULL, 1, 0) +
                     IF(nota10 IS NOT NULL, 1, 0)
                 ) qt_col
             FROM gerencia
             WHERE 1=1
             AND data = $data4
             AND perguntaid = $pergunta_id2
             AND setor = 8
             LIMIT 1
         ) b,
         (
             SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id2 AND setor = 8
         ) a,
         `gerencia` c
     WHERE 1=1
     AND c.`data` = $data4
     AND perguntaid = $pergunta_id2
     AND c.setor = 8

         ";
         $rh3_sql = mysqli_query($conexao, $rh3);
         
         while ($rh3_assoc = mysqli_fetch_assoc($rh3_sql)) {

          $rh3_inteiro = number_format($rh3_assoc['nota_tt6'], 2, '.', ''); 

         
         }

                  //----

                  $data2 = $_GET['id_data'];
                  $ti3 = "
         
                  SELECT 
          nvl(
              (
                  (
                      sum(
                          nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                          nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                          nvl(c.nota9, 0) + nvl(c.nota10, 0)
                      ) / b.qt_col
                  ) / a.qtd
              ), 0
          ) nota_tt6,
          nvl(a.qtd, 0) qtd
      FROM 
          (
              SELECT 
                  (
                      IF(nota1 IS NOT NULL, 1, 0) +
                      IF(nota2 IS NOT NULL, 1, 0) +
                      IF(nota3 IS NOT NULL, 1, 0) +
                      IF(nota4 IS NOT NULL, 1, 0) +
                      IF(nota5 IS NOT NULL, 1, 0) +
                      IF(nota6 IS NOT NULL, 1, 0) +
                      IF(nota7 IS NOT NULL, 1, 0) +
                      IF(nota8 IS NOT NULL, 1, 0) +
                      IF(nota9 IS NOT NULL, 1, 0) +
                      IF(nota10 IS NOT NULL, 1, 0)
                  ) qt_col
              FROM gerencia
              WHERE 1=1
              AND data = $data4
              AND perguntaid = $pergunta_id2
              AND setor = 9
              LIMIT 1
          ) b,
          (
              SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id2 AND setor = 9
          ) a,
          `gerencia` c
      WHERE 1=1
      AND c.`data` = $data4
      AND perguntaid = $pergunta_id2
      AND c.setor = 9
         
                  ";
                  $ti3_sql = mysqli_query($conexao, $ti3);
                  
                  while ($ti3_assoc = mysqli_fetch_assoc($ti3_sql)) {
         
                    $ti3_inteiro = number_format($ti3_assoc['nota_tt6'], 2, '.', ''); 

                  
                  }

                  
                  //----

                  $data2 = $_GET['id_data'];
                  $cc3 = "
         
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM gerencia
                      WHERE 1=1
                      AND data = $data4
                      AND perguntaid = $pergunta_id2
                      AND setor = 2
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id2 AND setor = 2
                  ) a,
                  `gerencia` c
              WHERE 1=1
              AND c.`data` = $data4
              AND perguntaid = $pergunta_id2
              AND c.setor = 2
         
                  ";
                  $cc3_sql = mysqli_query($conexao, $cc3);
                  
                  while ($cc3_assoc = mysqli_fetch_assoc($cc3_sql)) {
         
                    $cc3_inteiro = number_format($cc3_assoc['nota_tt6'], 2, '.', ''); 
                  
                  }

                                    
                  //----

                  $data2 = $_GET['id_data'];
                  $sala_pa3 = "
         
                  SELECT 
          nvl(
              (
                  (
                      sum(
                          nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                          nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                          nvl(c.nota9, 0) + nvl(c.nota10, 0)
                      ) / b.qt_col
                  ) / a.qtd
              ), 0
          ) nota_tt6,
          nvl(a.qtd, 0) qtd
      FROM 
          (
              SELECT 
                  (
                      IF(nota1 IS NOT NULL, 1, 0) +
                      IF(nota2 IS NOT NULL, 1, 0) +
                      IF(nota3 IS NOT NULL, 1, 0) +
                      IF(nota4 IS NOT NULL, 1, 0) +
                      IF(nota5 IS NOT NULL, 1, 0) +
                      IF(nota6 IS NOT NULL, 1, 0) +
                      IF(nota7 IS NOT NULL, 1, 0) +
                      IF(nota8 IS NOT NULL, 1, 0) +
                      IF(nota9 IS NOT NULL, 1, 0) +
                      IF(nota10 IS NOT NULL, 1, 0)
                  ) qt_col
              FROM gerencia
              WHERE 1=1
              AND data = $data4
              AND perguntaid = $pergunta_id2
              AND setor = 1
              LIMIT 1
          ) b,
          (
              SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id2 AND setor = 1
          ) a,
          `gerencia` c
      WHERE 1=1
      AND c.`data` = $data4
      AND perguntaid = $pergunta_id2
      AND c.setor = 1
         
                  ";
                  $sala_pa3_sql = mysqli_query($conexao, $sala_pa3);
                  
                  while ($sala_pa3_assoc = mysqli_fetch_assoc($sala_pa3_sql)) {
         
                    $sala_pa3_inteiro = number_format($sala_pa3_assoc['nota_tt6'], 2, '.', ''); 

                  }
                                    
                  //----

                  $data2 = $_GET['id_data'];
                  $faturamento3 = "
         
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM gerencia
                      WHERE 1=1
                      AND data = $data4
                      AND perguntaid = $pergunta_id2
                      AND setor = 3
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id2 AND setor = 3
                  ) a,
                  `gerencia` c
              WHERE 1=1
              AND c.`data` = $data4
              AND perguntaid = $pergunta_id2
              AND c.setor = 3
         
                  ";
                  $faturamento3_sql = mysqli_query($conexao, $faturamento3);
                  
                  while ($faturamento3_assoc = mysqli_fetch_assoc($faturamento3_sql)) {
         
                    $faturamento3_inteiro = number_format($faturamento3_assoc['nota_tt6'], 2, '.', ''); 

                  
                  }
                  //----

                  $data2 = $_GET['id_data'];
                  $financeiro3 = "
          
                  SELECT 
          nvl(
              (
                  (
                      sum(
                          nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                          nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                          nvl(c.nota9, 0) + nvl(c.nota10, 0)
                      ) / b.qt_col
                  ) / a.qtd
              ), 0
          ) nota_tt6,
          nvl(a.qtd, 0) qtd
      FROM 
          (
              SELECT 
                  (
                      IF(nota1 IS NOT NULL, 1, 0) +
                      IF(nota2 IS NOT NULL, 1, 0) +
                      IF(nota3 IS NOT NULL, 1, 0) +
                      IF(nota4 IS NOT NULL, 1, 0) +
                      IF(nota5 IS NOT NULL, 1, 0) +
                      IF(nota6 IS NOT NULL, 1, 0) +
                      IF(nota7 IS NOT NULL, 1, 0) +
                      IF(nota8 IS NOT NULL, 1, 0) +
                      IF(nota9 IS NOT NULL, 1, 0) +
                      IF(nota10 IS NOT NULL, 1, 0)
                  ) qt_col
              FROM gerencia
              WHERE 1=1
              AND data = $data4
              AND perguntaid = $pergunta_id2
              AND setor = 11
              LIMIT 1
          ) b,
          (
              SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id2 AND setor = 11
          ) a,
          `gerencia` c
      WHERE 1=1
      AND c.`data` = $data4
      AND perguntaid = $pergunta_id2
      AND c.setor = 11
          
                  ";
                  $financeiro3_sql = mysqli_query($conexao, $financeiro3);
                  
                  while ($financeiro3_assoc = mysqli_fetch_assoc($financeiro3_sql)) {
          
                    $financeiro3_inteiro = number_format($financeiro3_assoc['nota_tt6'], 2, '.', ''); 

                  
                  }

                  //----

                  $data2 = $_GET['id_data'];
                  $qualidade3 = "
          
                  SELECT 
          nvl(
              (
                  (
                      sum(
                          nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                          nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                          nvl(c.nota9, 0) + nvl(c.nota10, 0)
                      ) / b.qt_col
                  ) / a.qtd
              ), 0
          ) nota_tt6,
          nvl(a.qtd, 0) qtd
      FROM 
          (
              SELECT 
                  (
                      IF(nota1 IS NOT NULL, 1, 0) +
                      IF(nota2 IS NOT NULL, 1, 0) +
                      IF(nota3 IS NOT NULL, 1, 0) +
                      IF(nota4 IS NOT NULL, 1, 0) +
                      IF(nota5 IS NOT NULL, 1, 0) +
                      IF(nota6 IS NOT NULL, 1, 0) +
                      IF(nota7 IS NOT NULL, 1, 0) +
                      IF(nota8 IS NOT NULL, 1, 0) +
                      IF(nota9 IS NOT NULL, 1, 0) +
                      IF(nota10 IS NOT NULL, 1, 0)
                  ) qt_col
              FROM gerencia
              WHERE 1=1
              AND data = $data4
              AND perguntaid = $pergunta_id2
              AND setor = 7
              LIMIT 1
          ) b,
          (
              SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id2 AND setor = 7
          ) a,
          `gerencia` c
      WHERE 1=1
      AND c.`data` = $data4
      AND perguntaid = $pergunta_id2
      AND c.setor = 7
          
                  ";
                  $qualidade3_sql = mysqli_query($conexao, $qualidade3);
                  
                  while ($qualidade3_assoc = mysqli_fetch_assoc($qualidade3_sql)) {
          
                    $qualidade3_inteiro = number_format($qualidade3_assoc['nota_tt6'], 2, '.', ''); 
        
                  
                  }

                  
                  //----

                  $data2 = $_GET['id_data'];
                  $compras3 = "
          
                  SELECT 
                  nvl(
                      (
                          (
                              sum(
                                  nvl(c.nota1, 0) + nvl(c.nota2, 0) + nvl(c.nota3, 0) + nvl(c.nota4, 0) +
                                  nvl(c.nota5, 0) + nvl(c.nota6, 0) + nvl(c.nota7, 0) + nvl(c.nota8, 0) +
                                  nvl(c.nota9, 0) + nvl(c.nota10, 0)
                              ) / b.qt_col
                          ) / a.qtd
                      ), 0
                  ) nota_tt6,
                  nvl(a.qtd, 0) qtd
              FROM 
                  (
                      SELECT 
                          (
                              IF(nota1 IS NOT NULL, 1, 0) +
                              IF(nota2 IS NOT NULL, 1, 0) +
                              IF(nota3 IS NOT NULL, 1, 0) +
                              IF(nota4 IS NOT NULL, 1, 0) +
                              IF(nota5 IS NOT NULL, 1, 0) +
                              IF(nota6 IS NOT NULL, 1, 0) +
                              IF(nota7 IS NOT NULL, 1, 0) +
                              IF(nota8 IS NOT NULL, 1, 0) +
                              IF(nota9 IS NOT NULL, 1, 0) +
                              IF(nota10 IS NOT NULL, 1, 0)
                          ) qt_col
                      FROM gerencia
                      WHERE 1=1
                      AND data = $data4
                      AND perguntaid = $pergunta_id2
                      AND setor = 4
                      LIMIT 1
                  ) b,
                  (
                      SELECT sum(1) qtd from `gerencia` WHERE `data` = $data4 AND perguntaid = $pergunta_id2 AND setor = 4
                  ) a,
                  `gerencia` c
              WHERE 1=1
              AND c.`data` = $data4
              AND perguntaid = $pergunta_id2
              AND c.setor = 4
          
                  ";
                  $compras3_sql = mysqli_query($conexao, $compras3);
                  
                  while ($compras3_assoc = mysqli_fetch_assoc($compras3_sql)) {
          
                    $compras3_inteiro = number_format($compras3_assoc['nota_tt6'], 2, '.', ''); 
                    
                 
                  }


          

          echo "
              <div class='col'>
                <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
                <script type='text/javascript'>
                  google.charts.load('current', { 'packages': ['corechart'] });
                  google.charts.setOnLoadCallback(drawChart);

                  function drawChart() {

                    var data = google.visualization.arrayToDataTable([
                      ['Task', 'Hours per Day'],
                      ['$recepcao3_inteiro Recepção', $recepcao3_inteiro],
                      ['$farmacia3_inteiro Farmácia', $farmacia3_inteiro],
                      ['$rh3_inteiro Recursos Humanos', $rh3_inteiro],
                      ['$ti3_inteiro Tec da Informação', $ti3_inteiro],
                      ['$cc3_inteiro Centro Cirurgico', $cc3_inteiro],
                      ['$sala_pa3_inteiro Sala de Proc Amb', $sala_pa3_inteiro],
                      ['$faturamento3_inteiro Faturamento', $faturamento3_inteiro],
                      ['$financeiro3_inteiro Financeiro', $financeiro3_inteiro],
                      ['$compras3_inteiro Compras', $compras3_inteiro],
                      ['$qualidade3_inteiro Qualidade', $qualidade3_inteiro]
                    ]);

                    var options = {
                      title: 'Gerênte avalia Coordenadores'
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('piechart5'));

                    chart.draw(data, options);
                  }
                </script>
                <div>
                  <div id='piechart5' style='width: 800px; height: 400px;'></div>
                </div>
              </div>     
";

?>


                </div>
                </div>



<!-- Gerencia avalia coordenadores como colaboradores -->




  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
</body>

</html>

<?php } else {
  header('Location: login.php');
} ?>