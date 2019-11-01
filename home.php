<?php
include 'banco.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('location: index.html');
}
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
        </div>
        </div>
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
    </nav>
    <!-- end navbar -->
    <style>
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
    </style>
    <!-- corpo da pagina -->
    <br><br>
    <div class="container">
        <div class="card">
            <div class="face face1" align="center">
                <?php
                $nome = 'nome';
                $pdo = Banco::conectar();
                $sql = 'SELECT COUNT(?) as cont FROM cliente';
                $q = $pdo->prepare($sql);
                $q->execute(array($nome));
                $data = $q->fetch(PDO::FETCH_ASSOC);
                $user = $data['cont'];
                Banco::desconectar();
                echo '<h4><b>Clientes:</b> ' . $user . '</h4>';
                ?>
            </div>
            <div class="face face2">
                <center>
                    <div class="content">
                        <img src="./images/team.png" width="100px" height="100px">
                    </div>
                </center>
            </div>
            <button type="button" class="btn btn-outline-success" onclick="javascript:location.href='adCli.php'">
                Novo</button>
            <button type="button" class="btn btn-outline-danger" onclick="javascript:location.href='delClientes.php'">
                Excluir</button>
        </div>

        <div class="card">
            <div class="face face1" align="center">
                <?php
                $pdo = Banco::conectar();
                $sql = 'SELECT COUNT(?) as cont FROM funcionarios';
                $q = $pdo->prepare($sql);
                $q->execute(array('nome'));
                $data = $q->fetch(PDO::FETCH_ASSOC);
                $totfunc = $data['cont'];
                Banco::desconectar();
                if ($totfunc == 0) {
                    header('location: logout.php');
                }
                echo '<h4><b>Funcionarios:</b> ' . $totfunc . '</h4>';
                ?>
            </div>
            <div class="face face2">
                <center>
                    <div class="content">
                        <img src="./images/employee.png" width="100px" height="100px">
                    </div>
                </center>
            </div>
            <button type="button" class="btn btn-outline-primary" onclick="javascript:location.href='listFunc.php'">
                Editar</button>
            <button type="button" class="btn btn-outline-danger" onclick="javascript:location.href='delFunc.php'">
                Excluir
            </button>
        </div>

        <div class="card">
            <div class="face face1" align="center">
                <?php
                $pdo = Banco::conectar();
                $sql = 'SELECT COUNT(?) as cont FROM reserva';
                $q = $pdo->prepare($sql);
                $q->execute(array('num-quarto'));
                $data = $q->fetch(PDO::FETCH_ASSOC);
                $user = $data['cont'];
                echo '<h4><b>Ocupado:</b> ' . $user . '</h3>';

                $sql = 'SELECT count(?) as tot FROM disponivel where disp=1';
                $q = $pdo->prepare($sql);
                $q->execute(array('disp'));
                $data = $q->fetch(PDO::FETCH_ASSOC);
                $total = $data['tot'];
                Banco::desconectar();
                ?>
            </div>
            <div class="face face2">
                <center>
                    <div class="content">
                        <img src="./images/add-hotel-symbol.png" width="100px" height="100px">
                    </div>
                </center>
            </div>
            <input type="button" class="btn btn-outline-primary" value="Check-in" onclick="javascript:location.href='reserva.php'" <?php if ($total == 0) {
                                                                                                                                        echo "disabled";
                                                                                                                                    } ?>>
            <input type="button" class="btn btn-outline-secondary" value="Check-out" onclick="javascript:location.href='listReservas.php'">
        </div>

        <div class="card">
            <div class="face face1" align="center">
                <?php
                echo '<h4><b>Disponível: </b>' . $total . '</h4>';
                ?>
            </div>
            <div class="face face2">

                <center>
                    <div class="content">
                        <img src="./images/resort.png" width="100px" height="100px">
                    </div>
                </center>
            </div>
            <input type="button" class="btn btn-outline-success" value="Cadastro" onclick="javascript:location.href='adQuarto.php' ">
            <input type="button" class="btn btn-outline-danger" value="Excluir" onclick="javascript:location.href='delQuartos.php'">
        </div>

        <div class="card">
            <div class="face face1" align="center">
                <h4><b>Hitórico</b></h4>
            </div>
            <div class="face face2">
                <center>
                    <div class="content">
                        <img src="./images/historico.png" width="100px" height="100px">
                    </div>
                </center>
            </div>
            <br>
            <input type="button" class="btn btn-outline-info" value="Histórico" onclick="javascript:location.href='listHist.php' ">
        </div>
    </div>

    <?php
    if ($total == 0) {
        echo '<div class="col-md-3" id="alert">
                    <div class="alert alert-danger" role="alert">
                        Não Há quartos disponíveis!!!
                    </div>
                </div>';
    }
    ?>

</body>
<!-- Autor: José Leocadio de Barros Junior -->

</html>