<?php
// Fecha a tag <main> aberta no header.php
?>
</main>

<div id="cookie-banner">
    <p>
        Este site utiliza cookies para garantir a melhor experiência de navegação.
        Ao continuar, você concorda com o uso de cookies.
    </p>
    <button id="aceitar-cookies">Aceitar</button>
</div>
<script>
// Quando a página carregar, este código será executado
document.addEventListener("DOMContentLoaded", function() {
    const cookieBanner = document.getElementById('cookie-banner');
    const acceptButton = document.getElementById('aceitar-cookies');

    function jaAceitouCookies() {
        return document.cookie.split(';').some((item) => item.trim().startsWith('cookie_consent='));
    }

    // Se o usuário ainda NÃO aceitou os cookies, mostramos o banner
    if (!jaAceitouCookies()) {
        cookieBanner.style.display = 'flex';
    }

    // Quando o botão "Aceitar" for clicado...
    acceptButton.addEventListener('click', function() {
        // Criamos um cookie que expira em 1 ano
        let dataExpiracao = new Date();
        dataExpiracao.setFullYear(dataExpiracao.getFullYear() + 1);
        document.cookie = "cookie_consent=true; expires=" + dataExpiracao.toUTCString() +
            "; path=/Jogadores_PHP/";

        cookieBanner.style.display = 'none';
    });
});
</script>
</body>

</html>