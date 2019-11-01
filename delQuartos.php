<?php
include 'banco.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.html");
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

    <!-- corpo da pagina -->
    <div class="container">
        <form id="frmlocHotel" name="frmlocHotel">
            <section class="row" id="hoteis">
                <ul style="list-style: none">
                    <div class="row" id="pularlinha">

                        <h1 style="color: white">Lista de Quartos Disponíveis</h1>
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <!--    <th scope="col"><h4><b>ID</b></h4></th> -->
                                    <th scope="col">
                                        <h4><b>Descrição</b></h4>
                                    </th>
                                    <th scope="col">
                                        <h4><b>Numero do quarto</b></h4>
                                    </th>
                                    <th scope="col">
                                        <h4><b>Valor</b></h4>
                                    </th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>

                            <?php
                            $pdo = Banco::conectar();
                            $sql = 'SELECT COUNT(?) as id FROM disponivel
                                    WHERE disp=1';
                            $q = $pdo->prepare($sql);
                            $q->execute(array('id'));
                            $data = $q->fetch(PDO::FETCH_ASSOC);
                            $cont = $data['id'];
                            if ($cont == 0) {
                                header('location: home.php');
                            }

                            $sql = "SELECT * FROM disponivel 
                                    where disp =1 
                                    ORDER by valor desc";
                            foreach ($pdo->query($sql) as $row) {
                                ?>

                                <tr>
                                    <!--    <th scope="row"><h5><?php echo $row['id'] ?></h5></th>  -->
                                    <th scope="row">
                                        <h5><?php echo $row['descricao'] ?></h5>
                                    </th>
                                    <th scope="row">
                                        <h5><?php echo $row['num_quarto'] ?></h5>
                                    </th>
                                    <th scope="row">
                                        <h5><?php echo $row['valor'] ?></h5>
                                    </th>
                                    <th scope="row" class="text-center">
                                        <button type="button" class="btn btn-outline-danger" id="btRes" onclick="javascript:location.href='remQuarto.php?id='+<?php echo $row['id'] ?>">
                                            Excluir
                                        </button>
                                    </th>
                                </tr>

                            <?php
                            }
                            Banco::desconectar();
                            ?>
                        </table>

                    </div>

                </ul>
            </section>
        </form>
    </div>

</body>
<!-- Autor: José Leocadio de Barros Junior -->

</html>