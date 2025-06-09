<?php
session_start();
session_destroy();
header("Location: /Jogadores_PHP/index.php");
exit();
