<?php

$nome  = trim($_POST['nome']);
$usr   = trim($_POST['usr']);
$end   = trim($_POST['end']);
$cid    = trim($_POST['cidade']);
$UF   = trim($_POST['uf']);
$rg    = trim($_POST['rg']);
$cpf   = trim($_POST['cpf']);
$tel   = trim($_POST['tel']);
$emai  = trim($_POST['email']);
$senha = trim($_POST['senha']);
$conf  = trim($_POST['conf']);

$tnome  = false;
$tusr   = false;
$trg    = false;
$tcpf   = false;
$temail = false;

include 'banco.php';
$pdo = Banco::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT funcionarios.nome as func, funcionarios.rg, funcionarios.cpf, 
               funcionarios.email, usuarios.usuario as usr
        from funcionarios
        inner join usuarios on(funcionarios.usuario_id = usuarios.usuario_id)
        ORDER by nome;";

foreach ($pdo->query($sql) as $row) {

    if ($nome == $row['func']) {
        $tnome = true;
    }

    if ($usr == $row['usr']) {
        $tusr = true;
    }

    if ($rg == $row['rg']) {
        $trg = true;
    }

    if ($cpf == $row['cpf']) {
        $tcpf = true;
    }

    if ($emai == $row['email']) {
        $temail = true;
    }
}

Banco::desconectar();

if ($tnome == false && $trg == false && $tcpf == false && $conf == $senha && $temail == false && $tusr == false) {

    //Somente fará os insert se estiver tudo ok 
    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql1 = "INSERT into usuarios (usuario, senha) values (?,?)";
    $qry = $pdo->prepare($sql1);
    $qry->execute(array($usr, md5($senha)));

    $sql2 = "SELECT usuario_id FROM usuarios where usuario =?";
    $q = $pdo->prepare($sql2);
    $q->execute(array($usr));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $id = $data['usuario_id'];

    $sql1 = "INSERT into funcionarios (nome, usuario_id, endereco, rg, cpf, telefone, email) 
             values (?,?,?,?,?,?,?)";
    $qery = $pdo->prepare($sql1);
    $qery->execute(array($nome, $id, $end, $rg, $cpf, $tel, $emai));

    session_start();
    $_SESSION['user'] = $usr;
    Banco::desconectar();

    header("location: home.php");
} else {


    ?>



    <!DOCTYPE html>
    <html>

    <head>
        <title> </title>
        <link rel="stylesheet" href="estilo.css">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="//cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/css/foundation.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/js/foundation.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <!-- meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    </head>

    <body>
        <!-- header -->
        <div class="container-fluid header">
            <header>
                Hotel Pet
            </header>
        </div>
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-10">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" action="valFunc.php" method="POST">
                        <br>
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <label for="username" class="text-info">Nome Completo*</label><br>
                                <input type="text" name="nome" id="nome" class="form-control" value="<?php echo $nome ?>" required>
                                <?php
                                    if ($tnome == true) {
                                        $mensagem = "<h6 style='color: #db0707'><b>Erro</b>: Usuario ja cadastrado!</h6>";
                                        echo $mensagem;
                                    }
                                    ?>
                            </div>

                            <div class="col">
                                <label for="username" class="text-info">Nome de Usuario* </label><br>
                                <input type="text" name="usr" id="usr" class="form-control" value="<?php echo $usr ?>" required>

                                <?php
                                    if ($tusr == true) {
                                        $mensagem = "<h6 style='color: #db0707'><b>Erro</b>: Este nome de usuário ja está sendo utilizado!</h6>";
                                        echo $mensagem;
                                    }
                                    ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-7">
                                <label for="username" class="text-info">Endereço* <br> ex:Av.logoali 123</label><br>
                                <input type="text" name="end" id="end" class="form-control" value="<?php echo $end ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-2">
                                <label for="username" class="text-info">Cidade*</label><br>
                                <input type="text" name="cidade" id="cidade" class="form-control" value="<?php echo $cid ?>" required>
                            </div>
                            <div class="col-md-2">
                                <label for="username" class="text-info">UF</label><br>
                                <input type="text" name="uf" id="uf" class="form-control" value="<?php echo $UF ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col">
                                <label for="username" class="text-info">RG* <br> ex:12.234.345-5</label><br>
                                <input type="text" name="rg" id="rg" class="form-control" value="<?php echo $rg ?>" required>

                                <?php
                                    if ($trg == true) {
                                        $mensagem = "<h6 style='color: #db0707'><b>Erro</b>: RG inválido ou ja cadastrado!</h6>";
                                        echo $mensagem;
                                    }
                                    ?>
                            </div>

                            <div class="col">
                                <label for="username" class="text-info">CPF* <br> ex:123.234.345-56</label><br>
                                <input type="text" name="cpf" id="cpf" class="form-control" value="<?php echo $cpf ?>" required>

                                <?php
                                    if ($tcpf == true) {
                                        $mensagem = "<h6 style='color: #db0707'><b>Erro</b>: CPF inválido ou ja cadastrado!</h6>";
                                        echo $mensagem;
                                    }
                                    ?>
                            </div>

                            <div class="col">
                                <label for="username" class="text-info">Telefone* <br> ex:(11)98003-2001</label><br>
                                <input type="text" name="tel" id="tel" class="form-control" value="<?php echo $tel ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-7">
                                <label for="username" class="text-info">e-mail* <br> ex:fulanosilva@gmail.com</label><br>
                                <input type="email" name="email" id="email" class="form-control" value="<?php echo $emai ?>" required>

                                <?php
                                    if ($temail == true) {
                                        $mensagem = "<h6 style='color: #db0707'><b>Erro:</b> e-mail já Cadastrado!!</h6>";
                                        echo $mensagem;
                                    }
                                    ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col">
                                <label for="username" class="text-info">Senha</label><br>
                                <input type="password" name="senha" id="senha" class="form-control" value="<?php echo $senha ?>" required>
                            <?php
                                if ($conf != $senha) {
                                    $mensagem = "<h6 style='color: #db0707'><b>Erro</b>: As senhas não conferem!</h6>";
                                    echo $mensagem;
                                }
                                //fechamento do else
                            }
                            ?>
                            </div>
                            <div class="col">
                                <label for="username" class="text-info">Confirmar senha</label><br>
                                <input type="password" name="conf" id="conf" class="form-control" value="<?php echo $conf ?>" required>

                            </div>
                        </div>
                        <div class="form-group">
                            <br>
                            <input type="button" name="voltar" class="btn btn-outline-danger" value="Voltar" onclick="javascript:location.href='index.html'">
                            <input type="button" name="reset" class="btn btn-outline-warning" value="Limpar" onclick="javascript:location.href='adfunc.php'">
                            <input type="submit" name="submit" class="btn btn-outline-success" value="Confirmar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <!-- Autor: José Leocadio de Barros Junior -->

    </html>