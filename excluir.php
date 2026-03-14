<?php
session_start();
require "db.php";

if(!isset($_SESSION["logado"])){
    header("Location: index.php");
    exit;   
}

if(isset($_GET["id"])){
    $stmt = $pdo->prepare("DELETE FROM pessoas WHERE id = ?");

    $stmt->execute([$_GET["id"]]);
}

header("Location: dashboard.php");
exit;


?>