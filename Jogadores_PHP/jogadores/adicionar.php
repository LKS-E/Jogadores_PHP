<?php
include_once('../header.php');
require_once('../conexao.php');
require_once('../models/Jogador.php'); 

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../criar/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Erro de validação CSRF!');
    }

    // --- LÓGICA DE INSERÇÃO COM O MODELO ---
    $jogadorModel = new Jogador($conn);

    $sucesso = $jogadorModel->adicionar($_POST);
    
    if ($sucesso) {
        header("Location: listar.php");
        exit();
    } else {
        $msg = "Ocorreu um erro ao adicionar o jogador.";
    }
}
?>

<div class="form-container">
    <h1>Adicionar Novo Jogador</h1>

    <?php if (!empty($msg)): ?>
    <p class="form-message error"><?= $msg ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

        <div class="form-group">
            <label for="nome">Nome do Jogador:</label>
            <input type="text" id="nome" name="nome" required>
        </div>

        <div class="form-group">
            <label for="jogos">Jogos:</label>
            <input type="number" id="jogos" name="jogos">
        </div>

        <div class="form-group">
            <label for="gols">Gols:</label>
            <input type="number" id="gols" name="gols">
        </div>

        <div class="form-group">
            <label for="assistencias">Assistências:</label>
            <input type="number" id="assistencias" name="assistencias">
        </div>

        <div class="form-group">
            <label for="minutos_jogados">Minutos Jogados:</label>
            <input type="number" id="minutos_jogados" name="minutos_jogados">
        </div>

        <div class="form-group">
            <label for="pe_dominante">Pé Dominante:</label>
            <select id="pe_dominante" name="pe_dominante" required>
                <option value="" disabled selected>-- Selecione --</option>
                <option value="Destro">Destro</option>
                <option value="Canhoto">Canhoto</option>
                <option value="Ambidestro">Ambidestro</option>
            </select>
        </div>

        <div class="form-group">
            <label for="posicao_principal">Posição Principal:</label>
            <input type="text" id="posicao_principal" name="posicao_principal">
        </div>

        <div class="form-group">
            <label for="equipe_atual">Equipe Atual:</label>
            <input type="text" id="equipe_atual" name="equipe_atual">
        </div>

        <button type="submit" class="btn btn-success">Salvar Jogador</button>
    </form>

    <div class="form-links">
        <a href="listar.php">Cancelar e Voltar para a Lista</a>
    </div>
</div>

<?php
include_once('../footer.php');
?>