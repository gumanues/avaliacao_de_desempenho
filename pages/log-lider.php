
<?php
require_once('../conexao.php');
session_start();
unset($_SESSION['usureferencia']);

if (isset($_SESSION['login']) && $_SESSION['login'] == 1) {
$id_login = $_SESSION['id'];


$param_sql = "SELECT * FROM delega_acoes";
$param_query = mysqli_query($conexao, $param_sql);

while ($param_fetch = mysqli_fetch_assoc($param_query)) {
  $ano_vigente = $param_fetch['ano_vigente'];
}


function buscarDadosUsuario($conexao, $idusuario) {
    $sql = "SELECT * FROM usuario WHERE idusuario = $idusuario";
    $resultado = mysqli_query($conexao, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        return mysqli_fetch_assoc($resultado);
    } else {
        return array("error" => "Usuário não encontrado");
    }
}

function buscarDadosPergunta($conexao, $idpergunta) {
  $sql = "SELECT * FROM pergunta WHERE id = $idpergunta";
  $resultado = mysqli_query($conexao, $sql);

  if ($resultado && mysqli_num_rows($resultado) > 0) {
      return mysqli_fetch_assoc($resultado);
  } else {
      return array("error" => "Pergunta não encontrada");
  }
}

function buscarDadosLocal($conexao, $idpergunta) {
  $sql = "SELECT * FROM pergunta WHERE id = $idpergunta";
  $resultado = mysqli_query($conexao, $sql);

  if ($resultado && mysqli_num_rows($resultado) > 0) {
      return mysqli_fetch_assoc($resultado);
  } else {
      return array("error" => "Pergunta não encontrada");
  }
}

function buscarDadosPergunta1($conexao, $idpergunta) {
    $sql = "SELECT * FROM pergunta WHERE id = $idpergunta";
    $resultado = mysqli_query($conexao, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        return mysqli_fetch_assoc($resultado);
    } else {
        return array("error" => "Pergunta não encontrada");
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idusuario = $_POST['id'];
    $cadastro = $_POST['cadastro'];

    if ($cadastro == "edtusuario") {
        $usuario = buscarDadosUsuario($conexao, $idusuario);
        echo json_encode($usuario);
        exit; 
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $idpergunta = $_POST['id'];
  $cadastro = $_POST['cadastro'];

  if ($cadastro == "edtp pergunta") {
      $pergunta = buscarDadosPergunta($conexao, $idpergunta);
      echo json_encode($pergunta);
      exit;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $idpergunta = $_POST['id'];
  $cadastro = $_POST['cadastro'];

  if ($cadastro == "buscardadoslocal") {
      $pergunta = buscarDadosLocal($conexao, $idpergunta);
      echo json_encode($pergunta);
      exit; 
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $idpergunta = $_POST['id'];
  $cadastro = $_POST['cadastro'];

  if ($cadastro == "buscardadoslocal1") { 
      $pergunta = buscarDadosPergunta1($conexao, $idpergunta);
      echo json_encode($pergunta);
      exit; 
  }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulário de Desempenho</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>

  <script>
    $(document).ready(function () {
      $("#idusuario").on("change", function () {
        var id = $(this).val();
        var cadastro = 'edtusuario';

        $.ajax({
          url: "<?= $_SERVER['PHP_SELF']; ?>",
          data: { id: id, cadastro: cadastro },
          type: "post",
          dataType: "json", 
          success: function (dados) {
            if (dados.error) {
              console.error(dados.error);
              
            } else {
              $("#nomecompletoEdt").val(dados.nomecompleto);
              $("#cargoEdt").val(dados.cargo);
              $("#setorEdt").val(dados.setorid);
              $("#situacaoEdt").val(dados.situacao);
              $("#liderEdt").val(dados.lider);

              
            }
          },
          error: function (xhr, status, error) {
            console.error("Erro na requisição AJAX:", status, error);
            
          }
        });
      });
    });

    $(document).ready(function () {
            $("#idperguntaedt").on("change", function () {
                var id = $(this).val();
                var cadastro = 'edtp pergunta';

                $.ajax({
                    url: "<?= $_SERVER['PHP_SELF']; ?>",
                    data: {id: id, cadastro: cadastro},
                    type: "post",
                    dataType: "json", 
                    success: function (dados) {
                        if (dados.error) {
                            console.error(dados.error);
                            
                        } else {
                            $("#pergunta1Edt").val(dados.pergunta1);
                            $("#pergunta2Edt").val(dados.pergunta2);
                            $("#pergunta3Edt").val(dados.pergunta3);
                            $("#pergunta4Edt").val(dados.pergunta4);
                            $("#pergunta5Edt").val(dados.pergunta5);
                            $("#pergunta6Edt").val(dados.pergunta6);
                            $("#pergunta7Edt").val(dados.pergunta7);
                            $("#pergunta8Edt").val(dados.pergunta8);
                            $("#pergunta9Edt").val(dados.pergunta9);
                            $("#pergunta10Edt").val(dados.pergunta10);
                            
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Erro na requisição AJAX:", status, error);
                        
                    }
                });
            });
        });
        $(document).ready(function () {
            $("#idpergunta").on("change", function () {
                var id = $(this).val();
                var cadastro = 'buscardadoslocal';

                $.ajax({
                    url: "<?= $_SERVER['PHP_SELF']; ?>",
                    data: {id: id, cadastro: cadastro},
                    type: "post",
                    dataType: "json", 
                    success: function (dados) {
                        if (dados.error) {
                            console.error(dados.error);
                            
                        } else {
                            
                            $("#pergunta1").html(dados.pergunta1);
                            $("#pergunta2").html(dados.pergunta2);
                            $("#pergunta3").html(dados.pergunta3);
                            $("#pergunta4").html(dados.pergunta4);
                            $("#pergunta5").html(dados.pergunta5);
                            $("#pergunta6").html(dados.pergunta6);
                            $("#pergunta7").html(dados.pergunta7);
                            $("#pergunta8").html(dados.pergunta8);
                            $("#pergunta9").html(dados.pergunta9);
                            $("#pergunta10").html(dados.pergunta10);
                            
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Erro na requisição AJAX:", status, error);
                        
                    }
                });
            });
        });
        $(document).ready(function () {
            $("#idpergunta1").on("change", function () { 
                var id = $(this).val();
                var cadastro = 'buscardadoslocal1'; 

                $.ajax({
                    url: "<?= $_SERVER['PHP_SELF']; ?>",
                    data: {id: id, cadastro: cadastro},
                    type: "post",
                    dataType: "json", 
                    success: function (dados) {
                        if (dados.error) {
                            console.error(dados.error);
                            
                        } else {
                            
                            $("#pergunta1_1").html(dados.pergunta1);
                            $("#pergunta2_1").html(dados.pergunta2);
                            $("#pergunta3_1").html(dados.pergunta3);
                            $("#pergunta4_1").html(dados.pergunta4);
                            $("#pergunta5_1").html(dados.pergunta5);
                            $("#pergunta6_1").html(dados.pergunta6);
                            $("#pergunta7_1").html(dados.pergunta7);
                            $("#pergunta8_1").html(dados.pergunta8);
                            $("#pergunta9_1").html(dados.pergunta9);
                            $("#pergunta10_1").html(dados.pergunta10);

                            
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Erro na requisição AJAX:", status, error);
                        
                    }
                });
            });
        });

  </script>
  <link rel="stylesheet" type="text/css" href="../css/style_login.css">
  <link rel="icon" type="image/x-icon" href="../img/pag.ico">
</head>


<body>


<!-- modal editar usuário -->

  <div class="modal fade" id="staticBackdrop4" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">

    <div class="modal-dialog">

      <form action="../funcoes/editar_usuario.php" method="post">

        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Usuários</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>


          <div class="modal-body">



            <div class="mb-3">
              <label for="idusuario" class="form-label">Selecione o usuário</label>
              <select class="form-select" name="idusuario" id="idusuario" required>
                <option value=''>Selecione</option>
                <?php
            $editar_usuarios = "SELECT * FROM usuario order by situacao desc, nomecompleto asc";
            $id_servico = mysqli_query($conexao, $editar_usuarios);

            while ($id_ser = mysqli_fetch_assoc($id_servico)) {
                $idusuarioedt = $id_ser['idusuario'];
                $nomecompletoedt = $id_ser['nomecompleto'];
                $cargoedt = $id_ser['cargo'];
                $setoredt = $id_ser['setorid'];
                $situacaoedt = $id_ser['situacao'];
                $lideredt = $id_ser['lider'];
                $setoredt = $id_ser['setorid'];


                if ($situacaoedt == 1) {
                  $situacaovisu = "";
                } else {
                  $situacaovisu = "- Inativo(a)";
                }

                echo "<option value='$idusuarioedt'>$nomecompletoedt $situacaovisu</option>";
            }


            ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="nomecompleto" name="nomecompleto" class="form-label">Nome Completo</label>
              <input type="text" class="form-control" id="nomecompletoEdt" name="nomecompleto">
            </div>
            <div class="mb-3">
                  <label for="cargo" name="cargo" class="form-label">Cargo</label>
                  <input type="text" class="form-control" id="cargoEdt" name="cargo">
                </div>
                <div class="mb-3">
                  <label for='situacao' name='situacao' class='form-label'>Setor</label>
                  <select class="form-select" name="setor" id="setorEdt" required>
                    <option value=''>Selecione</option>
                    <?php  
                    $sql_setor = "SELECT * FROM setor";
                    $query_setor = mysqli_query($conexao, $sql_setor);
                    
                    while ($id_set = mysqli_fetch_assoc($query_setor)) {

                    $idsetor = $id_set['id'];
                    $setor = $id_set['setor'];

                    echo "<option value='$idsetor'>$setor</option>";
                  
              }?>
                  </select>
                </div>
            <div class='mb-3'>
              <label for='senha' name='senha' class='form-label'>Senha</label>
              <input type='password' value ='' class='form-control' id='senhaEdt' name='senha'>
            </div>
            <div class='mb-3 pt-2'>

            <div class="row text-start">
              <div class="col col-lg-2">
            <label for='situacao' name='situacao' class='form-label'>Acesso</label>
            </div>
            <div class="col" style="margin-top: -7px;">
            <input class="form-control-plaintext" style=" font-weight:bold;" type="text" id="liderEdt">
            </div>
            </div>

              <div class='form-check'>
                <input class='form-check-input' type='hidden' name='flexRadioDefault' value='N' id='nenhum' checked>
                <input class='form-check-input' type='radio' name='flexRadioDefault' value='0' id='nenhum'>
                <label class='form-check-label' for='nenhum'>
                  Acesso Nenhum = 0
                </label>
              </div>
              <div class='form-check'>
                <input class='form-check-input' type='radio' name='flexRadioDefault' value='1' id='coord'>
                <label class='form-check-label' for='coord'>
                  Acesso como Coordenador = 1
                </label>
              </div>
              <div class='form-check'>
                <input class='form-check-input' type='radio' name='flexRadioDefault' value='2' id='lider'>
                <label class='form-check-label' for='lider'>
                  Acesso como Gerência = 2
                </label>
              </div>
            </div>
            <div class='mb-3 pt-2'>
              
            
            <div class="row text-start">
              <div class="col col-lg-2">
            <label for='situacao' name='situacao' class='form-label'>Situação</label>
            </div>
            <div class="col" style="margin-top: -7px;">
            <input class="form-control-plaintext" style=" font-weight:bold;" type="text" id="situacaoEdt">
            </div>
            </div>



              <div class='form-check'>
                <input class='form-check-input' type='hidden' name='flexRadioDefault1' value='N' id='ativo' checked>
                <input class='form-check-input' type='radio' name='flexRadioDefault1' value='1' id='ativo'>
                <label class='form-check-label' for='ativo'>
                  Ativo = 1
                </label>
              </div>
              <div class='form-check'>
                <input class='form-check-input' type='radio' name='flexRadioDefault1' value='0' id='inativo'>
                <label class='form-check-label' for='inativo'>
                  Inativo = 0
                </label>
              </div>
            </div>



          </div>
          <div class='modal-footer'>
            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fechar</button>
            <button type='submit' class='btn btn-secondary'>Salvar</button>
          </div>
      </form>
    </div>
  </div>
  </div>
  </div>
<!-- Modal editar usuário -->




   <!-- Edição Perguntas -->
   <div class="modal fade" id="staticBackdrop6" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form action="../funcoes/editar_perguntas.php" method="post">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Perguntas</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <label for="idperguntaedt" class="form-label">Selecione qual pergunta</label>
              <select class="form-select" name="idperguntaedt" id="idperguntaedt" required>
                <option value=''>Selecione</option>
                <?php


                $sql_perguntas = "SELECT * FROM pergunta order by id desc";
                $id_perguntas = mysqli_query($conexao, $sql_perguntas);

                while ($perguntas = mysqli_fetch_assoc($id_perguntas)) {

                $idpergunta = $perguntas['id'];
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

                echo "<option value='$idpergunta'>$idpergunta - $pergunta1</option>";

              }
              
?>
              </select>
              <div class='mb-3 pt-3'>
                <label for='pergunta1' name='pergunta1' class='form-label'>Pergunta 1</label>
                <input type='text' class='form-control' id='pergunta1Edt' name='pergunta1' required>
              </div>
              
              <div class='mb-3'>
                <label for='pergunta2' name='pergunta2' class='form-label'>Pergunta 2</label>
                <input type='text' class='form-control' id='pergunta2Edt' name='pergunta2' required>
              </div>
              
              <div class='mb-3'>
                <label for='pergunta3' name='pergunta3' class='form-label'>Pergunta 3</label>
                <input type='text' class='form-control' id='pergunta3Edt' name='pergunta3' required>
              </div>
              
              <div class='mb-3'>
                <label for='pergunta4' name='pergunta4' class='form-label'>Pergunta 4</label>
                <input type='text' class='form-control' id='pergunta4Edt' name='pergunta4' required>
              </div>
              
              <div class='mb-3'>
                <label for='pergunta5' name='pergunta5' class='form-label'>Pergunta 5</label>
                <input type='text' class='form-control' id='pergunta5Edt' name='pergunta5' required>
              </div>
              
              <div class='mb-3'>
                <label for='pergunta6' name='pergunta6' class='form-label'>Pergunta 6</label>
                <input type='text' class='form-control' id='pergunta6Edt' name='pergunta6'>
              </div>
              
              <div class='mb-3'>
                <label for='pergunta7' name='pergunta7' class='form-label'>Pergunta 7</label>
                <input type='text' class='form-control' id='pergunta7Edt' name='pergunta7'>
              </div>
              
              <div class='mb-3'>
                <label for='pergunta8' name='pergunta8' class='form-label'>Pergunta 8</label>
                <input type='text' class='form-control' id='pergunta8Edt' name='pergunta8'>
              </div>
              
              <div class='mb-3'>
                <label for='pergunta9' name='pergunta9' class='form-label'>Pergunta 9</label>
                <input type='text' class='form-control' id='pergunta9Edt' name='pergunta9'>
              </div>
              
              <div class='mb-3'>
                <label for='pergunta10' name='pergunta10' class='form-label'>Pergunta 10</label>

                <input type='text' class='form-control' id='pergunta10Edt' name='pergunta10'>
              </div>
            </div>



            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-secondary">Salvar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
<!-- Modal Editar Perguntas -->
<!-- Modal Editar Local Perguntas -->




<div class="modal fade" id="staticBackdrop7" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form action="../funcoes/local_pergunta.php" method="post">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Local da pergunta</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


              <div class="container text-center">
                <div class="row">
                  <div class="col">



                    <label for="idusuario" class="form-label fw-bold"><br>Pergunta Atual Colaboradores: <br></label>

                    <?php

                          $sql_perguntas_local = "SELECT * FROM pergunta a, modifica_pergunta b where a.id = b.colab";
                          $id_perguntas_local = mysqli_query($conexao, $sql_perguntas_local);

                          while ($pergunta_local = mysqli_fetch_assoc($id_perguntas_local)) {

                          $idpergunta_local = $pergunta_local['id'];
                          $pergunta_local_1 = $pergunta_local['pergunta1'];
                          $pergunta_local_2 = $pergunta_local['pergunta2'];
                          $pergunta_local_3 = $pergunta_local['pergunta3'];
                          $pergunta_local_4 = $pergunta_local['pergunta4'];
                          $pergunta_local_5 = $pergunta_local['pergunta5'];
                          $pergunta_local_6 = $pergunta_local['pergunta6'];
                          $pergunta_local_7 = $pergunta_local['pergunta7'];
                          $pergunta_local_8 = $pergunta_local['pergunta8'];
                          $pergunta_local_9 = $pergunta_local['pergunta9'];
                          $pergunta_local_10 = $pergunta_local['pergunta10'];


                          }
                          ?>
                    <?php
                          echo "<p>$pergunta_local_1</p>";
                          echo "<p>$pergunta_local_2</p>";
                          echo "<p>$pergunta_local_3</p>";
                          echo "<p>$pergunta_local_4</p>";
                          echo "<p>$pergunta_local_5</p>";
                          echo "<p>$pergunta_local_6</p>";
                          echo "<p>$pergunta_local_7</p>";
                          echo "<p>$pergunta_local_8</p>";
                          echo "<p>$pergunta_local_9</p>";
                          echo "<p>$pergunta_local_10</p>";
                          ?>



                  </div>
                  <div class=" col mb-3">
                    <label for="idpergunta" class="form-label">Editar Para:</label>
                    <select class="form-select" name="idpergunta" id="idpergunta" required>
                        <option value=''>Selecione</option>
                        <?php
                        $sql_perguntas = "SELECT * FROM pergunta order by id desc";
                        $id_perguntas = mysqli_query($conexao, $sql_perguntas);

                        while ($pergunta = mysqli_fetch_assoc($id_perguntas)) {
                            $idpergunta = $pergunta['id'];
                            $pergunta = $pergunta['pergunta1'];
                            echo "<option value='$idpergunta'>$idpergunta - $pergunta</option>";
                        }
                        ?>
                    </select>
                

                      <div class="">
                          <p class='mt-2' id="pergunta1"></p>
                          <p id="pergunta2"></p>
                          <p id="pergunta3"></p>
                          <p id="pergunta4"></p>
                          <p id="pergunta5"></p>
                          <p id="pergunta6"></p>
                          <p id="pergunta7"></p>
                          <p id="pergunta8"></p>
                          <p id="pergunta9"></p>
                          <p id="pergunta10"></p>
                      </div>

                  <!-- Parte das perguntas 2 -->
                  </div>
                  <hr class="m-3">
                  <div class="container text-center">
                    <div class="row">
                      <div class="col">



                        <label for="idusuario" class="form-label fw-bold">Pergunta Atual Coordenadores <br> e
                          Gerência:</label>

                        <?php

                          $sql_perguntas_local = "SELECT * FROM pergunta a, modifica_pergunta b where a.id = b.coord";
                          $id_perguntas_local = mysqli_query($conexao, $sql_perguntas_local);

                          while ($pergunta_local = mysqli_fetch_assoc($id_perguntas_local)) {

                          $idpergunta_local = $pergunta_local['id'];
                          $pergunta_local_1 = $pergunta_local['pergunta1'];
                          $pergunta_local_2 = $pergunta_local['pergunta2'];
                          $pergunta_local_3 = $pergunta_local['pergunta3'];
                          $pergunta_local_4 = $pergunta_local['pergunta4'];
                          $pergunta_local_5 = $pergunta_local['pergunta5'];
                          $pergunta_local_6 = $pergunta_local['pergunta6'];
                          $pergunta_local_7 = $pergunta_local['pergunta7'];
                          $pergunta_local_8 = $pergunta_local['pergunta8'];
                          $pergunta_local_9 = $pergunta_local['pergunta9'];
                          $pergunta_local_10 = $pergunta_local['pergunta10'];


                          }
                          ?>
                        <?php
                          echo "<p>$pergunta_local_1</p>";
                          echo "<p>$pergunta_local_2</p>";
                          echo "<p>$pergunta_local_3</p>";
                          echo "<p>$pergunta_local_4</p>";
                          echo "<p>$pergunta_local_5</p>";
                          echo "<p>$pergunta_local_6</p>";
                          echo "<p>$pergunta_local_7</p>";
                          echo "<p>$pergunta_local_8</p>";
                          echo "<p>$pergunta_local_9</p>";
                          echo "<p>$pergunta_local_10</p>";
                          ?>



                      </div>
                      

                      <div class="col mb-3">
                        <label for="idpergunta1" class="form-label">Editar Para:</label>
                        <select class="form-select" name="idpergunta1" id="idpergunta1" required> <!-- Alteração no ID do elemento -->
                            <option value=''>Selecione</option>
                            <?php
                            $sql_perguntas = "SELECT * FROM pergunta order by id desc";
                            $id_perguntas = mysqli_query($conexao, $sql_perguntas);

                            while ($pergunta = mysqli_fetch_assoc($id_perguntas)) {
                                $idpergunta = $pergunta['id'];
                                $pergunta = $pergunta['pergunta1'];
                                echo "<option value='$idpergunta'>$idpergunta - $pergunta</option>";
                            }
                            ?>
                        </select>
                

                        <p class="mt-2" id="pergunta1_1"></p>
                        <p id="pergunta2_1"></p>
                        <p id="pergunta3_1"></p>
                        <p id="pergunta4_1"></p>
                        <p id="pergunta5_1"></p>
                        <p id="pergunta6_1"></p>
                        <p id="pergunta7_1"></p>
                        <p id="pergunta8_1"></p>
                        <p id="pergunta9_1"></p>
                        <p id="pergunta10_1"></p>

                    </div>




                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-secondary">Salvar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>


<!-- Modal Editar Local Perguntas -->

<!-- Inicio HTML -->


  <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Avaliação de Desempenho</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">


        <?php

          $usu_login_sql = "SELECT * FROM usuario where idusuario = $id_login";
          $usu_login_query = mysqli_query($conexao, $usu_login_sql);
          
          while ($usu_login_fetch = mysqli_fetch_assoc($usu_login_query)) {
          
          $usu_login = $usu_login_fetch['nomecompleto'];
          
          }




        $delega_sql = "SELECT * FROM delega_acoes";
        $delega_query = mysqli_query($conexao, $delega_sql);

        while ($delega_acoes = mysqli_fetch_assoc($delega_query)) {
          
              $delega_tipo = $delega_acoes['lid_acess_lid_reter'];
              $delega_tipo_array = explode(",", $delega_tipo);
              $delega_tipo1 = $delega_acoes['lid_acess_ger_reter'];
              $delega_tipo1_array = explode(",", $delega_tipo1);
              $delega_tipo2 = $delega_acoes['acess_avaliacao'];
              $delega_tipo2_array = explode(",", $delega_tipo2);
        
        }
        
        
        if (in_array($id_login, $delega_tipo2_array)) {

          echo "<li class='nav-item'>
                    <a class='nav-link' href='avaliacoes.php?id_data=6&id_data=null' type='button'>Avaliações</a>
                  </li>
                  <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                      Configurações
                    </a>
                    <ul class='dropdown-menu'>
                    <li><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#staticBackdrop8'>
                    Alterar Ano Vignte</a>
                    </li>
                    <hr>
                    <label for='dropdown-menu' class='ms-3 m-1'>Usuários:</label>
                    <li><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#staticBackdrop3'>
                        Cadastrar Usuários</a>
                    </li>
                    <li><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#staticBackdrop4'>
                        Editar Usuários</a>
                    </li>
                    <hr>
                    <label for='dropdown-menu' class='ms-3 m-1'>Perguntas:</label>
                    <li><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#staticBackdrop5'>
                        Cadastrar Perguntas</a>
                    </li>
                    <li><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#staticBackdrop6'>
                        Editar Perguntas</a>
                    </li>
                    <li><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#staticBackdrop7'>
                        Localização Perguntas</a>
                    </li>
                    <hr>
                    <label for='dropdown-menu'  class='ms-3 m-1'>Parâmetros:</label>
                    <li><a href='parametros.php' class='dropdown-item' >
                       Acessar Parâmetros</a>
                    </li>
                  </ul>
                </li>";
        }

          ?>

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


<!-- Alertas Edições -->

<div id="alertas">
      <?php if(isset($_GET['retorno'])==true && $_GET['retorno']==5){ ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span>Editado com Sucesso!</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php } if(isset($_GET['retorno'])==true && $_GET['retorno']==6){ ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span>Cadastrado com Sucesso!</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php } ?>
</div>

<!-- Alertas Edições -->

<!-- Alertas -->

<div id="alertas">
    <?php if(isset($_GET['retorno'])==true && $_GET['retorno']==1){ ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <span>Houve um problema ao cadastrar!</span>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php }else if(isset($_GET['retorno'])==true && $_GET['retorno']==1.1){ ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <span>Cadastrado com sucesso!</span>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php } ?>
    <script>
    $(document).ready(function () {
      function checkURLParameter() {
        const urlParams = new URLSearchParams(window.location.search);
        const retornoValue = urlParams.get("retorno");
        if (retornoValue === "1.1") {
          $('#staticBackdrop3').modal('show');
        }
      }
      checkURLParameter();
    });
  </script>
</div>

<div id="alertas">
    <?php if(isset($_GET['retorno'])==true && $_GET['retorno']==2){ ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <span>Houve um problema ao Editar!</span>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php }else if(isset($_GET['retorno'])==true && $_GET['retorno']==2.2){ ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <span>Editado com sucesso!</span>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php } ?>
    <script>
    $(document).ready(function () {
      function checkURLParameter() {
        const urlParams = new URLSearchParams(window.location.search);
        const retornoValue = urlParams.get("retorno");
        if (retornoValue === "2.2") {
          $('#staticBackdrop4').modal('show');
        }
      }
      checkURLParameter();
    });
  </script>
</div>
  

  <!-- Envios -->

  <div id="alertas">
      <?php if(isset($_GET['retorno'])==true && $_GET['retorno']==9){ ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span>Formulário enviado com Sucesso!</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
<?php } ?>
</div>



    <div>
      <label class="fw-bold fs-3 d-flex justify-content-center py-5">Apenas Gerência</label>
    </div>
    <!-- Acesso Avaliação -->

    <div class="container text-center py-4 d-flex justify-content-center">
      <div class="row">


<?php

if (in_array($id_login, $delega_tipo_array)) { // apenas para Sheila e Tania parametrizado pelo ID do banco de dados

      echo "<div class='col ms-5'>
          <a class='' style='text-decoration: none; color: inherit;' href='gerencia.php'>
              <div class='card' style='width: 18rem;'>
              <img src='../img/Lider2.jpeg' class='card-img-top' width='250' height='250' alt='...'>
            <div class='card-body'>  
            <h5 class='card-title'>Iniciar Avaliação Gerente Líder</h5>
            <p class='text-body-secondary'>Gerência avalia Competência Liderança</p>
            </div>
          </div>
          </a>
        </div>";

if (in_array($id_login, $delega_tipo1_array)) { // apenas Tania parametrizado pelo ID do banco de dados

        echo "<div class='col ms-5'>
            <a class='' style='text-decoration: none; color: inherit;' href='lider-gerencia.php'>
              <div class='card' style='width: 18rem;'>
              <img src='../img/Lider.png' class='card-img-top' width='250' height='250' alt='...'>
            <div class='card-body'>
            <h5 class='card-title'>Iniciar Avaliação Gerente Coordenador</h5>
            <p class='text-body-secondary'><br>Gerência avalia Competência Geral</p>
            </div>
          </div>
          </a>
        </div>
        ";
}}?>
      </div>
    </div>



  <div>


    <!-- Modal Cadastro-->
    <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form action="../funcoes/cadastro_usuario.php" method="post">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar Usuários</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


              <div>
                <div class="mb-3">
                  <label for="nomecompleto" name="nomecompleto" class="form-label">Nome Completo</label>
                  <input type="text" class="form-control" id="nomecompletoEdt" name="nomecompleto" required>
                </div>
                <div class="mb-3">
                  <label for="cargo" name="cargo" class="form-label">Cargo</label>
                  <input type="text" class="form-control" id="cargoEdt" name="cargo">
                </div>
                <div class="mb-3">
                  <label for="setor" name="setor" class="form-label">Setor</label>
                  <select class="form-select" name="setor" id="setor" required>
                    <option value=''>Selecione</option>
                    <?php  
                    $sql_setor = "SELECT * FROM setor";
                    $query_setor = mysqli_query($conexao, $sql_setor);
                    
                    while ($id_set = mysqli_fetch_assoc($query_setor)) {

                    $idsetor = $id_set['id'];
                    $setor = $id_set['setor'];

                    echo "<option value='$idsetor'>$setor</option>";
                  
              }

              ?>

                  </select>
                </div>
                <div class="mb-3">
                  <label for="senha" name="senha" class="form-label">Senha</label>
                  <input type="password" class="form-control" id="senhaEdt" name="senha" required>
                </div>
              </div>
              <label for="situacao" name="situacao" class="form-label">Acesso</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" value="0" id="nenhum" checked>
                <label class="form-check-label" for="nenhum">
                  Acesso Nenhum
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" value="1" id="coord">
                <label class="form-check-label" for="coord">
                  Acesso como Coordenador
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" value="2" id="lider">
                <label class="form-check-label" for="lider">
                  Acesso como Líder/Coordenador
                </label>
              </div>


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-secondary">Salvar</button>
            </div>
          </div>
        </form>
      </div>
    </div>


    <!-- Modal Cadastro-->

    <!-- Modal Perguntas -->

    <div class="modal fade" id="staticBackdrop5" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form action="../funcoes/cadastro_perguntas.php" method="post">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar Perguntas</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


              <div class="mb-3">
                <label for="pergunta1" name="pergunta1" class="form-label">Pergunta 1</label>
                <input type="text" class="form-control" id="perguntaEdt1" name="pergunta1" required>
              </div>
              <div class="mb-3">
                <label for="pergunta2" name="pergunta2" class="form-label">Pergunta 2</label>
                <input type="text" class="form-control" id="perguntaEdt2" name="pergunta2" required>
              </div>
              <div class="mb-3">
                <label for="pergunta3" name="pergunta3" class="form-label">Pergunta 3</label>
                <input type="text" class="form-control" id="perguntaEdt3" name="pergunta3" required>
              </div>
              <div class="mb-3">
                <label for="pergunta4" name="pergunta4" class="form-label">Pergunta 4</label>
                <input type="text" class="form-control" id="perguntaEdt4" name="pergunta4" required>
              </div>
              <div class="mb-3">
                <label for="pergunta5" name="pergunta5" class="form-label">Pergunta 5</label>
                <input type="text" class="form-control" id="perguntaEdt5" name="pergunta5" required>
              </div>
              <div class="mb-3">
                <label for="pergunta6" name="pergunta6" class="form-label">Pergunta 6</label>
                <input type="text" class="form-control" id="perguntaEdt6" name="pergunta6">
              </div>
              <div class="mb-3">
                <label for="pergunta7" name="pergunta7" class="form-label">Pergunta 7</label>
                <input type="text" class="form-control" id="perguntaEdt7" name="pergunta7">
              </div>
              <div class="mb-3">
                <label for="pergunta8" name="pergunta8" class="form-label">Pergunta 8</label>
                <input type="text" class="form-control" id="perguntaEdt8" name="pergunta8">
              </div>
              <div class="mb-3">
                <label for="pergunta9" name="pergunta9" class="form-label">Pergunta 9</label>
                <input type="text" class="form-control" id="perguntaEdt9" name="pergunta9">
              </div>
              <div class="mb-3">
                <label for="pergunta10" name="pergunta10" class="form-label">Pergunta 10</label>
                <input type="text" class="form-control" id="perguntaEdt10" name="pergunta10">
              </div>


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-secondary">Salvar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  <!-- Modal Cadastrar Perguntas -->
  
    <!-- Modal Perguntas-->



    <!-- Modal Modifica ano -->


 <!-- Modal Cadastro-->
 <div class="modal fade" id="staticBackdrop8" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
          <form action="/funcoes/edita_ano.php" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Alterar ano vigênte de Avaliação</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">



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
                  


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-secondary">Salvar</button>
            </div>
          </div>
        </form>
      </div>
    </div>



    <!-- Modal Modifica ano -->






</body>



<footer class="position-absolute bottom-0 end-0 footer bg-dark text-center text-light  rounded-start-2">
    <div style="width: 100%">
            <img src="../img/IOT.png" class="card-img-top" width="55" height="90" alt="...">
          </div>
        <div class="container">
            <p>Tecnologia &copy; </p>
        </div>
    </footer>

</php>

<?php } else {
  header('Location: login.php');
} ?>