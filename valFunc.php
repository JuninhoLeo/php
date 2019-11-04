<?php

$nome = trim($_POST['nome']);
$usr = trim($_POST['usr']);
$end = trim($_POST['end']);
$cid = trim($_POST['cidade']);
$UF = trim($_POST['uf']);
$rg = trim($_POST['rg']);
$cpf = trim($_POST['cpf']);
$tel = trim($_POST['tel']);
$emai = trim($_POST['email']);
$senha = trim($_POST['senha']);
$conf = trim($_POST['conf']);

$tnome = false;
$tusr = false;
$trg = false;
$tcpf = false;
$temail = false;

include 'banco.php';
$pdo = Banco::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT funcionarios.nome as func, funcionarios.rg, funcionarios.cpf, 
               funcionarios.email, usuarios.usuario as usr
        from funcionarios
        inner join usuarios on(funcionarios.usuario_id = usuarios.usuario_id)
        ORDER by nome;';

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

    $sql1 = 'INSERT into usuarios (usuario, senha) values (?,?)';
    $qry = $pdo->prepare($sql1);
    $qry->execute(array($usr, md5($senha)));

    $sql2 = 'SELECT usuario_id FROM usuarios where usuario =?';
    $q = $pdo->prepare($sql2);
    $q->execute(array($usr));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $id = $data['usuario_id'];

    $sql1 = 'INSERT into funcionarios (nome, usuario_id, endereco, rg, cpf, telefone, email) 
             values (?,?,?,?,?,?,?)';
    $qery = $pdo->prepare($sql1);
    $qery->execute(array($nome, $id, $end, $rg, $cpf, $tel, $emai));

    session_start();
    $_SESSION['user'] = $usr;
    Banco::desconectar();

    header('location: home.php');
} else {
    ?>



    <!DOCTYPE html>
    <html>

    <head>
        <title> </title>
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
        <!-- meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    </head>

    <style>
        .header {
            background-color: black;
            font-family: 'Modak', cursive;
            color: paleturquoise;
            padding: 2%;
            text-align: center;
        }

        .card {
            width: 190px;
            height: auto;
            margin-left: 2px;
            margin-right: 1px;
        }

        h4 {
            font-size: 25px;
            font-family: ;
        }

        div#alert {
            float: right;
        }

        div#rodape {
            height: 50px;
            background-color: black;
            margin-top: 60px;
            margin-right: 0px;
            margin-left: 0px;
            width: 100%;
        }

        h4#notas {
            color: #9C9C9C;
            font-size: 10px;
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
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-10">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" action="valFunc.php" method="POST">
                        <br>
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <label for="username" class="text-info">Nome Completo*</label><br>
                                <input type="text" name="nome" id="nome" class="form-control" value="<?php echo $nome; ?>" required>
                                <?php
                                    if ($tnome == true) {
                                        $mensagem = '<b>Erro</b>: Usuario ja cadastrado!';
                                        echo "<div class='alert alert-danger' role='alert'>
                                            " . $mensagem . '</div>';
                                    } ?>
                            </div>

                            <div class="col">
                                <label for="username" class="text-info">Nome de Usuario* </label><br>
                                <input type="text" name="usr" id="usr" class="form-control" value="<?php echo $usr; ?>" required>

                                <?php
                                    if ($tusr == true) {
                                        $mensagem = '<b>Erro</b>: Este nome de usuário ja está sendo utilizado!';
                                        echo "<div class='alert alert-danger' role='alert'>
                                               " . $mensagem . '</div>';
                                    } ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-7">
                                <label for="username" class="text-info">Endereço* <br> ex:Av.logoali 123</label><br>
                                <input type="text" name="end" id="end" class="form-control" value="<?php echo $end; ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-2">
                                <label for="username" class="text-info">Cidade*</label><br>
                                <input type="text" name="cidade" id="cidade" class="form-control" value="<?php echo $cid; ?>" required>
                            </div>
                            <div class="col-md-2">
                                <label for="username" class="text-info">UF</label><br>
                                <input type="text" name="uf" id="uf" class="form-control" value="<?php echo $UF; ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col">
                                <label for="username" class="text-info">RG* <br> ex:12.234.345-5</label><br>
                                <input type="text" name="rg" id="rg" class="form-control" value="<?php echo $rg; ?>" required>

                                <?php
                                    if ($trg == true) {
                                        $mensagem = '<b>Erro</b>: RG inválido ou ja cadastrado!';
                                        echo "<div class='alert alert-danger' role='alert'>
                                               " . $mensagem . '</div>';
                                    } ?>
                            </div>

                            <div class="col">
                                <label for="username" class="text-info">CPF* <br> ex:123.234.345-56</label><br>
                                <input type="text" name="cpf" id="cpf" class="form-control" value="<?php echo $cpf; ?>" required>

                                <?php
                                    if ($tcpf == true) {
                                        $mensagem = '<b>Erro</b>: CPF inválido ou ja cadastrado!';
                                        echo "<div class='alert alert-danger' role='alert'>
                                               " . $mensagem . '</div>';
                                    } ?>
                            </div>

                            <div class="col">
                                <label for="username" class="text-info">Telefone* <br> ex:(11)98003-2001</label><br>
                                <input type="text" name="tel" id="tel" class="form-control" value="<?php echo $tel; ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-7">
                                <label for="username" class="text-info">e-mail* <br> ex:fulanosilva@gmail.com</label><br>
                                <input type="email" name="email" id="email" class="form-control" value="<?php echo $emai; ?>" required>

                                <?php
                                    if ($temail == true) {
                                        $mensagem = '<b>Erro:</b> e-mail já Cadastrado!!';
                                        echo "<div class='alert alert-danger' role='alert'>
                                               " . $mensagem . '</div>';
                                    } ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col">
                                <label for="username" class="text-info">Senha</label><br>
                                <input type="password" name="senha" id="senha" class="form-control" value="<?php echo $senha; ?>" required>
                            <?php
                                if ($conf != $senha) {
                                    $mensagem = '<b>Erro</b>: As senhas não conferem!';
                                    echo "<div class='alert alert-danger' role='alert'>
                                               " . $mensagem . '</div>';
                                }
                                //fechamento do else
                            }
                            ?>
                            </div>
                            <div class="col">
                                <label for="username" class="text-info">Confirmar senha</label><br>
                                <input type="password" name="conf" id="conf" class="form-control" value="<?php echo $conf; ?>" required>

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

        <div id="rodape">
            <!-- 
        Aqui fica as notas de rodapé 
        Só não usei o <footer> porque
        o bootsnipp esta bloqueando o 
        css 
    -->
            <br>
            <h4 id="notas"> &copy; COPYRIGHT 2019 José Leocadio. Todos os direitos reservados</h4>
        </div>

    </body>
    <!-- Autor: José Leocadio de Barros Junior -->

    </html>