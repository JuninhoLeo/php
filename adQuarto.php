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

    label {
        font-size: 14px;
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
        <form id="login-form" class="form" action="valQuarto.php" method="POST">
            <br>
            <br>
            <div class="form-row">
                <div class="col-md-6">
                    <label for="username" class="text-info">Numero do Quarto</label><br>
                    <input type="text" name="numero" id="numero" class="form-control" style="height:30px; font-size: 18px;" required>
                </div>
                <div class="col-md-6">
                    <label for="username" class="text-info">Valor</label><br>
                    <input type="number" name="valor" id="valor" class="form-control" placeholder="R$:" style="height:30px; font-size: 18px;" required>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <label for="username" class="text-info">Descrição</label><br>
                    <textarea type="text" name="descricao" id="descricao" class="form-control" rows="3" placeholder="Ex: Suíte Master com cama king size, closet, banheiro com 2 duchas, hidromassagem..." required></textarea>
                </div>
            </div>
            <div class="form-group">
                <div align="right">
                    <input type="button" name="voltar" class="btn btn-outline-danger" value="Voltar" onclick="javascript:location.href='home.php'">
                    <input type="reset" name="reset" class="btn btn-outline-warning" value="Limpar">
                    <input type="submit" name="submit" class="btn btn-success" value="Confirmar">
                </div>
            </div>
        </form>
    </div>

</body>
<br><br>
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

<!-- Autor: José Leocadio de Barros Junior -->

</html>