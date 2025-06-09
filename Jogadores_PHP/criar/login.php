<?php
require_once('../conexao.php');
require_once('../models/Usuario.php'); 
include_once('../header.php');

if (isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}

$erro = "";
if (isset($_GET['status']) && $_GET['status'] == 'senha_redefinida') {
    $sucesso = "Senha redefinida com sucesso! Você já pode fazer o login.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Erro de validação CSRF!');
    }
    // --- LÓGICA DE LOGIN COM O MODELO  ---
    $usuarioModel = new Usuario($conn);
    $user = $usuarioModel->verificarLogin($_POST['usuario'], $_POST['senha']);

    if ($user) {
        $_SESSION['id_usuario'] = $user['id'];
        $_SESSION['usuario'] = $user['nome'];
        
        header("Location: ../index.php");
        exit();
    } else {
        $erro = "Usuário ou senha inválidos.";
    }
}
?>

<div class="form-container">
    <h1>Login</h1>

    <?php if (!empty($sucesso)): ?>
    <p class="form-message success"><?= $sucesso; ?></p>
    <?php endif; ?>
    <?php if (!empty($erro)): ?>
    <p class="form-message error"><?= $erro; ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="form-group">
            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario" required>
        </div>
        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>

    <div class="form-links">
        <a href="registro.php">Criar conta</a>
        <a href="recuperar_senha.php">Esqueceu a senha?</a>
    </div>
</div>

<?php
include_once('../footer.php');
?>