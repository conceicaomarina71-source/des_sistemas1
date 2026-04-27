<?php
session_start();
require 'conexao.php';

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST["usuario"] ?? "";
    $senha   = $_POST["senha"] ?? "";


    $sql = "SELECT * FROM usuarios WHERE usuario = ? AND senha = MD5(?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ss", $usuario, $senha);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $user = $resultado->fetch_assoc();

   
        $_SESSION["usuario_id"] = $user["id"];
        $_SESSION["usuario"]    = $user["usuario"];

        header("Location: index.php");
        exit();
    } else {
        $erro = "Usuário ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height:100vh;">

<div class="card shadow p-4" style="width: 350px;">

    <h4 class="text-center mb-3">Login</h4>

 
    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger text-center">
            <?= $erro ?>
        </div>
    <?php endif; ?>

   
    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Usuário</label>
            <input type="text" name="usuario" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Senha</label>
            <input type="password" name="senha" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Entrar
        </button>

    </form>

</div>

</body>
</html>