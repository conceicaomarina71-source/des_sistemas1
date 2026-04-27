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


$stmt = $conexao->prepare("SELECT * FROM tarefas WHERE id = ? AND usuario_id = ?");
$stmt->bind_param("ii", $id, $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows != 1) {
    header("Location: index.php");
    exit();
}

$tarefa = $resultado->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $titulo = trim($_POST["titulo"] ?? "");
    $descricao = trim($_POST["descricao"] ?? "");
    $status = $_POST["status"] ?? "pendente";

    if (!empty($titulo)) {

        $stmt = $conexao->prepare(
            "UPDATE tarefas SET titulo = ?, descricao = ?, status = ? WHERE id = ? AND usuario_id = ?"
        );

        $stmt->bind_param("sssii", $titulo, $descricao, $status, $id, $usuario_id);
        $stmt->execute();

        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarefa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">


<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Editar Tarefa</span>
        <a href="index.php" class="btn btn-sm btn-light">Voltar</a>
    </div>
</nav>

<div class="container mt-4">

    <div class="card shadow">
        <div class="card-body">

            <h4 class="mb-3">Editar Tarefa</h4>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Título *</label>
                    <input type="text" name="titulo" class="form-control"
                           value="<?= htmlspecialchars($tarefa["titulo"]) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao" class="form-control" rows="4"><?= htmlspecialchars($tarefa["descricao"]) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="pendente" <?= $tarefa["status"] == "pendente" ? "selected" : "" ?>>
                            Pendente
                        </option>
                        <option value="concluida" <?= $tarefa["status"] == "concluida" ? "selected" : "" ?>>
                            Concluída
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Salvar Alterações
                </button>

                <a href="index.php" class="btn btn-secondary">
                    Cancelar
                </a>

            </form>

        </div>
    </div>

</div>

</body>
</html>