<?php
include 'banco.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.html");
}

$pdo = Banco::conectar();
$sql = 'SELECT COUNT(?) as id 
        FROM reserva';
$q = $pdo->prepare($sql);
$q->execute(array('id'));
$data = $q->fetch(PDO::FETCH_ASSOC);
if ($data['id'] == 0) {
    header('location: home.php');
}
Banco::desconectar();
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
    @import url('https://fonts.googleapis.com/css?family=Abril+Fatface&display=swap');
    @import url('https://fonts.googleapis.com/css?family=Anton&display=swap');
    
    h4 {
        font-size: 25px;
        font-family: ;
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
            Sistema Hoteleiro
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

    <br>

    <div class="container">
        <form id="frmReserva">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th class="align-middle" scope="col" rowspan="2">id</th>
                        <th class="align-middle" scope="col" rowspan="2">Nome</th>
                        <th class="align-middle" scope="col" rowspan="2">N° de Quartos</th>
                        <th class="align-top" scope="col" colspan="2">
                            <center>Data</center>
                        </th>
                        <th class="align-middle" scope="col" rowspan="2">Total</th>
                        <th class="align-middle" scope="col" rowspan="2"></th>
                    </tr>
                    <tr>
                        <th class="align-middle">Entrada</th>
                        <th class="align-middle">Saida</th>
                    </tr>
                </thead>

                <?php
                $pdo = Banco::conectar();
                $sql = "SELECT reserva.id, cliente.id as cli, cliente.nome, COUNT(reserva.num_quarto) as num_quarto, reserva.entrada, reserva.saida, reserva.total 
                        FROM reserva 
                        INNER JOIN cliente on (reserva.id_user = cliente.id) 
                        GROUP BY cliente.nome
";
                foreach ($pdo->query($sql) as $row) {
                    ?>
                    <tbody>
                        <tr>
                            <td scope="row"><?php echo $row['cli'] ?></td>
                            <td scope="row"><?php echo $row['nome'] ?></td>
                            <td scope="row"><?php echo $row['num_quarto'] ?></td>
                            <td scope="row"><?php echo $row['entrada'] ?></td>
                            <td scope="row"><?php echo $row['saida'] ?></td>
                            <td scope="row"><?php echo $row['total'] ?></td>
                            <td scope="row">
                                <button type="button" class="btn btn-outline-info" id="btfin" onclick="javascript:location.href='checkout.php?id='+<?php echo $row['cli'] ?>">
                                    Finalizar
                                </button>
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