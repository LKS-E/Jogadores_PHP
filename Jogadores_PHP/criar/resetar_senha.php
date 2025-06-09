<?php
require_once('../conexao.php');
require_once('../models/Usuario.php'); 

if (!isset($_SESSION)) {
    session_start();
}

// Se o usuário não passou pela verificação, não pode estar aqui
if (!isset($_SESSION['id_usuario_reset'])) {
    header("Location: recuperar_senha.php");
    exit();
}

$msg = "";
$tipo_msg = "error"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Erro de validação CSRF!');
    }

    $nova_senha = $_POST['nova_senha'];
    $confirma_senha = $_POST['confirma_senha'];

    if ($nova_senha === $confirma_senha) {
        $id_usuario = $_SESSION['id_usuario_reset'];

        // --- LÓGICA DE ATUALIZAÇÃO COM O MODELO ---
        $usuarioModel = new Usuario($conn);
        $sucesso = $usuarioModel->atualizarSenha($id_usuario, $nova_senha);
        
        if ($sucesso) {
            // Limpa a sessão de reset e redireciona para o login com sucesso
            unset($_SESSION['id_usuario_reset']);
            header("Location: login.php?status=senha_redefinida");
            exit();
        } else {
            $msg = "Ocorreu um erro ao atualizar a senha. Tente novamente.";
        }

    } else {
        $msg = "As senhas não coincidem. Tente novamente.";
    }
}

include_once('../header.php');
?>

<div class="form-container">
    <h1>Crie sua Nova Senha</h1>

    <?php if ($msg): ?>
    <p class="form-message <?= $tipo_msg; ?>"><?= $msg; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

        <div class="form-group">
            <label for="nova_senha">Nova Senha:</label>
            <input type="password" id="nova_senha" name="nova_senha" required>
        </div>
        <div class="form-group">
            <label for="confirma_senha">Confirme a Nova Senha:</label>
            <input type="password" id="confirma_senha" name="confirma_senha" required>
        </div>
        <button type="submit" class="btn btn-success">Salvar Nova Senha</button>
    </form>
</div>

<?php
include_once('../footer.php');
?>