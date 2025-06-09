</main>

<?php
if (!isset($_COOKIE['cookie_consent'])) {
?>
<div id="cookie-banner" style="display: flex;">
    <p>
        Este site utiliza cookies para garantir a melhor experiência de navegação.
        Ao continuar, você concorda com o uso de cookies.
    </p>
    <form method="POST" action="">
        <input type="hidden" name="accept_cookies" value="true">
        <button type="submit" id="aceitar-cookies">Aceitar</button>
    </form>
</div>
<?php
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accept_cookies']) && $_POST['accept_cookies'] === 'true') {
    // Define o cookie para expirar em 1 ano
    setcookie('cookie_consent', 'true', time() + (86400 * 365), '/'); // 86400 = 1 dia
    
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>

</body>

</html>