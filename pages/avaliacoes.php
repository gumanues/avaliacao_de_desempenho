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
    $data_ano = date('Y', strtotime(str_replace("/", "-", $ano_vigente)));
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
    <a href="avaliacoes.php?id_data=6&id_data=null" class="btn btn-outline-secondary btn-lg m-2">Avaliação Geral</a>
    <a href="avaliacoes_setores.php?id_data=6&id_data=null" class="btn btn-secondary btn-lg m-2">Avaliação Por Setor</a>
    <a href="avaliacoes_usuarios.php?id_tipo=null&idusuario=null&id_data=null" class="btn btn-secondary btn-lg m-2">Avaliação Por Usuário</a>
    <a href="avaliacoes_lideres.php?idusuario=null&id_data=null" class="btn btn-secondary btn-lg m-2">Avaliação Por Liderança</a>
    <a href="avaliacoes_nao_realizadas.php?id_data=6&id_data=null" class="btn btn-secondary btn-lg m-2">Usuários Pendentes</a>
  </div>


  <div>
    <label class="fw-bold fs-3 d-flex justify-content-center py-3">Avaliações Gerais</label>
  </div>

  <div class="container py-2">
    <form action="avaliacoes.php" method="GET">
    <div>
    <input name="id_data" value="6" type="hidden" id="id_data" checked require>
    </div>
      <div class="mb-3">


        <label for="id_data" class="form-label pt-3">Selecione o Ano:</label>
        <select class="form-select" name="id_data" id="id_data" required>
          <option value='<?=$ano_vigente?>' hidden><?=$ano_vigente?></option>
          <?php
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

      <div>

        <?php  
          $data6 = $_GET['id_data'];
          $data_sql6 = "

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
              WHERE data = $data6
              LIMIT 1
          ) b,
          (
              SELECT sum(1) qtd from `colab` WHERE `data` = $data6
          ) a,
          `colab` c
      WHERE 
          c.`data` = $data6;

          ";


          $datasql6 = mysqli_query($conexao, $data_sql6);
          
          while ($id_nota6 = mysqli_fetch_assoc($datasql6)) {

          $media6 = substr($id_nota6['nota_tt6'],0,-7);
          $qtd6 = $id_nota6['qtd'];
          $media_div6 = $media6 * 8;
          $media_graf6 = ($media6 * 8) * 2.5;

   

          if (floor($media6) == 1) {
            $bg6 = "bg-danger";
          } else if (floor($media6) == 2) {
            $bg6 = "bg-warning";
          } else if (floor($media6) == 3) {
            $bg6 = "bg-info";
          } else if (floor($media6) == 4) {
            $bg6 = "";
          } else {
            $bg6 = "bg-success";
          }


          echo "

          <div class='row'>
            <div class='col-8'>
              <p class='fs-5'>Nota Média Colaboradores: $media6</p>
            </div>
          </div>

          
          <p>Colaborador se auto-avalia. Quantidade de registros: $qtd6</p>
          
          <div class='progress'>
            <div class='progress-bar progress-bar-striped $bg6' role='progressbar' style='width: $media_graf6%' aria-valuenow='10' aria-valuemin='0' aria-valuemax='100'></div>
          </div>
          
          <hr>
          ";

          }

          //-----------------------------------

          $data7 = $_GET['id_data'];
          $data_sql7 = "
          
          SELECT 
          COALESCE(SUM(nvl(nota_tt7, 0)), 0)/2 AS nota_tt7,
          COALESCE(SUM(qtd), 0)/2 AS qtd
      FROM (
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
              0) AS nota_tt7,
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
                  WHERE data = $data7
                  LIMIT 1
              ) b
          CROSS JOIN 
              (
                  SELECT COUNT(*) AS qtd FROM coord WHERE data = $data7
              ) a
          LEFT JOIN `coord` c ON c.`data` = $data7
      
          UNION ALL 
      
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
              0) AS nota_tt7,
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
                  WHERE data = $data7
                  LIMIT 1
              ) b
          CROSS JOIN 
              (
                  SELECT COUNT(*) AS qtd FROM `lidercoord` WHERE `data` = $data7 AND idsupervisor = idusuarios
              ) a
          LEFT JOIN `lidercoord` c ON c.`data` = $data7
      ) AS combined_data
      

          ";


          $datasql7 = mysqli_query($conexao, $data_sql7);
          
          while ($id_nota7 = mysqli_fetch_assoc($datasql7)) {

        
          $media7 = sprintf("%.1f", $id_nota7['nota_tt7']);
          $qtd7 = round($id_nota7['qtd'], 1);
          $media_div7 = $media7 * 8;
          $media_graf7 = ($media7 * 8) * 2.5;



          if (floor($media7) == 1) {
            $bg7 = "bg-danger";
          } else if (floor($media7) == 2) {
            $bg7 = "bg-warning";
          } else if (floor($media7) == 3) {
            $bg7 = "bg-info";
          } else if (floor($media7) == 4) {
            $bg7 = "";
          } else {
            $bg7 = "bg-success";
          }


          echo "


          <div class='row'>
            <div class='col-8'>
              <p class='fs-5'>Nota Média Coordenadores: $media7</p>
            </div>
          </div>
          <p>Coordenador se auto-avalia. Quantidade de registros: $qtd7</p>
          <div class='progress'>
            <div class='progress-bar progress-bar-striped $bg7' role='progressbar' style='width: $media_graf7%' aria-valuenow='10' aria-valuemin='0' aria-valuemax='100'></div>
          </div>
          <hr>
          ";

     
          }

          //-----------------------------------

          $data8 = $_GET['id_data'];
          $data_sql8 = "
          
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
            ) nota_tt8,
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
                WHERE data = $data8
                LIMIT 1
            ) b,
            (
                SELECT sum(1) qtd from `lidercoord` WHERE `data` = $data8
                and idsupervisor != idusuarios
            ) a,
            `lidercoord` c
        WHERE 
              c.`data` = $data8
              and idsupervisor != idusuarios


          ";
          
          $datasql8 = mysqli_query($conexao, $data_sql8);
          
          while ($id_nota8 = mysqli_fetch_assoc($datasql8)) {

          $media8 = substr($id_nota8['nota_tt8'],0,-7);
          $qtd8 = $id_nota8['qtd'];
          $media_div8 = $media8 * 9;
          $media_graf8 = ($media8 * 9) * 2.223;


          if (floor($media8) == 1) {
            $bg8 = "bg-danger";
          } else if (floor($media8) == 2) {
            $bg8 = "bg-warning";
          } else if (floor($media8) == 3) {
            $bg8 = "bg-info";
          } else if (floor($media8) == 4) {
            $bg8 = "";
          } else {
            $bg8 = "bg-success";
          }

     
          echo "

          <div class='row'>
            <div class='col-8'>
              <p class='fs-5'>Nota Média Líderes Colaboradores: $media8</p>
            </div>
          </div>
 
          <p>Coordenador avalia Colaboradores. Quantidade de registros: $qtd8</p>
          
          <div class='progress'>
            <div class='progress-bar progress-bar-striped $bg8' role='progressbar' style='width: $media_graf8%' aria-valuenow='10' aria-valuemin='0' aria-valuemax='100'></div>
          </div>
          
          <hr>
          ";

         }

         //-----------------------------------

         echo"<!-- Seleciona Pergunra -->";

         $sql_perguntas9 = "SELECT * FROM modifica_pergunta";
         $id_perguntas9 = mysqli_query($conexao, $sql_perguntas9);
     
         while ($perguntas_fetch9 = mysqli_fetch_assoc($id_perguntas9)) {
     
         $pergunta_id9 = $perguntas_fetch9['coord'];
     
         }
         echo"<!-- Seleciona Pergunra -->";

         //-------------------------------------------

      
          $data9 = $_GET['id_data'];
          $data_sql9 = "
          
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
          ) nota_tt9,
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
              WHERE data = $data9 AND perguntaid = $pergunta_id9
              LIMIT 1
          ) b,
          (
              SELECT sum(1) qtd from `gerencia` WHERE `data` = $data9 AND perguntaid = $pergunta_id9
          ) a,
          `gerencia` c
      WHERE 
          c.`data` = $data9 AND perguntaid = $pergunta_id9
      

          
          ";
          $datasql9 = mysqli_query($conexao, $data_sql9);
          
          while ($id_nota9 = mysqli_fetch_assoc($datasql9)) {

          $media9 = substr($id_nota9['nota_tt9'],0,-7);
          $qtd9 = $id_nota9['qtd'];
          $media_div9 = $media9 * 9;
          $media_graf9 = ($media9 * 9) * 2.223;


          if (floor($media9) == 1) {
            $bg9 = "bg-danger";
          } else if (floor($media9) == 2) {
            $bg9 = "bg-warning";
          } else if (floor($media9) == 3) {
            $bg9 = "bg-info";
          } else if (floor($media9) == 4) {
            $bg9 = "";
          } else {
            $bg9 = "bg-success";
          }



          echo "

          <div class='row'>
            <div class='col-8'>
              <p class='fs-5'>Nota Média Gerência avalia Competência Liderança: $media9</p>
            </div>
          </div>
  
          <p>Gerência avalia Coordenadores. Quantidade de registros: $qtd9</p>
          <div class='progress'>
             <div class='progress-bar progress-bar-striped $bg9' role='progressbar' style='width: $media_graf9%' aria-valuenow='10' aria-valuemin='0' aria-valuemax='100'></div>
          </div>
          
          <hr>";

         }

         //-----------------------------------

         echo"<!-- Seleciona Pergunra -->";

         $sql_perguntas10 = "SELECT * FROM modifica_pergunta";
         $id_perguntas10 = mysqli_query($conexao, $sql_perguntas10);
     
         while ($perguntas_fetch10 = mysqli_fetch_assoc($id_perguntas10)) {
     
         $pergunta_id10 = $perguntas_fetch10['colab'];
     
         }
         echo"<!-- Seleciona Pergunra -->";
     
     

             //-----------------------------------

      
             $data10 = $_GET['id_data'];
             $data_sql10 = "
             
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
             ) nota_tt9,
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
                 WHERE data = $data10
                 AND perguntaid = $pergunta_id10
                 LIMIT 1
             ) b,
             (
                 SELECT sum(1) qtd from `gerencia` WHERE `data` = $data10 AND perguntaid = $pergunta_id10
             ) a,
             `gerencia` c
         WHERE 
             c.`data` = $data10 AND perguntaid = $pergunta_id10
         
   
             
             ";
             $datasql10 = mysqli_query($conexao, $data_sql10);
             
             while ($id_nota10 = mysqli_fetch_assoc($datasql10)) {
   
             $media10 = substr($id_nota10['nota_tt9'],0,-7);
             $qtd10 = $id_nota10['qtd'];
             $media_div10 = $media10 * 9;
             $media_graf10 = ($media10 * 9) * 2.223;
   
   
             if (floor($media10) == 1) {
               $bg10 = "bg-danger";
             } else if (floor($media10) == 2) {
               $bg10 = "bg-warning";
             } else if (floor($media10) == 3) {
               $bg10 = "bg-info";
             } else if (floor($media10) == 4) {
               $bg10 = "";
             } else {
               $bg10 = "bg-success";
             }
   
   
   
             echo "
   
             <div class='row'>
               <div class='col-8'>
                 <p class='fs-5'>Nota Média Gerência avalia Coordenadores: $media10</p>
               </div>
             </div>
     
             <p>Tania avalia Coordenadores. Quantidade de registros: $qtd10</p>
             <div class='progress'>
                <div class='progress-bar progress-bar-striped $bg10' role='progressbar' style='width: $media_graf10%' aria-valuenow='10' aria-valuemin='0' aria-valuemax='100'></div>
             </div>
             
             ";
   
            }
   
            //-----------------------------------
            
         $media_tt = (($media10 + $media9 + $media8 + $media7 + $media6)/5);

         $media_div = ($media_tt * 20);


         if (floor($media_tt) == 1) {
          $bgtt = "bg-danger";
        } else if (floor($media_tt) == 2) {
          $bgtt = "bg-warning";
        } else if (floor($media_tt) == 3) {
          $bgtt = "bg-info";
        } else if (floor($media_tt) == 4) {
          $bgtt = "";
        } else {
          $bgtt = "bg-success";
        }

         echo "<hr class ='mt-4'>


         <div class='row'>
            <div class='col-8'>
                <p class='fs-5 fw-bold'>Média Total: $media_tt</p>
            </div>
            <div class='col-4'>
             
            </div>
          </div>

         
         <div class='progress'>
          <div class='progress-bar progress-bar-striped $bgtt' role='progressbar' style='width: $media_div%' aria-valuenow='10' aria-valuemin='0' aria-valuemax='100'></div>
        </div>
         
         <hr>
         ";?>

        </div>
       



</body>



<?php } else {
  header('Location: login.php');
} ?>