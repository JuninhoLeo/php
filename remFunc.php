<?php
include 'banco.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.html");
}
$user = $_SESSION['user'];
$id = trim($_GET['id']);

$pdo = Banco::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT *  from usuarios
            where usuario_id =?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $usuario = $data['usuario'];
Banco::desconectar();

    if (!empty($id)) {
    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM funcionarios where usuario_id=?;            
                DELETE FROM usuarios where usuario_id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id, $id,));

        $sql = "SELECT COUNT(?) as cont FROM funcionarios";
        $q = $pdo->prepare($sql);
        $q->execute(array('nome'));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $totfunc = $data['cont'];
    Banco::desconectar();

            if ($totfunc == 0 or $usuario == $user) {
                header("location: logout.php");
            }else{
                header("location: delFunc.php");
            }
            
    }
?>