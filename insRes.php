<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.html");
}

    $Cli    = trim($_POST['Cli']);
    $quarto = trim($_POST['num']);
    $dataEn = trim($_POST['dataE']);
    $dataSa = trim($_POST['dataS']);
    
    include 'banco.php';
    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT usuario_id FROM usuarios where usuarios.usuario = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($_SESSION['user']));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $Fun = $data['usuario_id'];    
    $sq = 'SELECT valor FROM disponivel where num_quarto='.$quarto.';';

    foreach ($pdo->query($sq) as $row) {
        $valor = $row['valor'];
    }

    if (!empty($Cli) && !empty($quarto) && !empty($dataEn) && !empty($Fun) && !empty($valor)) 
    {

        $sql = 'INSERT INTO reserva(id_user, num_quarto, entrada, saida, total, func_id) 
                VALUES (?,?,?,?,?,?)';
        $q = $pdo->prepare($sql);
        $q->execute(array($Cli,$quarto,$dataEn,$dataSa,$valor,$Fun));

        $sql = 'UPDATE disponivel SET disp= false WHERE num_quarto=?';
        $q = $pdo->prepare($sql);
        $q->execute(array($quarto));
        
        header("location:home.php");
    }
    else 
    {
        echo '<h1>Erro ao Fazer o Cadastro<h1>';
        echo '<br>';
        echo '<h1>verifique os Dados informados e tente Novamente<h1>';
    }
    
    $pdo = Banco::desconectar();
?>