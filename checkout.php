<?php
include 'banco.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('location: index.html');
}
$idcli = trim($_GET['id']);

$pdo = Banco::conectar();
$sql = 'SELECT COUNT(id) as id 
        FROM reserva 
        where id_user=?';
$q = $pdo->prepare($sql);
$q->execute(array($idcli));
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
    @import url('https://fonts.googleapis.com/css?family=Anton&display=swap');
    @import url('https://fonts.googleapis.com/css?family=Stoke&display=swap');
    @import url('https://fonts.googleapis.com/css?family=Lobster&display=swap');
    @import url('https://fonts.googleapis.com/css?family=Source+Code+Pro&display=swap');

    .header {
        background-color: black;
        font-family: 'Modak', cursive;
        color: paleturquoise;
        padding: 2%;
        text-align: center;
    }

    h4 {
        font-size: 25px;
    }

    h4#func {
        font-family: 'Anton', sans-serif;
    }

    h2#valor {
        font-family: 'Anton', sans-serif;
    }

    td#info {
        text-align: right;
        font-size: 12px;
        font-family: 'Stoke', serif;
    }

    td#desc {
        font-family: 'Lobster', cursive;
        text-align: left;
        font-size: 22px;
    }

    div#alert {
        float: right;
    }

    b#cabecalho {
        font-family: 'Source Code Pro', monospace;
        text-align: center;
    }

    tr {
        color: dimgrey;
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

            echo "<h4 id='func'>" . $user . "&nbsp;&nbsp;<h4>"
            ?>

            <button class="btn btn-secondary my-2 my-sm-0" type="button" data-toggle="modal" data-target="#loginModal" onclick="location.href='logout.php'">Logout</button>
        </form>
    </nav>
    <!-- end navbar -->

    <!-- corpo da pagina -->
    <div class='container' align="center">
        <div class='row' style='padding-top:25px; padding-bottom:25px;'>
            <div id='mainContentWrapper'>
                <div class="col-md-12 col-md-offset-2">
                    <div class="shopping_cart">
                        <form class="form-horizontal" role="form" action="remReserva.php" method="POST" id="payment-form">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                <b id="cabecalho"> Dados dos serviços </b>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <div class="items">
                                                <div class="col-md-12">
                                                    <?php
                                                    $total = 0;
                                                    $pdo = Banco::conectar();
                                                    $sql = 'SELECT reserva.id, cliente.nome as nomecli, reserva.num_quarto, disponivel.descricao, reserva.entrada, reserva.saida, reserva.total, funcionarios.nome, curdate()
                                                                FROM reserva 
                                                                INNER JOIN cliente on(cliente.id = reserva.id_user) 
                                                                INNER JOIN funcionarios on(funcionarios.id = reserva.func_id) 
                                                                INNER join disponivel on(disponivel.num_quarto = reserva.num_quarto) 
                                                                WHERE reserva.id_user = ' . $idcli;
                                                    foreach ($pdo->query($sql) as $row) {
                                                        ?>
                                                        <table class="table-bordered">
                                                            <tr>
                                                                <td colspan="2" align="center">
                                                                    <a class="btn btn-warning btn-sm pull-right" onclick="javascript:location.href='updres.php?id='+<?php echo $row['id'] ?>+'&cli='+<?php echo $idcli ?>+'&quarto='+<?php echo $row['num_quarto'] ?>" title="Remove Item">X</a>
                                                                    <b id="cabecalho" style="font-size: 25px;">Reserva</b>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                                $date = new DateTime($row['entrada']);
                                                                $dataE =  $date->format('d/m/Y');
                                                                $dataentrada = $date->format('Y-m-d');
                                                                $date = new DateTime($row['saida']);
                                                                $dataS =  $date->format('d/m/Y');
                                                                $datasaida = $date->format('Y-m-d');
                                                                $date = new DateTime($row['curdate()']);
                                                                $dataA =  $date->format('d/m/Y');
                                                                $dataagora = $date->format('Y-m-d');

                                                                $datetime1 = new \DateTime($dataentrada);
                                                                $datetime2 = new \DateTime($datasaida);
                                                                $datetime3 = new \DateTime($dataagora);

                                                                if ($row['saida'] > 0) {
                                                                    $interval = $datetime1->diff($datetime2);
                                                                } else {
                                                                    $interval = $datetime1->diff($datetime3);
                                                                }

                                                                $dias = $interval->days;
                                                                ?>
                                                            <tr>
                                                                <td id="info">COD:</td>
                                                                <td id="desc"><?php echo $row['id'] ?></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td id="info">Cliente:</td>
                                                                <td id="desc"><?php echo $row['nomecli'] ?></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td id="info">Quarto:</td>
                                                                <td id="desc"><?php echo $row['descricao'] ?></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td id="info">N°:</td>
                                                                <td id="desc"><?php echo $row['num_quarto'] ?></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td id="info">Data:</td>
                                                                <td id="desc"><?php echo $dataE . '  a  ';
                                                                                    if ($row['saida'] > 0) {
                                                                                        echo $dataS;
                                                                                    } else {
                                                                                        echo $dataA;
                                                                                    } ?></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td id="info">Total de dias:</td>
                                                                <td id="desc"> <?php echo $dias ?></b></td>
                                                            </tr>
                                                            <?php $valor = $dias * $row['total'] ?>
                                                            <br>
                                                            <tr>
                                                                <td id="info">Valor Unt:</td>
                                                                <td id="desc">R$: <?php echo number_format($row['total'], 2, ',', '.') . '</b>' ?></b></td>
                                                            <tr>
                                                        </table>
                                                    <?php
                                                        $total += $valor;
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-md-10">
                                                    <div style="text-align: center;">
                                                        <h2 id="valor">Valor Total: R$: <?php echo number_format($total, 2, ',', '.') ?></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <div style="text-align: center;"><a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class=" btn   btn-success" id="payInfo" style="width:100%;display: none;" onclick="$(this).fadeOut();  
                                                document.getElementById('collapseThree').scrollIntoView()">Entre com as informações do pagamento»</a>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                            <b id="cabecalho">Informações de pagamento</b>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <span class='payment-errors'></span>
                                        <fieldset>
                                            <legend> <b id="cabecalho">Com que método voçê gostaria de pagar hoje?</b></legend>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label text-secondary" for="card-holder-name" style="font-size: 13px;">
                                                    Nome no cartão
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" stripe-data="name" id="name-on-card" placeholder="Nome do titular do cartão" required>
                                                </div>
                                            </div>
                                            <div class=" form-group">
                                                <label class="col-sm-3 control-label text-secondary" for="card-number" style="font-size: 13px;">
                                                    Número do catão
                                                </label>
                                                <div class=" col-sm-9">
                                                    <input type="text" class="form-control" stripe-data="number" id="card-number" placeholder="Número do cartão de débito/crédito" required>
                                                    <br />
                                                    <div><img class="pull-right" src="https://s3.amazonaws.com/hiresnetwork/imgs/cc.png" style="max-width: 250px; padding-bottom: 20px;">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label text-secondary" for="expiry-month" style="font-size: 13px;">
                                                        Data de validade
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <div class="row">
                                                            <div class="col-xs-3">
                                                                <select class="form-control" data-stripe="exp-month" id="card-exp-month" style="height:33px; font-size: 18px; width: 100px;" required>
                                                                    <option value="">Mês</option>
                                                                    <option value="01">Jan (01)</option>
                                                                    <option value="02">Fev (02)</option>
                                                                    <option value="03">Mar (03)</option>
                                                                    <option value="04">Abr (04)</option>
                                                                    <option value="05">Mai (05)</option>
                                                                    <option value="06">Jun (06)</option>
                                                                    <option value="07">Jul (07)</option>
                                                                    <option value="08">Ago (08)</option>
                                                                    <option value="09">Set (09)</option>
                                                                    <option value="10">Out (10)</option>
                                                                    <option value="11">Nov (11)</option>
                                                                    <option value="12">Dez (12)</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-xs-3">
                                                                <select class="form-control" data-stripe="exp-year" id="card-exp-year" style="height:33px; font-size: 18px; width: 70px;" required>
                                                                    <option value="">Ano</option>
                                                                    <option value="2016">2016</option>
                                                                    <option value="2017">2017</option>
                                                                    <option value="2018">2018</option>
                                                                    <option value="2019">2019</option>
                                                                    <option value="2020">2020</option>
                                                                    <option value="2021">2021</option>
                                                                    <option value="2022">2022</option>
                                                                    <option value="2023">2023</option>
                                                                    <option value="2024">2024</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label text-secondary" for="cvv" style="font-size: 13px;">
                                                        Código CVC
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" stripe-data="cvc" id="card-cvc" style="height:33px; font-size: 15px; width: 50px;" maxlength=3 required>

                                                        <!-- ID lançado oculto para metodo POST -->
                                                        <input type="hidden" name="id" value="<?php echo $idcli ?>">
                                                        <!-- Nao apagar !!!! -->

                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-3 col-sm-9">
                                                    </div>
                                                </div>
                                        </fieldset>
                                        <button type="submit" class="btn btn-success btn-lg" style="width:100%;">
                                            Finalizar Pagamento
                                        </button>
                                        <br />
                                        <div style="text-align: left;"><br />
                                            Ao enviar este pedido, você concorda com o nosso <a href="">universal</a>
                                            e com os <a href="">termos de serviço</a>.
                                            Se você tiver alguma dúvida sobre nossos produtos ou serviços,
                                            entre em contato conosco.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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