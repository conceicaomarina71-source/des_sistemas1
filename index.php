<?php
session_start();
require 'conexao.php';

// Verifica sessão
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

// Busca tarefas do usuário logado
$usuario_id = $_SESSION["usuario_id"];

$sql = "SELECT * FROM tarefas WHERE usuario_id = ? ORDER BY id DESC";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minhas Tarefas</title>

    <!-- FRAMEWORK ESCOLHIDO: Bootstrap 5 -->
    <!-- Importado via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">
            Sistema de Tarefas
        </span>

        <div class="text-white">
            Olá, <?= $_SESSION["usuario"] ?> |
            <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <!-- BOTÃO NOVA TAREFA -->
    <div class="d-flex justify-content-between mb-3">
        <h3>Minhas Tarefas</h3>
        <a href="nova.php" class="btn btn-primary">+ Nova Tarefa</a>
    </div>

    <!-- TABELA -->
    <div class="card shadow">
        <div class="card-body">

            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Título</th>
                        <th>Status</th>
                        <th>Data de Criação</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                <?php while ($tarefa = $resultado->fetch_assoc()): ?>

                    <tr>
                        <td><?= htmlspecialchars($tarefa["titulo"]) ?></td>

                        <td>
                            <?php if ($tarefa["status"] == "concluida"): ?>
                                <span class="badge bg-success">Concluída</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Pendente</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?= isset($tarefa["data_criacao"]) 
                                ? date("d/m/Y H:i", strtotime($tarefa["data_criacao"])) 
                                : "-" ?>
                        </td>

                        <td>
                            <a href="editar.php?id=<?= $tarefa["id"] ?>" class="btn btn-sm btn-warning">
                                Editar
                            </a>

                            <a href="concluir.php?id=<?= $tarefa["id"] ?>" class="btn btn-sm btn-success">
                                Concluir
                            </a>

                            <a href="excluir.php?id=<?= $tarefa["id"] ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Tem certeza que deseja excluir?')">
                                Excluir
                            </a>
                        </td>
                    </tr>

                <?php endwhile; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

</body>
</html>