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
            
            $sql = "DELETE FROM disponivel where id=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));

        Banco::desconectar();
        header("location: delQuartos.php");
    }
