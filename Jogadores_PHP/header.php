<?php
if (!isset($_SESSION)) session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JogadoresPHP</title>
    <link rel="stylesheet" href="/Jogadores_PHP/assets/style.css">
</head>

<body>

    <header class="header">
        <div class="header-content">

            <div class="logo">
                <a href="/Jogadores_PHP/index.php">⚽ JogadoresPHP</a>
            </div>

            <div class="header-right">
                <nav class="nav">
                    <a href="/Jogadores_PHP/index.php">Início</a>
                    <a href="/Jogadores_PHP/jogadores/listar.php">Jogadores</a>
                    <a href="/Jogadores_PHP/publicacoes/feed.php">Publicações</a>
                </nav>
                <div class="user-info">
                    <?php if (isset($_SESSION['usuario'])): ?>
                    <a href="/Jogadores_PHP/publicacoes/perfil.php?id=<?= $_SESSION['id_usuario']; ?>"
                        class="user-name-link">
                        <span class="user-name">👤 <?= htmlspecialchars($_SESSION['usuario']); ?></span>
                    </a>
                    <a href="/Jogadores_PHP/criar/logout.php" class="logout-link">Sair</a>
                    <?php else: ?>
                    <a href="/Jogadores_PHP/criar/login.php">Login</a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </header>

    <main class="main-container">