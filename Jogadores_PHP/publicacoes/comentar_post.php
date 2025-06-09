<?php
require_once('../conexao.php');
require_once('../models/Comentario.php');

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id_usuario']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: feed.php");
    exit();
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Erro de validação CSRF!');
}

$id_post = $_POST['id_post'];
$id_usuario = $_SESSION['id_usuario'];
$comentario_texto = $_POST['comentario'];

$comentarioModel = new Comentario($conn);
$comentarioModel->adicionar($id_post, $id_usuario, $comentario_texto);

$url_anterior = $_SERVER['HTTP_REFERER'] ?? 'feed.php';
header("Location: " . $url_anterior);
exit();
?>