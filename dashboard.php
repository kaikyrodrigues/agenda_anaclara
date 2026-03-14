<?php
session_start();

require "db.php";

if(!isset($_SESSION["logado"])){
    header("Location: login.php");

    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cadastrar"])){

    $stmt = $pdo->prepare("INSERT INTO pessoas (nome, data_agendamento, horario, convenio) VALUES (?, ?, ?, ?)");

    if($stmt->execute([
        $_POST["nome"],
        $_POST["data_agendamento"],
        $_POST["horario"],
        $_POST["convenio"]
    ])) {
        echo "Paciente cadastrado com sucesso!";
    }
}

$pessoas = $pdo->query("SELECT * FROM pessoas")->fetchAll();


?>

<h1>Pacientes</h1>
<a href="logout.php">Sair</a>

<form action="" method="post">
    <input type="text" name="nome" placeholder="nome" required>
    <input type="date" name="data_agendamento" id="" required>
    <input type="text" name="horario" placeholder="horario" required>


    <select name="convenio" required>
        <option value="">Selecione o convênio</option>
        <option value="unimed">Unimed</option>
        <option value="amil">Amil</option>
        <option value="bradesco">Bradesco Saúde</option>
        <option value="sulamerica">SulAmérica</option>
        <option value="notredame">NotreDame</option>
        <option value="particular">Particular</option>
    </select>

    <button type="submit" name="cadastrar">Cadastrar</button>
</form>

<div>
    <?php foreach($pessoas as $pessoa): ?>
        <div>
            <?= $pessoa["nome"] ?>
            <?= $pessoa["data_agendamento"] ?>
            <?= $pessoa["horario"] ?>
            <?= $pessoa["convenio"] ?>
        </div>
    <?php endforeach ?>    
</div>