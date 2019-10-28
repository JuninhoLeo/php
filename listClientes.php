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
    <form id="frmlocHotel" name="frmlocHotel">
        <section class="row" id="hoteis">
            <ul style="list-style: none">
                <div class="row" id="pularlinha">

                    <h1 style="color: white">Lista de Clientes</h1>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">CPF</th>
                                <th scope="col">RG</th>
                                <th scope="col">Cidade</th>
                                <th scope="col">UF</th>
                                <th scope="col">Telefone</th>
                                <th scope="col">e-mail</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>

                        <?php
                        $pdo = Banco::conectar();
                        $sql = 'SELECT * FROM cliente';
                        foreach ($pdo->query($sql) as $row) {
                            ?>

                            <tr>

                                <td scope="row"><?php echo $row['nome'] ?></td>
                                <td scope="row"><?php echo $row['cpf'] ?></td>
                                <td scope="row"><?php echo $row['rg'] ?></td>
                                <td scope="row"><?php echo $row['cidade'] ?></td>
                                <td scope="row"><?php echo $row['uf'] ?></td>
                                <td scope="row"><?php echo $row['telefone'] ?></td>
                                <td scope="row"><?php echo $row['email'] ?></td>

                                <td scope="row" class="text-center">
                                    <button type="button" class="btn btn-outline-warning" id="btRes" onclick="javascript:location.href='altCli.php?id='+<?php echo $row['id'] ?>">
                                        Alterar</button>
                                </td>
                            </tr>

                        <?php }
                        Banco::desconectar();
                        ?>
                    </table>

                </div>

            </ul>
        </section>
    </form>

</body>
<!-- Autor: José Leocadio de Barros Junior -->

</html>