<?php
include 'banco.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.html");
}

$id   = trim($_POST['id']);
$nome = trim($_POST['nome']);
$CPF  = trim($_POST['cpf']);
$RG   = trim($_POST['rg']);
$cid  = trim($_POST['cidade']);
$UF   = trim($_POST['uf']);
$Tel  = trim($_POST['tel']);
$emai = trim($_POST['email']);

$tnome = false;
$tRG   = false;
$tCPF  = false;
$temail = false;

$pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM cliente where id =!".$id;
        foreach ($pdo->query($sql) as $row) {

            if ($nome == $row['nome']) {
                $tnome = true;
            }

            if ($RG == $row['rg']) {
                $tRG = true;
            }

            if ($CPF == $row['cpf']) {
                $tCPF = true;
            }

            if ($emai == $row['email']) {
                $temail = true;
            }
        }
Banco::desconectar();

    if(  $tnome == false && $tCPF == false && $tRG == false && $temai == false)
    {

        $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE cliente
                    SET nome=?, cpf=?, rg=?, cidade=?, uf=?, telefone=?, email=?
                    where id=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($nome, $CPF, $RG, $cid, $UF, $Tel, $emai, $id));
            header("location: listClientes.php");
        Banco::desconectar();
    
    }