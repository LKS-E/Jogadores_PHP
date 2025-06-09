<?php
require_once('../conexao.php');
require_once('../models/Usuario.php');
include_once('../header.php');

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Erro de validação CSRF!');
    }

    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];

    // --- LÓGICA DE VERIFICAÇÃO COM O MODELO ---
    $usuarioModel = new Usuario($conn);
    $user = $usuarioModel->buscarPorCpfEDataNascimento($cpf, $data_nascimento);

    if ($user) {
        // Usuário encontrado! Guarda o ID na sessão para o próximo passo.
        $_SESSION['id_usuario_reset'] = $user['id'];
        header("Location: resetar_senha.php");
        exit();
    } else {
        $msg = "CPF ou data de nascimento não encontrados ou não correspondem.";
    }
}
?>

<div class="form-container">
    <h1>Recuperar Senha</h1>
    <p>Para iniciar a recuperação, por favor, informe seu CPF e data de nascimento.</p>

    <?php if ($msg): ?>
    <p class="form-message error"><?= $msg; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

        <div class="form-group">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required>
        </div>
        <div class="form-group">
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" required>
        </div>
        <button type="submit" class="btn btn-primary">Verificar Dados</button>
    </form>

    <div class="form-links">
        <a href="login.php">Voltar para a página de login</a>
    </div>
</div>

<?php
include_once('../footer.php');
?>