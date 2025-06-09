<?php
$host = 'localhost';
$db = 'projeto_futebol';
$user = 'root';
$pass = '';
$conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //essa aqui é só pro php mostrar o erro se tiver com SQL//
?>