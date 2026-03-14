<?php
session_start();

require "db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");

    $stmt->execute([$_POST["email"]]);

    $user = $stmt->fetch();


    if($user && password_verify($_POST["senha"], $user["senha"])){
        $_SESSION["logado"] = $user["id"];

        header("Location: dashboard.php");

        exit;
    }else{
        $erro = "Login invalido";
    }
}
?>

<form action="" method="post">
    <h2>Login</h2>

    <label for="email">EMAIL</label>
    <input type="email" name="email" id="email" required> <br>

    <label for="senha">SENHA</label>
    <input type="password" name="senha" id="senha" required> <br>

    <button type="submit">ENTRAR</button>

    <?php if(isset($erro)) echo $erro; ?>
</form>