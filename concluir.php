<?php
session_start();
require 'conexao.php';


if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}


if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET["id"];
$usuario_id = $_SESSION["usuario_id"];


$stmt = $conexao->prepare(
    "UPDATE tarefas SET status = 'concluida' WHERE id = ? AND usuario_id = ?"
);
$stmt->bind_param("ii", $id, $usuario_id);
$stmt->execute();


header("Location: index.php");
exit();
?>