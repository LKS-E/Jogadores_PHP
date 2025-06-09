<?php
include_once('../header.php');
require_once('../conexao.php');
require_once('../models/Publicacao.php'); 

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../criar/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Erro de validação CSRF!');
    }

    // --- LÓGICA DE INSERÇÃO COM O MODELO ---
    $publicacaoModel = new Publicacao($conn);
    $id_usuario = $_SESSION['id_usuario'];
    $mensagem = $_POST['mensagem'];

    $sucesso = $publicacaoModel->adicionar($id_usuario, $mensagem);
    
    header("Location: feed.php");
    exit();
}
?>

<div class="form-container">
    <h1>Criar Nova Publicação</h1>

    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

        <div class="form-group">
            <label for="mensagem">Mensagem:</label>
            <textarea id="mensagem" name="mensagem" required rows="6"
                placeholder="No que você está pensando, <?= htmlspecialchars($_SESSION['usuario']) ?>?"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Postar</button>
    </form>

    <div class="form-links">
        <a href="feed.php">Cancelar e Voltar para o Feed</a>
    </div>
</div>

<?php
include_once('../footer.php');
?>