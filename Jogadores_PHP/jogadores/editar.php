<?php
include_once('../header.php');
require_once('../conexao.php');
require_once('../models/Jogador.php'); 

if (!isset($_SESSION['id_usuario']) || !isset($_GET['id'])) {
    header("Location: listar.php");
    exit();
}

$id_jogador = $_GET['id'];
$jogadorModel = new Jogador($conn);

// LÓGICA PARA ATUALIZAR O JOGADOR (MÉTODO POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Erro de validação CSRF!');
    }

    $jogadorModel->editar($_POST);

    header("Location: listar.php");
    exit();
}

// LÓGICA PARA BUSCAR OS DADOS (MÉTODO GET)
try {
    $jogador = $jogadorModel->buscarPorId($id_jogador);

    if (!$jogador) {
        header("Location: listar.php");
        exit();
    }
} catch (PDOException $e) {
    die("Erro ao buscar jogador: " . $e->getMessage());
}
?>

<div class="form-container">
    <h1>Editar Jogador</h1>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $jogador['id'] ?>">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

        <div class="form-group">
            <label for="nome">Nome do Jogador:</label>
            <input type="text" id="nome" name="nome" required value="<?= htmlspecialchars($jogador['nome']) ?>">
        </div>

        <div class="form-group">
            <label for="jogos">Jogos:</label>
            <input type="number" id="jogos" name="jogos" value="<?= htmlspecialchars($jogador['jogos']) ?>">
        </div>

        <div class="form-group">
            <label for="gols">Gols:</label>
            <input type="number" id="gols" name="gols" value="<?= htmlspecialchars($jogador['gols']) ?>">
        </div>
        <div class="form-group">
            <label for="assistencias">Assistências:</label>
            <input type="number" id="assistencias" name="assistencias"
                value="<?= htmlspecialchars($jogador['assistencias']) ?>">
        </div>
        <div class="form-group">
            <label for="minutos_jogados">Minutos Jogados:</label>
            <input type="number" id="minutos_jogados" name="minutos_jogados"
                value="<?= htmlspecialchars($jogador['minutos_jogados']) ?>">
        </div>
        <div class="form-group">
            <label for="pe_dominante">Pé Dominante:</label>
            <select id="pe_dominante" name="pe_dominante" required>
                <option value="Destro" <?= ($jogador['pe_dominante'] == 'Destro') ? 'selected' : '' ?>>Destro</option>
                <option value="Canhoto" <?= ($jogador['pe_dominante'] == 'Canhoto') ? 'selected' : '' ?>>Canhoto
                </option>
                <option value="Ambidestro" <?= ($jogador['pe_dominante'] == 'Ambidestro') ? 'selected' : '' ?>>
                    Ambidestro</option>
            </select>
        </div>
        <div class="form-group">
            <label for="posicao_principal">Posição Principal:</label>
            <input type="text" id="posicao_principal" name="posicao_principal"
                value="<?= htmlspecialchars($jogador['posicao_principal']) ?>">
        </div>
        <div class="form-group">
            <label for="equipe_atual">Equipe Atual:</label>
            <input type="text" id="equipe_atual" name="equipe_atual"
                value="<?= htmlspecialchars($jogador['equipe_atual']) ?>">
        </div>

        <button type="submit" class="btn btn-success">Salvar Alterações</button>
    </form>

    <div class="form-links">
        <a href="listar.php">Cancelar e Voltar para a Lista</a>
    </div>
</div>

<?php
include_once('../footer.php');
?>