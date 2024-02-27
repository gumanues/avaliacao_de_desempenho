<?php 
session_start();

unset($_SESSION['usureferencia']);
unset($_SESSION['login']);
unset($_SESSION['id']);
unset($_SESSION['setorid']);
?>

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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" onclick="goBack()" href="sair.php">Voltar</a>
            </li>
          </ul>
        </div>
             
      </div>
    </nav>
  </div>
<body>
    <h1 class="text-center pt-5">Erro no SQL. Por favor, contate a area responsável!</h1>

    <script>
        // Função JavaScript para voltar para a página anterior
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
