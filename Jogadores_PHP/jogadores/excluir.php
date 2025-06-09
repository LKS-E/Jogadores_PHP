<?php
require_once('../conexao.php');
require_once('../models/Jogador.php'); 

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id_usuario']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: listar.php");
    exit();
}
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Erro de validação CSRF!');
}

if (isset($_POST['id'])) {
    $id_jogador = $_POST['id'];
    $jogadorModel = new Jogador($conn);
    $jogadorModel->excluir($id_jogador);

    header("Location: listar.php");
    exit();

} else {
    header("Location: listar.php");
    exit();
}
?>