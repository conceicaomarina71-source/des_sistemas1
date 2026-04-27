<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Tarefas</title>

  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Sistema de Tarefas</span>

        <div class="text-white">
            <?php if (isset($_SESSION["usuario"])): ?>
                Olá, <?= $_SESSION["usuario"] ?> |
                <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container mt-4"></div>