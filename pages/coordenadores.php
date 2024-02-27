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
  <title>Formulário de Desempenho</title>
  <link rel="stylesheet" type="text/css" href="../css/style_perguntas.css"> 
  <link rel="icon" type="image/x-icon" href="../img/pag.ico">
</head>

<body>

<div>
  

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
                <a class="nav-link " type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"
                  href="#">Notas</a>
              </li>
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
  </div>

  <!-- Erros -->

<div id="alertas">
      <?php if(isset($_GET['retorno'])==true && $_GET['retorno']==1){ ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span>Houve um problema no envio do formulário!</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>

<!-- Envios -->

      <?php } if(isset($_GET['retorno'])==true && $_GET['retorno']==1.1){ ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span>Formulário enviado com Sucesso!</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php } ?>
</div>


  <div>
    <label class="fw-bold fs-3 d-flex justify-content-center py-3">Competências Avaliativas Coordenadores</label>
    <p class="text-body-secondary d-flex justify-content-center py-1">Coordenador se auto-avalia</p>
  </div>

  <div class="container py-2">
    <form action="/funcoes/envio_coord.php" method="post">
    <div>
    </div>
      <div class="mb-3">
        <label for="idusuario" class="form-label pt-3">Coordenador:</label>
        <select class="form-select" name="idusuario" id="idusuario">
          <?php  
        
          $editar_usuarios = "
          SELECT 
          * 
          FROM usuario e 
          where situacao = 1 

          AND NOT EXISTS (
            SELECT 1 
            FROM coord a 
            WHERE e.idusuario = a.idusuarios and data = $ano_vigente
          )

          and e.idusuario = $id_login
          
          ";
          $id_servico = mysqli_query($conexao, $editar_usuarios);
          
          while ($id_ser = mysqli_fetch_assoc($id_servico)) {

          $idusuario = $id_ser['idusuario'];
          $nomecompleto = $id_ser['nomecompleto'];
          $setorid = $id_ser['setorid'];


          echo "<option value='idusuario:$idusuario, setorid:$setorid'>$nomecompleto</option>";
        
          }?>
        </select>

</div>

      <?php



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
WHERE a.id = b.coord
LIMIT 1
";
    
$col_query = mysqli_query($conexao, $sql_col);
while ($fetch_col = mysqli_fetch_assoc($col_query)) {

$quantidade = $fetch_col['qt_col']; 

}









$sql_perguntas = "SELECT * FROM pergunta a, modifica_pergunta b where a.id = b.coord";
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

echo"<hr>
      <div>
        <div class='row text-start py-3'>
          <div class='pb-3'>
            <label class='fw-bold fs-3'>$pergunta1</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota1' value='1' type='radio' class='btn-check' id='nota1'
              autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota1'>1</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota1' value='2' type='radio' class='btn-check' id='nota2'
              autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota2'>2</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota1' value='3' type='radio' class='btn-check' id='nota3'
              autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota3'>3</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota1' value='4' type='radio' class='btn-check' id='nota4'
              autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota4'>4</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota1' value='5' type='radio' class='btn-check' id='nota5'
              autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota5'>5</label>
          </div>
        </div>
      </div>
      <hr>
      <div>
        <div class='row text-start py-3'>
          <div class='pb-3'>
            <label class='fw-bold fs-3'>$pergunta2</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota2' value='1' type='radio' class='btn-check' id='nota6'
              autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota6'>1</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota2' value='2' type='radio' class='btn-check' id='nota7'
              autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota7'>2</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota2' value='3' type='radio' class='btn-check' id='nota8'
              autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota8'>3</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota2' value='4' type='radio' class='btn-check' id='nota9'
              autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota9'>4</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota2' value='5' type='radio' class='btn-check'
              id='nota10' autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota10'>5</label>
          </div>
        </div>
      </div>
      <hr>
      <div>
        <div class='row text-start py-3'>
          <div class='pb-3'>
            <label class='fw-bold fs-3'>$pergunta3</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota3' value='1' type='radio' class='btn-check'
              id='nota11' autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota11'>1</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota3' value='2' type='radio' class='btn-check'
              id='nota12' autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota12'>2</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota3' value='3' type='radio' class='btn-check'
              id='nota13' autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota13'>3</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota3' value='4' type='radio' class='btn-check'
              id='nota14' autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota14'>4</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota3' value='5' type='radio' class='btn-check'
              id='nota15' autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota15'>5</label>
          </div>
        </div>
      </div>
      <hr>
      <div>
        <div class='row text-start py-3'>
          <div class='pb-3'>
            <label class='fw-bold fs-3'>$pergunta4</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota4' value='1' type='radio' class='btn-check'
              id='nota16' autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota16'>1</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota4' value='2' type='radio' class='btn-check'
              id='nota17' autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota17'>2</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota4' value='3' type='radio' class='btn-check'
              id='nota18' autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota18'>3</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota4' value='4' type='radio' class='btn-check'
              id='nota19' autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota19'>4</label>
          </div>
          <div class='col d-grid gap-2'>
            <input name='nota4' value='5' type='radio' class='btn-check'
              id='nota20' autocomplete='off' required>
            <label class='btn btn-outline-secondary btn-lg' for='nota20'>5</label>
          </div>
        </div>
      </div>
      <hr>";

      if($quantidade >= 5 && $quantidade <= 10) {
        echo "<div>
             <div class='row text-start py-3'>
               <div class='pb-3'>
                 <label class='fw-bold fs-3'>$pergunta5</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota5' value='1' type='radio' class='btn-check'
                   id='nota21' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota21'>1</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota5' value='2' type='radio' class='btn-check'
                   id='nota22' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota22'>2</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota5' value='3' type='radio' class='btn-check'
                   id='nota23' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota23'>3</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota5' value='4' type='radio' class='btn-check'
                   id='nota24' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota24'>4</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota5' value='5' type='radio' class='btn-check'
                   id='nota25' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota25'>5</label>
               </div>
             </div>
           </div>
           <hr>";
     
     }
     if($quantidade >= 6 && $quantidade <= 10) {
       echo "<div>
             <div class='row text-start py-3'>
               <div class='pb-3'>
                 <label class='fw-bold fs-3'>$pergunta6</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota6' value='1' type='radio' class='btn-check'
                   id='nota26' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota26'>1</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota6' value='2' type='radio' class='btn-check'
                   id='nota27' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota27'>2</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota6' value='3' type='radio' class='btn-check'
                   id='nota28' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota28'>3</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota6' value='4' type='radio' class='btn-check'
                   id='nota29' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota29'>4</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota6' value='5' type='radio' class='btn-check'
                   id='nota30' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota30'>5</label>
               </div>
             </div>
           </div>
           <hr>";
     
     
     }
     if($quantidade >= 7 && $quantidade <= 10) {
       echo "<div>
             <div class='row text-start py-3'>
               <div class='pb-3'>
                 <label class='fw-bold fs-3'>$pergunta7</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota7' value='1' type='radio' class='btn-check'
                   id='nota31' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota31'>1</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota7' value='2' type='radio' class='btn-check'
                   id='nota32' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota32'>2</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota7' value='3' type='radio' class='btn-check'
                   id='nota33' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota33'>3</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota7' value='4' type='radio' class='btn-check'
                   id='nota34' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota34'>4</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota7' value='5' type='radio' class='btn-check'
                   id='nota35' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota35'>5</label>
               </div>
             </div>
           </div>
           <hr>";
     
     
     }
     if($quantidade >= 8 && $quantidade <= 10) {
       echo "<div>
             <div class='row text-start py-3'>
               <div class='pb-3'>
                 <label class='fw-bold fs-3'>$pergunta8</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota8' value='1' type='radio' class='btn-check'
                   id='nota36' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota36'>1</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota8' value='2' type='radio' class='btn-check'
                   id='nota37' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota37'>2</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota8' value='3' type='radio' class='btn-check'
                   id='nota38' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota38'>3</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota8' value='4' type='radio' class='btn-check'
                   id='nota39' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota39'>4</label>
               </div>
               <div class='col d-grid gap-2'>
                 <input name='nota8' value='5' type='radio' class='btn-check'
                   id='nota40' autocomplete='off' required>
                 <label class='btn btn-outline-secondary btn-lg' for='nota40'>5</label>
               </div>
             </div>
           </div>
           <hr>";
     
     }      
     if($quantidade >= 9 && $quantidade <= 10) {
         echo "<div>
               <div class='row text-start py-3'>
                 <div class='pb-3'>
                   <label class='fw-bold fs-3'>$pergunta9</label>
                 </div>
                 <div class='col d-grid gap-2'>
                   <input name='nota9' value='1' type='radio' class='btn-check'
                     id='41' autocomplete='off' required>
                   <label class='btn btn-outline-secondary btn-lg' for='41'>1</label>
                 </div>
                 <div class='col d-grid gap-2'>
                   <input name='nota9' value='2' type='radio' class='btn-check'
                     id='nota42' autocomplete='off' required>
                   <label class='btn btn-outline-secondary btn-lg' for='nota42'>2</label>
                 </div>
                 <div class='col d-grid gap-2'>
                   <input name='nota9' value='3' type='radio' class='btn-check'
                     id='nota43' autocomplete='off' required>
                   <label class='btn btn-outline-secondary btn-lg' for='nota43'>3</label>
                 </div>
                 <div class='col d-grid gap-2'>
                   <input name='nota9' value='4' type='radio' class='btn-check'
                     id='nota44' autocomplete='off' required>
                   <label class='btn btn-outline-secondary btn-lg' for='nota44'>4</label>
                 </div>
                 <div class='col d-grid gap-2'>
                   <input name='nota9' value='5' type='radio' class='btn-check'
                     id='nota45' autocomplete='off' required>
                   <label class='btn btn-outline-secondary btn-lg' for='nota45'>5</label>
                 </div>
               </div>
             </div>
             <hr>";
     }
     if($quantidade >= 10 && $quantidade <= 10) {
             
       echo  "<div>
               <div class='row text-start py-3'>
                 <div class='pb-3'>
                   <label class='fw-bold fs-3'>$pergunta10</label>
                 </div>
                 <div class='col d-grid gap-2'>
                   <input name='nota10' value='1' type='radio' class='btn-check'
                     id='nota46' autocomplete='off' required>
                   <label class='btn btn-outline-secondary btn-lg' for='nota46'>1</label>
                 </div>
                 <div class='col d-grid gap-2'>
                   <input name='nota10' value='2' type='radio' class='btn-check'
                     id='nota47' autocomplete='off' required>
                   <label class='btn btn-outline-secondary btn-lg' for='nota47'>2</label>
                 </div>
                 <div class='col d-grid gap-2'>
                   <input name='nota10' value='3' type='radio' class='btn-check'
                     id='nota48' autocomplete='off' required>
                   <label class='btn btn-outline-secondary btn-lg' for='nota48'>3</label>
                 </div>
                 <div class='col d-grid gap-2'>
                   <input name='nota10' value='4' type='radio' class='btn-check'
                     id='nota49' autocomplete='off' required>
                   <label class='btn btn-outline-secondary btn-lg' for='nota49'>4</label>
                 </div>
                 <div class='col d-grid gap-2'>
                   <input name='nota10' value='5' type='radio' class='btn-check'
                     id='nota50' autocomplete='off' required>
                   <label class='btn btn-outline-secondary btn-lg' for='nota50'>5</label>
                 </div>
               </div>
             </div>";
     }
     }
     ?>
      <div class="d-grid gap-2">
        <button class="btn btn-secondary" type="submit">Enviar</button>
      </div>
      <hr class="py-3">
    </form>
  </div>


     <!-- Modal Notas-->
     <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Peso das Notas</h1>
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

</html>


<?php } else {
  header('Location: login.php');
} ?>