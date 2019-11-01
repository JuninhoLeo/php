<?php
include 'banco.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.html");
}
$id = trim($_GET['id']);

if (!empty($id)) {
    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $SQLPrin = "SELECT * FROM reserva 
    WHERE id_user= ".$id;
    foreach ($pdo->query($SQLPrin) as $row) {

        $sql = "UPDATE disponivel set disp=1
            where num_quarto=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($row['num_quarto']));

        $sql = "INSERT INTO historico(cliente, reserva, tipo, quarto, funcionario, datareg)
            VALUES (?, ?,'saida', ?, ?, curdate())";
        $q = $pdo->prepare($sql);
        $q->execute(array($row['id_user'], $row['id'], $row['num_quarto'], $row['func_id']));

        $sql = "DELETE FROM reserva where id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($row['id']));
    }
     
    Banco::desconectar();
    header("location: home.php?id=".$id."");
}