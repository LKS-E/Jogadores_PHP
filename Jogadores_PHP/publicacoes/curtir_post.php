<?php
require_once('../conexao.php');
require_once('../models/Curtida.php');

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id_usuario']) || !isset($_GET['id'])) {
    header("Location: feed.php");
    exit();
}

$id_post = $_GET['id'];
$id_usuario = $_SESSION['id_usuario'];


// --- LÓGICA DE CURTIR COM O MODELO ---
$curtidaModel = new Curtida($conn);
$curtidaModel->alternarCurtida($id_post, $id_usuario);

$url_anterior = $_SERVER['HTTP_REFERER'] ?? 'feed.php';
header("Location: " . $url_anterior);
exit();
?>