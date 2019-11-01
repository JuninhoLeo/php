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
    <link rel="stylesheet" type="text/css" href="home.css">
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
    @import url('https://fonts.googleapis.com/css?family=Abril+Fatface&display=swap');
    @import url('https://fonts.googleapis.com/css?family=Anton&display=swap');

    h4 {
        font-size: 25px;
        font-family: ;
    }

    h4#func {
        font-family: 'Anton', sans-serif;
    }

    th {
        font-size: 20px;
        font-family: 'Abril Fatface', cursive;
    }

    td {
        font-size: 15px;
        font-family: 'Anton', sans-serif;
        text-align: center;
    }
</style>

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

            echo "<h4 id='func'>" . $user . "&nbsp;&nbsp;<h4>"
            ?>

            <button class="btn btn-secondary my-2 my-sm-0" type="button" data-toggle="modal" data-target="#loginModal" onclick="location.href='logout.php'">Logout</button>
        </form>
    </nav>
    <!-- end navbar -->

    <!-- corpo da pagina -->
    <br><br>

    <div class="container">
        <form id="frmReserva">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th class="align-middle" scope="col">ID</th>
                        <th class="align-middle" scope="col">Cliente</th>
                        <th class="align-middle" scope="col">N° Quarto</th>
                        <th class="align-top" scope="col">Funcionário</th>
                        <th class="align-middle">Data</th>
                        <th class="align-middle">Tipo</th>
                    </tr>
                </thead>

                <?php
                $pdo = Banco::conectar();
                $sql = "SELECT historico.id, cliente.nome as nomecli, historico.quarto, funcionarios.nome as nomefunc, historico.datareg, historico.tipo 
                        FROM historico 
                        INNER join cliente ON(cliente.id = historico.cliente) 
                        INNER join funcionarios ON(funcionarios.id = historico.funcionario) 
                        ORDER BY id ASC";

                foreach ($pdo->query($sql) as $row) {
                    ?>
                    <tbody>
                        <tr>
                            <?php $date = new DateTime($row['datareg']);
                                  $data = $date->format('d/m/Y');
                            ?>
                            <td scope="row"><?php echo $row['id'] ?></td>
                            <td scope="row"><?php echo $row['nomecli'] ?></td>
                            <td scope="row"><?php echo $row['quarto'] ?></td>
                            <td scope="row"><?php echo $row['nomefunc'] ?></td>
                            <td scope="row"><?php echo $data ?></td>
                            <td scope="row">
                                <?php 
                                    if ($row['tipo'] == 'entrada') {
                                        echo "<div class='text-success'>Entrada</div>";
                                    }elseif ($row['tipo'] == 'saida') {
                                        echo "<div class='text-warning'>Saida</div>";
                                    }elseif ($row['tipo'] == 'cancelado') {
                                        echo "<div class='text-danger'>Cancelada</div>";
                                    }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                <?php
                }
                Banco::desconectar();
                ?>
            </table>
        </form>
    </div>

</body>
<!-- Autor: José Leocadio de Barros Junior -->

</html>