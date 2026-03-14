<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar paciente</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<?php

session_start();
require "db.php";

if(!isset($_SESSION["logado"])){
    header("Location: index.php");
    exit;
}

$id = $_GET["id"];

$stmt = $pdo->prepare("SELECT * FROM pessoas WHERE id = ?");
$stmt->execute([$id]);

$pessoa = $stmt->fetch(); // fetch em vez de fetchAll

if(!$pessoa){
    echo "Paciente não encontrado!";
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $stmt = $pdo->prepare("
        UPDATE pessoas 
        SET nome = ?, data_agendamento = ?, horario = ?, valor = ?, convenio = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $_POST["nome"],
        $_POST["data_agendamento"],
        $_POST["horario"],
        $_POST["valor"],
        $_POST["convenio"],
        $id
    ]);

    header("Location: dashboard.php?editado=1");
    exit;
}

?>

<div class="corpo-dash">

    <div class="cabecalho">

        <div class="cabecalho-1">
            <h1>Editar paciente</h1>
        </div>

        <div class="cabecalho-2">
            <a href="dashboard.php">
                <button class="btn-sair">Voltar</button>
            </a>
        </div>

    </div>

<form class="form-cadastro" method="post">

    <div>
        <label>Nome:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($pessoa["nome"]) ?>" required>
    </div>

    <div>
        <label>Data:</label>
        <input type="date" name="data_agendamento" value="<?= $pessoa["data_agendamento"] ?>" required>
    </div>

    <div>
        <label>Horário:</label>
        <input type="time" name="horario" value="<?= $pessoa["horario"] ?>" required>
    </div>

    <div>
        <label>Valor:</label>
        <input type="number" name="valor" step="0.01" min="0" value="<?= $pessoa["valor"] ?>">
    </div>

    <div>
        <label>Convênio:</label>

        <select name="convenio" required>

            <option value="">Selecione</option>

            <option value="unimed" <?= $pessoa["convenio"] == "unimed" ? "selected" : "" ?>>Unimed</option>

            <option value="amil" <?= $pessoa["convenio"] == "amil" ? "selected" : "" ?>>Amil</option>

            <option value="bradesco" <?= $pessoa["convenio"] == "bradesco" ? "selected" : "" ?>>Bradesco Saúde</option>

            <option value="sulamerica" <?= $pessoa["convenio"] == "sulamerica" ? "selected" : "" ?>>SulAmérica</option>

            <option value="notredame" <?= $pessoa["convenio"] == "notredame" ? "selected" : "" ?>>NotreDame</option>

            <option value="particular" <?= $pessoa["convenio"] == "particular" ? "selected" : "" ?>>Particular</option>

        </select>

    </div>

    <div>
        <button type="submit">Salvar alterações</button>
    </div>

</form>

</div>

</body>
</html>