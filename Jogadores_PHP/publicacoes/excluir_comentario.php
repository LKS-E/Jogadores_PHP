<?php
require_once('../conexao.php');
require_once('../models/Comentario.php');

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id_usuario']) || !isset($_GET['id'])) {
    header("Location: feed.php");
    exit();
}

$id_comentario = $_GET['id'];
$id_usuario_logado = $_SESSION['id_usuario'];

// --- LÓGICA DE EXCLUSÃO COM O MODELO ---
$comentarioModel = new Comentario($conn);


$comentarioModel->excluir($id_comentario, $id_usuario_logado);


$url_anterior = $_SERVER['HTTP_REFERER'] ?? 'feed.php';
header("Location: " . $url_anterior);
exit();
?>