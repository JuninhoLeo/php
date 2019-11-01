<?php
$usr = trim($_POST['usr']);
$pwd = trim($_POST['pwd']);

$tnome = false;
$tsenha = false;

include 'banco.php';
$pdo = Banco::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM usuarios WHERE usuario=?';
$q = $pdo->prepare($sql);
$q->execute(array($usr));
$data = $q->fetch(PDO::FETCH_ASSOC);
Banco::desconectar();

if ($usr == $data['usuario'] && md5($pwd) == $data['senha']) {
   session_start();
   $_SESSION['user'] = $usr;
   $tnome = true;
   $tsenha = true;
   header('Location: home.php');
} else {
   if ($usr == $data['usuario'] && md5($pwd) != $data['senha']) {
      $tnome = true;
      $tsenha = false;
   } else {
      $tnome = false;
      $tsenha = true;
   }
}

if ($tnome == false or $tsenha == false) {
   ?>

   <!DOCTYPE html>
   <html lang="pt-br">

   <head>
      <meta charset="UTF-8">
      <title>--</title>
      <link rel="stylesheet" href="home.css ">
      <link rel="stylesheet" href="estilo.css">
      <link rel="stylesheet" href="./fontawesome-free-5.11.2-web/css/all.css">
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <link href="//cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/css/foundation.min.css" rel="stylesheet" id="bootstrap-css">
      <script src="//cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/js/foundation.min.js"></script>
      <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
      <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
   </head>

   <style>
      @import url('https://fonts.googleapis.com/css?family=Staatliches&display=swap');

      body {
         margin: 0;
         padding: 0;
         background-image: url(apresentation.jpg);
         background-repeat: no-repeat;
         background-position: top center;
         height: 100vh;
      }

      label {
         font-size: 15px;
         font-family: 'Staatliches', cursive;
      }

      #login .container #login-row #login-column #login-box {
         max-width: 600px;
         height: auto;
         border: 1px solid #9C9C9C;
         background-color: #EAEAEA;
      }

      #login .container #login-row #login-column #login-box #login-form {
         padding: 20px;
      }

      #login .container #login-row #login-column #login-box #login-form #register-link {
         margin-top: -85px;
      }

      div#register{
         text-align: center;
      }

   </style>

   <body>

      <!-- header -->
      <div class="container-fluid header">
         <header>
            Sistema Hoteleiro
         </header>
      </div>
      <!-- end header -->

      <div id="login">
         <h3 class="text-center text-white pt-5">Login form</h3>
         <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
               <div id="login-column" class="col-md-12">
                  <div id="login-box" class="col-md-12">
                     <form id="login-form" class="form" action="login.php" method="post">
                        <h3 class="text-center text-info">Login</h3>
                        <div class="form-group col-md-12">
                           <?php

                              if ($tnome == false) {
                                 echo "<div class='alert alert-danger' role='alert'>
                              <b>Erro</b>: Usuario e/ou senha invalida!</div>";
                              } elseif ($tsenha == false && $tnome == true) {
                                 echo "<div class='alert alert-danger' role='alert'>
                                       <b>Erro</b>: Usuario e/ou senha invalida!</div>";
                              } else {
                                 echo "<label for='username' class='text-info'>Nome de Usuario:";
                              }
                              ?></label>
                           <input type="text" name="usr" id="usr" class="form-control" value="<?php echo $usr; ?>" required>
                        </div>
                        <div class="form-group col-md-12">
                           <label for='password' class='text-info'>Senha:</label>
                           <input type="password" name="pwd" id="pwd" class="form-control" value="<?php echo $pwd; ?>" required>
                           <br>
                           <input type="submit" name="submit" class="btn btn-info btn-lg btn-block" value="Login">
                        </div>
                        <div id="register" class="col-md-12">
                           <h6>Novo por aqui? faça já seu cadastro</h6>
                           <a href="adfunc.php" class="text-info"><b>Novo funcionario</b></a>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>


   </html>

<?php
} ?>