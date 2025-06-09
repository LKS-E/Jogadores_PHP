<?php
include_once("header.php");


?>

<div class="container-home">
    <h1>
        Bem-vindo ao Sistema
        <?php if (isset($_SESSION['usuario'])): ?>
        , <?= htmlspecialchars($_SESSION['usuario']); ?>
        <?php endif; ?>
        !
    </h1>
    <p>Use o menu acima para navegar entre as seções do sistema:</p>

    <ul class="feature-list">
        <li>📋 <strong>Jogadores:</strong> veja e cadastre jogadores com suas estatísticas.</li>
        <li>📝 <strong>Publicações:</strong> compartilhe e leia atualizações no estilo rede social.</li>
        <li>🚪 <strong>Sair:</strong> encerra sua sessão com segurança.</li>
    </ul>
</div>

<?php
include_once('footer.php');
?>