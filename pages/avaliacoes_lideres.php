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
  
  while ($usu_login_fetch = mysqli_fetch_assoc($usu_login_query)) {
  
  $usu_login = $usu_login_fetch['nomecompleto'];
  
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
    <a href="avaliacoes_usuarios.php?id_tipo=null&idusuario=null&id_data=null" class="btn btn-secondary btn-lg m-2">Avaliação Por Usuário</a>
    <a href="avaliacoes_lideres.php?idusuario=null&id_data=null" class="btn btn-outline-secondary btn-lg m-2">Avaliação Por Liderança</a>
    <a href="avaliacoes_nao_realizadas.php?id_data=6&id_data=null" class="btn btn-secondary btn-lg m-2">Usuários Pendentes</a>
  </div>


  <div>
    <label class="fw-bold fs-3 d-flex justify-content-center py-3">Avaliações Líderes</label>
  </div>




  <div class="container py-2">
    <form action="avaliacoes_lideres.php" method="GET">
    <div>
    </div>
      <div class="mb-3">
        <label for="idusuario" class="form-label pt-3">Selecione o Avaliado:</label>
        <select class="form-select" name="idusuario" id="idusuario" required>
           <option value='<?=$id_usuario_selecionado?>' hidden><?=$nome_selec?></option>
          <?php

          $delega_sql = "SELECT * FROM delega_acoes";
          $delega_query = mysqli_query($conexao, $delega_sql);

          while ($delega_acoes = mysqli_fetch_assoc($delega_query)) {

          $delega_tipo = $delega_acoes['avalid_reter'];
          $delega_tipo1 = $delega_acoes['rh_gerente'];

          }


          $editar_usuarios = "SELECT * FROM usuario where situacao = 1 and lider in($delega_tipo1) and idusuario not in ($delega_tipo) order by nomecompleto ASC"; // Parametrizado pelo IDussuario do banco de dados
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
            b.id, b.nota1, b.nota2, b.nota3, b.nota4, b.nota5, b.nota6, b.nota7, b.nota8, b.nota9, b.nota10, b.idsupervisor, b.idusuarios, b.perguntaid, b.data, '1' id_tipo
            FROM gerencia b
            WHERE b.idsupervisor = $idusuario and b.data = $id_data
            UNION ALL
            SELECT 
            c.id, c.nota1, c.nota2, c.nota3, c.nota4, c.nota5, c.nota6, c.nota7, c.nota8, c.nota9, c.nota10, c.idsupervisor, c.idusuarios, c.perguntaid, c.data, '2' id_tipo
            FROM lidercoord c
            WHERE c.idsupervisor = $idusuario and c.data = $id_data
        ";

        $nota_find = mysqli_query($conexao, $notas);

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
                $idsupervisor = $id_nota['idsupervisor'];
                $idusuario_a = isset($id_nota['idusuarios']) ? $id_nota['idusuarios'] : 0;
                $pergid = $id_nota['perguntaid'];
                $data = date('Y', strtotime(str_replace("/", "-", $id_nota["data"])));
                $id_usuario_destino = $id_nota['idsupervisor'];
            
          if($id_tipo == 1 && $pergid == $pergunta_id1 ){
            echo "<p class='text-decoration-underline fw-bold fs-5'>Gerência avalia Coordenadores</p>";
          } 
          if($id_tipo == 1 && $pergid == $pergunta_id){
            echo "<p class='text-decoration-underline fw-bold fs-5'>Gerência avalia Competência Liderança</p>";
          } 
          if($id_tipo == 2){
            echo "<p class='text-decoration-underline fw-bold fs-5'>Avaliação Coordenadores</p>";
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
    
            $nota_tt = number_format((($nota1 + $nota2 + $nota3 + $nota4 + $nota5 + $nota6 + $nota7 + $nota8 + $nota9 + $nota10)/$divisao), 2, '.', '');
    



          echo "<div>
              <div class='row'>
                  <div class='col'>
                      <p class='fw-bold'>Período a avaliar: $data</p>
                  </div>
                  <div class='col'>
                      <p class='fw-bold fs-5'>Média da nota: $nota_tt</p>
                  </div>
                  <div class='col'>

                  <form action='../funcoes/exclui_pergunta_coord.php' method='POST'>
                    <input type='hidden' name='idpergunta' value='$id_quest'>
                    <input type='hidden' name='id_tipo' value='$id_tipo'>
                    <input type='hidden' name='id_usuario' value='$id_usuario_destino'>
                    <button type='submit' class='btn btn-secondary btn-sm'>Excluir</button>
                  </form>


                  </div>
              </div>
          </div>
          <hr>";
      }
    }
  } else {
      $idsupervisor = 0;
      $idusuario_a = 0;
      echo "Não há registros para exibir.";
  }
      
      ; ?>
            
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