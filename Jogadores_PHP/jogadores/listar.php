<?php
include_once('../header.php');
require_once('../conexao.php');
require_once('../models/Jogador.php');

// --- LÓGICA DE BUSCA COM O MODELO ---
$jogadorModel = new Jogador($conn);

$busca = isset($_GET['busca']) ? $_GET['busca'] : '';

$jogadores = $jogadorModel->buscarTodos($busca);
?>

<div class="content-box">
    <h1>Lista de Jogadores</h1>

    <div class="search-container">
        <form action="listar.php" method="GET" class="search-form">
            <input type="text" name="busca" placeholder="Buscar por nome..." class="search-input"
                value="<?= htmlspecialchars($busca) ?>">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </div>

    <div class="action-links">
        <a href="adicionar.php" class="btn btn-success">Adicionar Novo Jogador</a>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Jogos</th>
                <th>Gols</th>
                <th>Assistências</th>
                <th>Minutos Jogados</th>
                <th>Pé Dominante</th>
                <th>Posição</th>
                <th>Equipe</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($jogadores) > 0): ?>
            <?php foreach($jogadores as $j): ?>
            <tr>
                <td><?= htmlspecialchars($j['nome']) ?></td>
                <td><?= $j['jogos'] ?></td>
                <td><?= $j['gols'] ?></td>
                <td><?= $j['assistencias'] ?></td>
                <td><?= $j['minutos_jogados'] ?></td>
                <td><?= htmlspecialchars($j['pe_dominante']) ?></td>
                <td><?= htmlspecialchars($j['posicao_principal']) ?></td>
                <td><?= htmlspecialchars($j['equipe_atual']) ?></td>
                <td class="actions-cell">
                    <a href="editar.php?id=<?= $j['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                    <form action="excluir.php" method="POST" style="display: inline;">
                        <input type="hidden" name="id" value="<?= $j['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Tem certeza que deseja excluir este jogador?');">Excluir</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="9" style="text-align: center;">Nenhum jogador encontrado.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
include_once('../footer.php');
?>