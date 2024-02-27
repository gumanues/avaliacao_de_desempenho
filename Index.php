<?php require_once('conexao.php'); ?>
<link rel="icon" type="image/x-icon" href="img/pag.ico">
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

    <title>Formulário de Desempenho</title>
  </head>

  <style>
    .navbar {
      background: linear-gradient(to right, #13293D, #006494);
    }

    body {
      background: linear-gradient(to bottom, #E8F1F2, white);
    }

    .footer {
      background: linear-gradient(to left, #13293D, #13293D);
    }

    .button {
      background-color: #13293D;
      color: white;
      transition: background-color 3s;
    }

    .button:hover {
      background-color: #006494;
    }
  </style>

  <body>
    <div>
      <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php">Avaliação de Desempenho</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" href="pages/login.php" type="button">Login</a>
              </li>

            </ul>
          </div>
        </div>
      </nav>
    </div>
    <div>
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

    <div class="pt-5">
      <label class="fw-bold fs-3 d-flex justify-content-center py-3">Avaliação Colaboradores</label>
    </div>


    <div class="col d-flex justify-content-center mt-5">
      <a class="btn" style="text-decoration: none; color: inherit;" href="pages/colaboradores.php">
        <div class="card" style="width: 18rem;">
          <img src="img/Colab2.jpg" class="card-img-top" width="250" height="250" alt="...">
          <div class="card-body">
            <h5 class="card-title">Iniciar Avaliação Colaboradores</h5>
            <p class="text-body-secondary">Colaborador se auto-avalia</p>
          </div>
        </div>
      </a>
    </div>

  </body>

  <footer class="position-absolute bottom-0 end-0 footer bg-dark text-center text-light  rounded-start-2">
    <div style="width: 100%">
      <img src="../img/IOT.png" class="card-img-top" width="55" height="90" alt="...">
    </div>
    <div class="container">
      <p>Instituto de Ortopedia e Traumatologia &copy; </p>
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