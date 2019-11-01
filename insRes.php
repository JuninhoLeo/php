<?php

session_start();
if (!isset($_SESSION['user'])) {
    header('location: index.html');
}

$Cli = trim($_POST['Cli']);
$quarto = trim($_POST['num']);
$dataEn = trim($_POST['dataE']);
$dataSa = trim($_POST['dataS']);

include 'banco.php';
$pdo = Banco::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT usuario_id FROM usuarios where usuarios.usuario = ?';
$q = $pdo->prepare($sql);
$q->execute(array($_SESSION['user']));
$data = $q->fetch(PDO::FETCH_ASSOC);
$Fun = $data['usuario_id'];
$sq = 'SELECT valor FROM disponivel where num_quarto=' . $quarto . ';';

foreach ($pdo->query($sq) as $row) {
    $valor = $row['valor'];
}

if (!empty($Cli) && !empty($quarto) && $dataEn <= $dataSa && !empty($Fun) && !empty($valor)) {
    $sql = 'INSERT INTO reserva(id_user, num_quarto, entrada, saida, total, func_id) 
                VALUES (?,?,?,?,?,?)';
    $q = $pdo->prepare($sql);
    $q->execute(array($Cli, $quarto, $dataEn, $dataSa, $valor, $Fun));

    $sql = 'UPDATE disponivel SET disp= false WHERE num_quarto=?';
    $q = $pdo->prepare($sql);
    $q->execute(array($quarto));

    header('location:home.php');
} else {
    if (empty($dataSa) && !empty($Cli) && !empty($quarto) && !empty($Fun) && !empty($valor)) {
        $sql = 'INSERT INTO reserva(id_user, num_quarto, entrada, saida, total, func_id) 
                    VALUES (?,?,?,?,?,?)';
        $q = $pdo->prepare($sql);
        $q->execute(array($Cli, $quarto, $dataEn, $dataSa, $valor, $Fun));

        $sql = 'UPDATE disponivel SET disp= false WHERE num_quarto=?';
        $q = $pdo->prepare($sql);
        $q->execute(array($quarto));

        header('location:home.php');
    }
}

$pdo = Banco::desconectar();
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
    </style>
    <!-- corpo da pagina -->
    <br><br>

    <form class="container-fluid" id="frmInsRes" name="frmInsRes" method="POST" action="insRes.php">
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="lblcli">Nome do Cliente*</label>
                <select name="Cli" class="custom-select" required>
                    <?php
                    Banco::conectar();
                    $sql = 'SELECT id,nome FROM cliente where id=' . $Cli;
                    foreach ($pdo->query($sql) as $row) {
                        echo '<option value="' . $row['id'] . '">' . $row['nome'] . '</option>';
                    }
                    Banco::desconectar();
                    ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="lblQuarto">Valor do Quarto*</label>
                <select name="num" class="form-control" required>
                    <option value="<?php echo $quarto; ?>"><?php echo $valor; ?></option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="lblDte">Data de Entrada*</label>
                <input type="date" name="dataE" id="resData" required value="<?php echo $dataEn; ?>">
            </div>
            <div class="form-group col-md-2">
                <label for="lblDts">Data de saída (Opcional)</label>
                <input type="date" name="dataS" id="resData" value="<?php echo $dataSa; ?>">
                <?php if ($dataEn > $dataSa) {
                    echo '<div class="alert alert-danger" role="alert">
                    A data informada não está correta!!
                    </div>';
                }
                ?>
            </div>
        </div>
        <h6 style="color: slategray">Campos com * são obrigatórios</h6 style="color: slategray">
        <input type="button" name="voltar" class="btn btn-outline-danger" value="Voltar" onclick="javascript:location.href='home.php'">
        <input type="button" name="Limpar" class="btn btn-outline-warning" value="Limpar" onclick="javascript:location.href='reserva.php'">
        <input type="submit" id="btGrv" name="btGrv" class="btn btn-outline-success" value="Gravar">
    </form>

</body>
<!-- Autor: José Leocadio de Barros Junior -->

</html>