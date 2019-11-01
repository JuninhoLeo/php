<?php
include 'banco.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.html");
}
$id = trim($_GET['id']);
$cli = trim($_GET['cli']);
$quarto = trim($_GET['quarto']);

if (!empty($id)) {
    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT func_id 
            from reserva 
            WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $func = $data['func_id'];

    $sql = "DELETE FROM reserva where id=?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));

    $sql = "UPDATE disponivel set disp=1
            where num_quarto=?";
    $q = $pdo->prepare($sql);
    $q->execute(array($quarto));

    $sql = "INSERT INTO historico(cliente, reserva, tipo, quarto, funcionario, datareg)
            VALUES (?, ?,'cancelado', ?, ?, curdate())";
    $q = $pdo->prepare($sql);
    $q->execute(array($cli, $id, $quarto, $func));

    Banco::desconectar();
    header("location: checkout.php?id=" . $cli . "");
}
