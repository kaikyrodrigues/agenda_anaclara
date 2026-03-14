<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "cadastro_pessoas";


try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4",$user, $pass);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}



?>