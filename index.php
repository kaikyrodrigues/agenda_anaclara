<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de pacientes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
session_start();

require "db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");

    $stmt->execute([$_POST["username"]]);

    $user = $stmt->fetch();


    if($user && password_verify($_POST["senha"], $user["senha"])){
        $_SESSION["logado"] = $user["id"];

        header("Location: dashboard.php");

        exit;
    }else{
        $erro = "Usuário ou Senha inválido!";
    }
}
?>
<div class="corpo">
    <h1>Agenda de pacientes</h1>
    <form class="form-login" action="" method="post">
    <h2>Login</h2>

    <label for="username">Usuário: </label>
    <input type="text" name="username" id="username" required> <br>

    <label for="senha">Senha: </label>
    <input type="password" name="senha" id="senha" required> <br>

    <button type="submit">Entrar</button>

    <?php if(isset($erro)): ?>
    <span style="color: red; font-family: Helvetica;">
        <?php echo $erro; ?>
    </span>
<?php endif; ?>
</form>
</div>

</body>
</html>

