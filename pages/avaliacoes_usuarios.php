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



  $id_usuario_selecionado = $_GET['idusuario'];


  if ($_GET['idusuario'] != 'null') {
  $usuario_selecionado = "SELECT * FROM usuario WHERE idusuario = '$id_usuario_selecionado' and situacao = 1";
  $usu_select = mysqli_query($conexao, $usuario_selecionado);
  
  while ($nome_selecionado = mysqli_fetch_assoc($usu_select)) {
      $nome_selec = $nome_selecionado['nomecompleto'];
  }
} else if ($_GET['idusuario'] != 'null') {
      $nome_selec = $_GET['idusuario'];
      
} else {
      $nome_selec = 'Selecione';   
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
    <a href="avaliacoes_usuarios.php?id_tipo=null&idusuario=null&id_data=null" class="btn btn-outline-secondary btn-lg m-2">Avaliação Por Usuário</a>
    <a href="avaliacoes_lideres.php?idusuario=null&id_data=null" class="btn btn-secondary btn-lg m-2">Avaliação Por Liderança</a>
    <a href="avaliacoes_nao_realizadas.php?id_data=6&id_data=null" class="btn btn-secondary btn-lg m-2">Usuários Pendentes</a>
  </div>


  <div>
    <label class="fw-bold fs-3 d-flex justify-content-center py-3">Avaliações por Usuários</label>
  </div>


  <div class="container py-2">
    <form action="avaliacoes_usuarios.php" method="GET">
    <div>
    <input name="id_tipo" value="6" type="hidden" id="id_tipo" checked require>
    </div>
      <div class="mb-3">
        <label for="idusuario" class="form-label pt-3">Selecione o Avaliado:</label>
        <select class="form-select" name="idusuario" id="idusuario" required>
        <option value='<?=$id_usuario_selecionado?>' hidden><?=$nome_selec?></option>
          <?php  

          $delega_sql = "SELECT * FROM delega_acoes";
          $delega_query = mysqli_query($conexao, $delega_sql);

          while ($delega_acoes = mysqli_fetch_assoc($delega_query)) {

          $delega_tipo = $delega_acoes['avausu_reter'];

          }

          $editar_usuarios = "SELECT * FROM usuario where situacao = 1 and idusuario not in ($delega_tipo) order by nomecompleto ASC"; // Parametrizado pelo IDussuario do banco de dados
          $id_servico = mysqli_query($conexao, $editar_usuarios);
          
          while ($id_ser = mysqli_fetch_assoc($id_servico)) {

          $idusuario = $id_ser['idusuario'];
          $nomecompleto = $id_ser['nomecompleto'];
  
          echo "<option value='$idusuario'>$nomecompleto</option>";
        
          }?>
       
        </select>
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

      
      

        <div>

        <?php  

        $idusuario = $_GET['idusuario'];
        $id_data = $_GET['id_data'];

        $sql_perguntas1 = "SELECT * FROM modifica_pergunta";
        $id_perguntas1 = mysqli_query($conexao, $sql_perguntas1);

        while ($perguntas_fetch1 = mysqli_fetch_assoc($id_perguntas1)) {

        $pergunta_id1 = $perguntas_fetch1['colab'];
        }

        $sql_perguntas = "SELECT * FROM modifica_pergunta";
        $id_perguntas = mysqli_query($conexao, $sql_perguntas);

        while ($perguntas_fetch = mysqli_fetch_assoc($id_perguntas)) {

        $pergunta_id = $perguntas_fetch['coord'];
        }



        
    
        $notas = "

            SELECT 
            a.id, a.nota1, a.nota2, a.nota3, a.nota4, a.nota5, a.nota6, a.nota7, a.nota8, a.nota9, a.nota10, a.idsupervisor, a.idusuarios, a.perguntaid, a.data, '1' id_tipo,
            null texto1, null texto2, null texto3 , null texto4 , null texto5 , null texto6 , null texto7 , null texto8 , null texto9 , null texto10 
            FROM coord a
            WHERE a.idusuarios = $idusuario and a.data = $id_data
            UNION ALL 
            SELECT 
            b.id, b.nota1, b.nota2, b.nota3, b.nota4, b.nota5, b.nota6, b.nota7, b.nota8, b.nota9, b.nota10, b.idsupervisor, b.idusuarios, b.perguntaid, b.data, '2' id_tipo,
            b.texto1, b.texto2, b.texto3 , b.texto4 , b.texto5 , b.texto6 , b.texto7 , b.texto8 , b.texto9 , b.texto10 
            FROM gerencia b
            WHERE b.idusuarios = $idusuario and b.data = $id_data
            UNION ALL
            SELECT 
            c.id, c.nota1, c.nota2, c.nota3, c.nota4, c.nota5, c.nota6, c.nota7, c.nota8, c.nota9, c.nota10, c.idsupervisor, c.idusuarios, c.perguntaid, c.data, '3' id_tipo,
            c.texto1, c.texto2, c.texto3 , c.texto4 , c.texto5 , c.texto6 , c.texto7 , c.texto8 , c.texto9 , c.texto10 
            FROM lidercoord c
            WHERE c.idusuarios = $idusuario and c.data = $id_data
            UNION ALL
            SELECT 
            d.id, d.nota1, d.nota2, d.nota3, d.nota4, d.nota5, d.nota6, d.nota7, d.nota8, d.nota9, d.nota10, d.idsupervisor, d.idusuarios, d.perguntaid, d.data, '4' id_tipo,
            null texto1, null texto2, null texto3 , null texto4 , null texto5 , null texto6 , null texto7 , null texto8 , null texto9 , null texto10 
            FROM colab d
            WHERE d.idusuarios = $idusuario and d.data = $id_data
        ";

        $nota_find = mysqli_query($conexao, $notas);
        $nota_tt_total = 0;
        if (mysqli_num_rows($nota_find) > 0) {
            while ($id_nota = mysqli_fetch_assoc($nota_find)) {
                $id_quest = $id_nota['id'];
                $id_tipo = $id_nota['id_tipo'];
                $nota1 = $id_nota['nota1'];
                $nota2 = $id_nota['nota2'];
                $nota3 = $id_nota['nota3'];
                $nota4 = $id_nota['nota4'];
                $nota5 = $id_nota['nota5'];
                $nota6 = $id_nota['nota6'];
                $nota7 = $id_nota['nota7'];
                $nota8 = $id_nota['nota8'];
                $nota9 = $id_nota['nota9'];
                $nota10 = $id_nota['nota10'];
                $texto1 = $id_nota['texto1'];
                if (!empty($texto1)) {
                  $texto1 = 'Comentário: ' . $texto1;
                }
                $texto2 = $id_nota['texto2'];
                if (!empty($texto2)) {
                  $texto2 = 'Comentário: ' . $texto2;
                }
                $texto3 = $id_nota['texto3'];
                if (!empty($texto3)) {
                  $texto3 = 'Comentário: ' . $texto3;
                }
                $texto4 = $id_nota['texto4'];
                if (!empty($texto4)) {
                  $texto4 = 'Comentário: ' . $texto4;
                }
                $texto5 = $id_nota['texto5'];
                if (!empty($texto5)) {
                  $texto5 = 'Comentário: ' . $texto5;
                }
                $texto6 = $id_nota['texto6'];
                if (!empty($texto6)) {
                  $texto6 = 'Comentário: ' . $texto6;
                }
                $texto7 = $id_nota['texto7'];
                if (!empty($texto7)) {
                  $texto7 = 'Comentário: ' . $texto7;
                }
                $texto8 = $id_nota['texto8'];
                if (!empty($texto8)) {
                  $texto8 = 'Comentário: ' . $texto8;
                }
                $texto9 = $id_nota['texto9'];
                if (!empty($texto9)) {
                  $texto9 = 'Comentário: ' . $texto9;
                }
                $texto10 = $id_nota['texto10'];
                if (!empty($texto10)) {
                  $texto10 = 'Comentário: ' . $texto10;
                }
                $idsupervisor = $id_nota['idsupervisor'];
                $idusuario_a = isset($id_nota['idusuarios']) ? $id_nota['idusuarios'] : 0;
                $pergid = $id_nota['perguntaid'];
                $data = date('Y', strtotime(str_replace("/", "-", $id_nota["data"])));
                $id_usuario_destino = $id_nota['idusuarios'];


                if($id_tipo == 1 && $pergid == $pergunta_id){
                  echo "<p class='text-decoration-underline fw-bold fs-5'>Auto Avaliação Coordenadores</p>";
                } 
                if($id_tipo == 2 && $pergid == $pergunta_id){
                  echo "<p class='text-decoration-underline fw-bold fs-5'>Gerência Avalia Competência Liderança e Competência Geral</p>";
                } 
                if($id_tipo == 3 && $pergid == $pergunta_id1){
                  echo "<p class='text-decoration-underline  fw-bold fs-5'>Coordenadores Avaliam Colaboradores</p>";
                } 
                if($id_tipo == 4 && $pergid == $pergunta_id1){
                  echo "<p class='text-decoration-underline fw-bold fs-5'>Auto Avaliação Colaboradores</p>";
                } 
                
            

          if ($idusuario_a <> 0) {
          $usuarios_p = "SELECT nomecompleto FROM usuario WHERE idusuario = $idusuario_a";
          $usuarios_p_result = mysqli_query($conexao, $usuarios_p);

          
              while ($usuarios_p_assoc = mysqli_fetch_assoc($usuarios_p_result)) {
                  $usuarios_p_nome = $usuarios_p_assoc['nomecompleto'];
                  echo "<p class='fw-bold fs-5'>Nome do Avaliado: $usuarios_p_nome</p>";
              }
          }


          if ($idsupervisor <> 0) {
          $supervisor = "SELECT nomecompleto FROM usuario WHERE idusuario = $idsupervisor";
          $supervisor_result = mysqli_query($conexao, $supervisor);

              while ($supervisor_assoc = mysqli_fetch_assoc($supervisor_result)) {
                  $supervisor_nome = $supervisor_assoc['nomecompleto'];
                  echo "<p class='fw-bold fs-5'>Supervisor Imediato: $supervisor_nome</p>";
              }
          }


          if ($idusuario_a <> 0) {
        $sql_perguntas = "SELECT * FROM pergunta WHERE id = $pergid";
        $id_perguntas = mysqli_query($conexao, $sql_perguntas);


          while ($perguntas = mysqli_fetch_assoc($id_perguntas)) {
              $pergunta1 = $perguntas['pergunta1'];
              $pergunta2 = $perguntas['pergunta2'];
              $pergunta3 = $perguntas['pergunta3'];
              $pergunta4 = $perguntas['pergunta4'];
              $pergunta5 = $perguntas['pergunta5'];
              $pergunta6 = $perguntas['pergunta6'];
              $pergunta7 = $perguntas['pergunta7'];
              $pergunta8 = $perguntas['pergunta8'];
              $pergunta9 = $perguntas['pergunta9'];
              $pergunta10 = $perguntas['pergunta10'];
          }


        if ($idusuario_a <> 0) {
        $sql_col= "SELECT (
                      IF(pergunta1 <> '', 1, 0) +
                      IF(pergunta2 <> '', 1, 0) +
                      IF(pergunta3 <> '', 1, 0) +
                      IF(pergunta4 <> '', 1, 0) +
                      IF(pergunta5 <> '', 1, 0) +
                      IF(pergunta6 <> '', 1, 0) +
                      IF(pergunta7 <> '', 1, 0) +
                      IF(pergunta8 <> '', 1, 0) +
                      IF(pergunta9 <> '', 1, 0) +
                      IF(pergunta10 <> '', 1, 0)
                  ) qt_col
                  FROM pergunta
                  WHERE id = $pergid
                  LIMIT 1
                    ";
                        
          $col_query = mysqli_query($conexao, $sql_col);
          while ($fetch_col = mysqli_fetch_assoc($col_query)) {

            $divisao = $fetch_col['qt_col']; 
          
          }
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

        $nota_tt = number_format((($nota1 + $nota2 + $nota3 + $nota4 + $nota5 + $nota6 + $nota7 + $nota8 + $nota9 + $nota10)/$divisao), 2, '.', '');



        echo "<div>
        <div class='row'>
            <div class='col'>
                <p class='fw-bold'>Período a avaliar: $data</p>
                <hr>
                <p class='text-decoration-underline' style='display: inline;'>$pergunta1</p>
                <p class='fw-bold' style='display: inline;'>$nota1</p>
                <p class='text-body-secondary fst-italic'>$texto1</p>
                <hr>
                <p class='text-decoration-underline' style='display: inline;'>$pergunta2</p>
                <p class='fw-bold' style='display: inline;'> $nota2</p>
                <p class='text-body-secondary fst-italic'>$texto2</p>
                <hr>
                <p class='text-decoration-underline' style='display: inline;'>$pergunta3</p>
                <p class='fw-bold' style='display: inline;'> $nota3</p>
                <p class='text-body-secondary fst-italic'>$texto3</p>
                <hr>
                <p class='text-decoration-underline' style='display: inline;'>$pergunta4</p>
                <p class='fw-bold' style='display: inline;'> $nota4</p>
                <p class='text-body-secondary fst-italic'>$texto4</p>
                <hr>";
            if($quantidade >= 5 && $quantidade <= 10) {
            echo "<p class='text-decoration-underline' style='display: inline;'>$pergunta5</p>
                  <p class='fw-bold' style='display: inline;'> $nota5</p>
                  <p class='text-body-secondary fst-italic'>$texto5</p>
                  <hr>";}
                if($quantidade >= 6 && $quantidade <= 10) {
            echo"<p class='text-decoration-underline' style='display: inline;'>$pergunta6</p>
                <p class='fw-bold' style='display: inline;'> $nota6</p>
                <p class='text-body-secondary fst-italic'>$texto6</p>
                <hr>";}
                if($quantidade >= 7 && $quantidade <= 10) {
            echo"<p class='text-decoration-underline' style='display: inline;'>$pergunta7</p>
                <p class='fw-bold' style='display: inline;'> $nota7</p>
                <p class='text-body-secondary fst-italic'>$texto7</p>
                <hr>";}
                if($quantidade >= 8 && $quantidade <= 10) {
            echo"<p class='text-decoration-underline' style='display: inline;'>$pergunta8</p>
                <p class='fw-bold' style='display: inline;'> $nota8</p>
                <p class='text-body-secondary fst-italic'>$texto8</p>
                <hr>";}
                if($quantidade >= 9 && $quantidade <= 10) {
            echo"<p class='text-decoration-underline' style='display: inline;'>$pergunta9</p>
                <p class='fw-bold' style='display: inline;'> $nota9</p>
                <p class='text-body-secondary fst-italic'>$texto9</p>
                <hr>";}
                if($quantidade >= 10 && $quantidade <= 10) {
            echo"<p class='text-decoration-underline' style='display: inline;'>$pergunta10</p>
                <p class='fw-bold' style='display: inline;'> $nota10</p>
                <p class='text-body-secondary fst-italic'>Ctexto10</p>
                <hr>";}
            echo"</div>
                  <div class='col-md-auto'>
                      <p class='fw-bold fs-5'>Média da nota: $nota_tt</p>
                  </div>
                  <div class='col col-lg-2'>
                      <form action='../funcoes/exclui_pergunta_colab.php' method='POST'>
                        <input type='hidden' name='idpergunta' value='$id_quest'>
                        <input type='hidden' name='id_tipo' value='$id_tipo'>
                        <input type='hidden' name='id_data' value='$id_data'>
                        <input type='hidden' name='id_usuario' value='$id_usuario_destino'>
                        <button type='submit' class='btn btn-secondary btn-sm'>Excluir</button>
                      </form>
                  </div>
              </div>
         
          </div>
          <hr class='border border-secondary border-2 opacity-50'>"; 





          $qt_perguntas_sql = "
          SELECT SUM(qt_total) AS qt_contas FROM (
            SELECT COUNT(*) AS qt_total FROM coord WHERE idusuarios = $idusuario AND data = $id_data
            UNION ALL
            SELECT COUNT(*) AS qt_total FROM gerencia WHERE idusuarios = $idusuario AND data = $id_data
            UNION ALL
            SELECT COUNT(*) AS qt_total FROM lidercoord WHERE idusuarios = $idusuario AND data = $id_data
            UNION ALL
            SELECT COUNT(*) AS qt_total FROM colab WHERE idusuarios = $idusuario AND data = $id_data
          ) AS subquery
        ";
        $qt_perguntas_query = mysqli_query($conexao, $qt_perguntas_sql);
        
        if ($qt_perguntas_query) {
          $qt_perguntas_assoc = mysqli_fetch_assoc($qt_perguntas_query);
          $qt_contas = $qt_perguntas_assoc['qt_contas'];
        } 




        $nota_tt_total += $nota_tt/$qt_contas;

        
      }      
  }
  echo "<p class='fw-bold fs-5 text-center'>A Média do Avaliado é: $nota_tt_total </p>";
} else {
    $idsupervisor = 0;
    $idusuario_a = 0;
    echo "Não há registros para exibir. </div>";
}

   

  
 ?>
            
              </div>




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