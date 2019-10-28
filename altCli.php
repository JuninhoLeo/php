<?php
include 'banco.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.html");
}
$id = trim($_GET['id']);

$pdo = Banco::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM cliente where id=?';
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);
$nome = $data['nome'];
$CPF  = $data['cpf'];
$RG   = $data['rg'];
$cid  = $data['cidade'];
$UF   = $data['uf'];
$Tel  = $data['telefone'];
$emai = $data['email'];
Banco::desconectar();

?>

<!DOCTYPE html>
<html>

<head>
    <title> </title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="./fontawesome-free-5.11.2-web/css/all.css">
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
    <!-- end header -->

    <!-- menu navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary" id="menu">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto col-sm-3 col-md-3">
                <li class="nav-item active">
                    <a class="nav-link" href="home.php"><i class="fas fa-home">Home</i><span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="listClientes.php"><i class="fas fa-users">Clientes</i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="listQuartos.php"><i class="fas fa-hotel">Disponíveis</i></a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <?php
                $pdo = Banco::conectar();
                $sql = 'SELECT nome 
                            FROM funcionarios 
                            inner join usuarios on(usuarios.usuario_id = funcionarios.usuario_id) 
                            where usuarios.usuario =?';
                $q = $pdo->prepare($sql);
                $q->execute(array($_SESSION['user']));
                $data = $q->fetch(PDO::FETCH_ASSOC);
                $user = $data['nome'];
                Banco::desconectar();

                echo "<h4>" . $user . "&nbsp;&nbsp;<h4>"
                ?>

                <button class="btn btn-secondary my-2 my-sm-0" type="button" data-toggle="modal" data-target="#loginModal" onclick="location.href='logout.php'">Logout</button>
            </form>
        </div>
    </nav>
    <!-- end navbar -->



    <!-- corpo da pagina -->
    <div class="container">
        <form id="login-form" class="form" action="updCli.php" method="POST">
            <br>
            <br>

            <!-- ID lançado oculto para metodo POST -->
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <!-- Nao apagar !!!! -->

            <div class="form-row">
                <div class="col-md-6">
                    <label for="username" class="text-info">Nome Completo*</label><br>
                    <input type="text" name="nome" id="nome" class="form-control" value="<?php echo $nome ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3">
                    <label for="username" class="text-info">RG* <br> ex:12.234.345-5</label><br>
                    <input type="text" name="rg" id="rg" class="form-control" value="<?php echo $RG ?>" required>
                </div>
                <div class="col-md-3">
                    <label for="username" class="text-info">CPF* <br> ex:123.234.345-56</label><br>
                    <input type="text" name="cpf" id="cpf" class="form-control" value="<?php echo $CPF ?>" required>
                </div>
                <div class="col-md-3">
                    <label for="username" class="text-info">Telefone* <br> ex:(11)98003-2001</label><br>
                    <input type="text" name="tel" id="tel" class="form-control" value="<?php echo $Tel ?>" required>
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
                <div class="col-md-6">
                    <label for="username" class="text-info">e-mail* <br> ex:fulanosilva@gmail.com</label><br>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $emai ?>" required>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div>
                    <input type="button" name="voltar" class="btn btn-outline-danger" value="Voltar" onclick="javascript:location.href='listClientes.php'">
                    <input type="reset" name="reset" class="btn btn-outline-warning" value="Limpar">
                    <input type="submit" name="alterar" class="btn btn-outline-success" value="Alterar">
                </div>
            </div>
        </form>
    </div>

</body>
<!-- Autor: José Leocadio de Barros Junior -->

</html>