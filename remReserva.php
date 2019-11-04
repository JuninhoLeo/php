<?php
include 'banco.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.html");
}
$id = trim($_POST['id']);

if (!empty($id)) {
    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT id 
    FROM funcionarios 
    inner join usuarios on(usuarios.usuario_id = funcionarios.usuario_id) 
    where usuarios.usuario =?";
    $q = $pdo->prepare($sql);
    $q->execute(array($_SESSION['user']));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $user = $data['id'];

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
        $q->execute(array($row['id_user'], $row['id'], $row['num_quarto'], $user));

        $sql = "DELETE FROM reserva where id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($row['id']));
    }
     
    Banco::desconectar();
    header("location: home.php?id=".$id."");

}