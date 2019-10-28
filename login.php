<?php
$usr = trim($_POST['usr']);
$pwd = trim($_POST['pwd']);

$tnome = false;
$tsenha = false;

include 'banco.php';
$pdo = Banco::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM usuarios WHERE usuario=?";
$q = $pdo->prepare($sql);
$q->execute(array($usr));
$data = $q->fetch(PDO::FETCH_ASSOC);
Banco::desconectar();

if ($usr == $data['usuario'] && md5($pwd) == $data['senha']) {
   session_start();
   $_SESSION['user'] = $usr;
   $tnome = true;
   $tsenha = true;
   Header("Location: home.php");
}else{
   if ($usr == $data['usuario'] && md5($pwd) != $data['senha']) {
      $tnome = true;
      $tsenha = false;
   }else {
      $tnome = false;
      $tsenha = true;
   }
}

if($tnome == false or $tsenha == false) {
   ?>

   <!DOCTYPE html>
   <html lang="pt-br">

   <head>
      <meta charset="UTF-8">
      <title>--</title>
      <link rel="stylesheet" href="estilo.css">
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   </head>

   <body>
      <div id="login">
         <h3 class="text-center text-white pt-5">Login form</h3>
         <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
               <div id="login-column" class="col-md-6">
                  <div id="login-box" class="col-md-12">
                     <form id="login-form" class="form" action="login.php" method="post">
                        <h3 class="text-center text-info">Login</h3>
                        <div class="form-group">
                           <?php

                           if ($tnome == false) {
                              $mensagem = "<b>Erro</b>: Este Usuario Não está Cadastrado!";
                              echo "<label for='username' class='text-danger'>" . $mensagem;
                           }else{
                              echo "<label for='username' class='text-info'>Nome de Usuario:";
                           }

                           ?>
                           </label><br>
                           <input type="text" name="usr" id="usr" class="form-control" value="<?php echo $usr ?>" required>
                        </div>
                        <div class="form-group">
                           <?php

                           if ($tsenha == false && $tnome == true) {
                              $mensagem = "<span class='erro'><b>Erro</b>: Senha invalida!</span>";
                              echo "<label for='password' class='text-danger'>" . $mensagem;
                              $txtpwd = $pwd;
                              }else{
                                 echo "<label for='password' class='text-info'>Senha:";
                                 $txtpwd = '';
                              }

                           ?>
                           </label><br>
                           <input type="password" name="pwd" id="pwd" class="form-control" value="<?php echo $txtpwd ?>" required>
                        </div>

                        <div class="form-group">
                           <br>
                           <input type="submit" name="submit" class="btn btn-info btn-md" value="login">
                        </div>
                        <div id="register-link" class="text-right">
                           <h6>Novo por aqui? faça já seu cadastro</h6>
                           <br>
                           <a href="adfunc.php" class="text-info">Novo funcionario</a>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>


   </html>

<?php } ?>