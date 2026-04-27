<?php
$host = "localhost";
$usuario = "root";
$senha = "ceub123456";
$banco = "tarefas";

$conexao = new mysqli($host, $usuario, $senha, $banco);


if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}


$conexao->set_charset("utf8");
?>