<?php
require_once('../conexao.php');
require_once('../models/Usuario.php');
include_once('../header.php');

if (isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
    exit();
}

$msg = "";
$tipo_msg = "";

// Processa o formulário quando ele for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Erro de validação CSRF!');
    }
    $usuarioModel = new Usuario($conn);

    $resultado = $usuarioModel->registrar(
        $_POST['usuario'],
        $_POST['cpf'],
        $_POST['data_nascimento'],
        $_POST['senha']
    );

    if ($resultado === true) {
        $msg = "Usuário registrado com sucesso! Você pode fazer o login.";
        $tipo_msg = "success";
    } else {
        $msg = "Erro ao registrar: Este nome de usuário ou CPF já pode estar em uso.";
        $tipo_msg = "error";
    }
}
?>

<div class="form-container">
    <h1>Criar Conta</h1>

    <?php if ($msg): ?>
    <p class="form-message <?= $tipo_msg; ?>"><?= $msg; ?></p>
    <?php endif; ?>

    <form method="POST" action="registro.php">
        <div class="form-group">
            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario" required>
        </div>

        <div class="form-group">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required>
        </div>

        <div class="form-group">
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" required>
        </div>

        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>

        <button type="submit" class="btn btn-success">Registrar</button>
    </form>

    <div class="form-links">
        <a href="login.php">Já tem uma conta? Faça o login</a>
    </div>
</div>

<?php
include_once('../footer.php');
?>