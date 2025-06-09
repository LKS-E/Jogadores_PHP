<?php
include_once('../header.php');
require_once('../conexao.php');
require_once('../models/Publicacao.php');
require_once('../models/Comentario.php');

// Se o usuário estiver logado, pegamos o ID dele. Senão, a variável fica nula.
$id_usuario_logado = $_SESSION['id_usuario'] ?? null;

$publicacaoModel = new Publicacao($conn);
$publicacoes = $publicacaoModel->buscarTodas($id_usuario_logado);
?>

<div class="content-box">
    <h1>Feed de Publicações</h1>

    <div class="action-links">
        <?php
            // Define o link do botão: se logado, vai para a página de criar post. Senão, vai para o login.
            $link_nova_pub = isset($_SESSION['id_usuario']) ? 'nova.php' : '/Jogadores_PHP/criar/login.php';
        ?>
        <a href="<?= $link_nova_pub ?>" class="btn btn-success">Criar Nova Publicação</a>
    </div>

    <div class="feed-container">
        <?php if (count($publicacoes) > 0): ?>
        <?php foreach ($publicacoes as $post): ?>
        <div class="post-card">
            <div class="post-header">
                <a href="/Jogadores_PHP/publicacoes/perfil.php?id=<?= $post['id_usuario'] ?>"
                    class="post-author"><?= htmlspecialchars($post['nome_usuario']) ?></a>
                <span class="post-date"><?= date('d/m/Y H:i', strtotime($post['data_publicacao'])) ?></span>
            </div>

            <div class="post-content">
                <p><?= nl2br(htmlspecialchars($post['mensagem'])) ?></p>
            </div>

            <div class="post-actions">
                <div class="like-section">
                    <?php if ($id_usuario_logado): ?>
                    <?php if ($post['usuario_curtiu']): ?>
                    <a href="/Jogadores_PHP/publicacoes/curtir_post.php?id=<?= $post['id'] ?>"
                        class="btn-like liked">Descurtir</a>
                    <?php else: ?>
                    <a href="/Jogadores_PHP/publicacoes/curtir_post.php?id=<?= $post['id'] ?>"
                        class="btn-like">Curtir</a>
                    <?php endif; ?>
                    <?php else: ?>
                    <a href="/Jogadores_PHP/criar/login.php" class="btn-like">Curtir</a>
                    <?php endif; ?>
                    <span class="like-count"><?= $post['total_curtidas'] ?> curtida(s)</span>
                </div>

                <?php if ($id_usuario_logado && $post['id_usuario'] == $id_usuario_logado): ?>
                <div class="owner-actions">
                    <a href="/Jogadores_PHP/publicacoes/editar_post.php?id=<?= $post['id'] ?>"
                        class="btn btn-secondary">Editar</a>
                    <a href="/Jogadores_PHP/publicacoes/excluir_post.php?id=<?= $post['id'] ?>" class="btn btn-danger"
                        onclick="return confirm('Tem certeza?');">Excluir</a>
                </div>
                <?php endif; ?>
            </div>

            <div class="comment-section">
                <h4>Comentários</h4>
                <?php
                            if (!isset($comentarioModel)) {
                                $comentarioModel = new Comentario($conn);
                            }
                            $comentarios = $comentarioModel->buscarPorPost($post['id']);
                        ?>
                <?php foreach ($comentarios as $comentario): ?>
                <div class="comment">
                    <div class="comment-header">
                        <strong><?= htmlspecialchars($comentario['nome_comentarista']) ?>:</strong>
                        <?php if (($id_usuario_logado && $comentario['id_usuario'] == $id_usuario_logado) || ($id_usuario_logado && $post['id_usuario'] == $id_usuario_logado)): ?>
                        <a href="/Jogadores_PHP/publicacoes/excluir_comentario.php?id=<?= $comentario['id'] ?>"
                            class="btn-delete-comment"
                            onclick="return confirm('Tem certeza que deseja excluir este comentário?');">Excluir</a>
                        <?php endif; ?>
                    </div>
                    <p><?= nl2br(htmlspecialchars($comentario['comentario'])) ?></p>
                </div>
                <?php endforeach; ?>

                <?php if ($id_usuario_logado): ?>
                <form action="/Jogadores_PHP/publicacoes/comentar_post.php" method="POST" class="comment-form">
                    <input type="hidden" name="id_post" value="<?= $post['id'] ?>">
                    <input type="hidden" name="csrf_token"
                        value="<?= $_SESSION['csrf_token']; // Adicionando token aqui também ?>">
                    <textarea name="comentario" placeholder="Escreva um comentário..." required></textarea>
                    <button type="submit" class="btn btn-primary">Comentar</button>
                </form>
                <?php else: ?>
                <form class="comment-form">
                    <textarea placeholder="Faça o login para deixar um comentário..." disabled></textarea>
                    <a href="/Jogadores_PHP/criar/login.php" class="btn btn-primary">Comentar</a>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p>Nenhuma publicação encontrada no momento.</p>
        <?php endif; ?>
    </div>
</div>

<?php
include_once('../footer.php');
?>