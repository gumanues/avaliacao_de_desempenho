<?php require_once('../conexao.php'); 

session_start();
unset($_SESSION['usureferencia']);


if (isset($_SESSION['login']) && $_SESSION['login'] == 1) {

$id_login = $_SESSION['id'];
$usu_login_sql = "SELECT * FROM usuario where idusuario = $id_login";
$usu_login_query = mysqli_query($conexao, $usu_login_sql);

while ($usu_login_fetch = mysqli_fetch_assoc($usu_login_query)) {

$usu_login = $usu_login_fetch['nomecompleto'];

}

$delega_sql = "SELECT * FROM delega_acoes";
$delega_query = mysqli_query($conexao, $delega_sql);

while ($delega_acoes = mysqli_fetch_assoc($delega_query)) {

    $delega_tipo = $delega_acoes['acess_av_reter'];
    $delega_tipo_array = explode(",", $delega_tipo);
    $delega_tipo1 = $delega_acoes['gerente'];
    $delega_tipo_array2 = explode(",", $delega_tipo1);
  
}
?>


<!DOCTYPE php>
<php lang="pt-br">

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
          <a class="navbar-brand" href="#">Avaliação de Desempenho</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
      <?php if (!in_array($id_login, $delega_tipo_array2)) { ?>
          <li class='nav-item'>
                <a class='nav-link' href='avaliacoes_usuarios_coordenadores.php?id_tipo=6&idusuario=null&id_data=2023'>Avaliações</a>
            </li>
      <?php } ?>

              <li class="nav-item">
              <a class="nav-link" href="sair.php" >Sair</a>
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
    <label class="fw-bold fs-3 d-flex justify-content-center py-5">Apenas Coordenadores</label>
  </div>


<div class="container text-center py-4 d-flex justify-content-center">
          <div class="row">
          <div class="col ms-5">
            <a class="" style="text-decoration: none; color: inherit;" href="lider-colaboradores.php">
            <div class="card" style="width: 18rem;">
            <img src="../img/Lider.png" class="card-img-top" width="250" height="250" alt="...">
            <div class="card-body">
                <h5 class="card-title">Iniciar Avaliação Líder Colaboradores</h5>
                <p class="text-body-secondary">Coordenação Avalia os Colaboradores</p>
            
            </div>
          </div>
          </a>
        </div>

<?php



if (!in_array($id_login, $delega_tipo_array)) { // apenas Henrique parametrizado pelo ID do banco de dados
?>
        <div class="col ms-5">
            <a class="" style="text-decoration: none; color: inherit;" href="coordenadores.php">
              <div class="card" style="width: 18rem;">
                <img src="../img/Colab.png" class="card-img-top" width="250" height="250" alt="...">
                <div class="card-body">
                <h5 class="card-title">Iniciar avaliação Coordenadores</h5>
                <p class="text-body-secondary"><br>Coordenador se auto-avalia</p>
            </div>
          </div>
          </a>
        </div>


        
      </div>
    </div>

<?php } ?>
  

    <!-- Modal Sobre-->
    <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Sobre</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <img class="card-img-top" src="../img/avaliacao.png" width="600" height="200" alt="">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>
</div>





  </body>
  <footer class="position-absolute bottom-0 end-0 footer bg-dark text-center text-light  rounded-start-2">
    <div style="width: 100%">
            <img src="../img/IOT.png" class="card-img-top" width="55" height="90" alt="...">
          </div>
        <div class="container">
            <p>Tecnologia &copy; </p>
        </div>
    </footer>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
      integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
      crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
      integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
      crossorigin="anonymous"></script>
</php>


<?php } else {
  header('Location: login.php');
} ?>