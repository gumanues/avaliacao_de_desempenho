<?php require_once('../conexao.php'); ?>


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
        <a class="navbar-brand" href="../index.php">Início</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
          </ul>
        </div>
      </div>
    </nav>
  </div>

  <!-- Erro Login -->

  <div id="alertas">
      <?php if(isset($_GET['retorno'])==true && $_GET['retorno']=='erro'){ ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span>Erro de autenticação, Senha ou Tipo de Acesso incorreto!</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
  <?php } ?>

  <!-- Erro Login -->

  <div class="col d-flex justify-content-center mt-5">
    <div class="card p-5" style="width: 18rem;">
      <form action="../funcoes/acesso_login.php" method="post">

        <legend>Login</legend>
        <div class="mb-3">
          <div class="mb-3">
            <label for="idusuario" class="form-label pt-3">Usuário de Login:</label>
            <select class="form-select" name="idusuario" id="idusuario" required>
              <option value=''>Selecione</option>
              <?php  

                    $editar_usuarios = "SELECT * FROM usuario where situacao = 1 and lider <> 0";
                    $id_servico = mysqli_query($conexao, $editar_usuarios);
                    
                    while ($id_ser = mysqli_fetch_assoc($id_servico)) {


                      $delega_sql = "SELECT * FROM delega_acoes";
                      $delega_query = mysqli_query($conexao, $delega_sql);
  
                      while ($delega_acoes = mysqli_fetch_assoc($delega_query)) {
  
                      $delega_tipo = $delega_acoes['login_principal'];
                      $delega_tipo_array = explode(",", $delega_tipo);
  
                      }
                     

                    if (!in_array($id_ser['idusuario'], $delega_tipo_array)) {

                    $idusuario = $id_ser['idusuario'];
                    $nomecomp = $id_ser['nomecompleto'];
                    $lider = $id_ser['lider'];

                    echo "<option value='idusuario:$idusuario, lider:$lider'>$nomecomp</option>";
                    }
                  }
                    
                  
                    ?>
            </select>
          </div>
        </div>
        <div class="mb-3">

          <label for="senha" class="form-label">Senha</label>
          <input type="password" id="senha" name="senha" class="form-control" required>
        </div>
        <div class="form-check mt-3">
        <div class="mb-3 mt-2">
          <label for="checklider" class="form-label">Tipo de acesso</label>
          <div class="form-check">
              <input type="checkbox" name="checklider" id="checklider" value="2">
              <label class="form-check-label" for="checklider">
                  Gerência
              </label>
          </div>
        </div>
        </div>

        <button type="submit" class="btn btn-secondary mt-3">Acessar</button>

      </form>


    </div>
  </div>







  <script>
    function goBack() {
      window.history.back()
    }
  </script>
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

<footer class="position-absolute bottom-0 end-0 footer bg-dark text-center text-light  rounded-start-2">
    <div style="width: 100%">
            <img src="../img/IOT.png" class="card-img-top" width="55" height="90" alt="...">
          </div>
        <div class="container">
            <p>Tecnologia  &copy; </p>
        </div>
    </footer>

</html>