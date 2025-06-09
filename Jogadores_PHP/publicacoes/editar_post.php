<?php
include_once('../header.php');
require_once('../conexao.php');
require_once('../models/Publicacao.php');

if (!isset($_SESSION['id_usuario']) || !isset($_GET['id'])) {
    header("Location: feed.php");
    exit();
}

$id_post = $_GET['id'];
$id_usuario_logado = $_SESSION['id_usuario'];
$publicacaoModel = new Publicacao($conn);

// LÓGICA PARA ATUALIZAR O POST (MÉTODO POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Erro de validação CSRF!');
    }

    $publicacaoModel->editar($id_post, $_POST['mensagem'], $id_usuario_logado);

    header("Location: feed.php");
    exit();
}

// LÓGICA PARA BUSCAR OS DADOS (MÉTODO GET)
try {
    $post = $publicacaoModel->buscarPorId($id_post);
    if (!$post || $post['id_usuario'] != $id_usuario_logado) {
        header("Location: feed.php");
        exit();
    }
} catch (PDOException $e) {
    die("Erro ao buscar a publicação: " . $e->getMessage());
}

?>

<div class="form-container">
    <h1>Editar Publicação</h1>

    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
        <div class="form-group">
            <label for="mensagem">Sua mensagem:</label>
            <textarea id="mensagem" name="mensagem" required
                rows="6"><?= htmlspecialchars($post['mensagem']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Salvar Alterações</button>
    </form>

    <div class="form-links">
        <a href="feed.php">Cancelar e Voltar para o Feed</a>
    </div>
</div>

</main>
</body>

</html>