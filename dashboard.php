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

if(!isset($_SESSION["logado"])){
    header("Location: index.php");

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
<div class="corpo-dash">
    <div class="cabecalho">
        <div class="cabecalho-1">
            <h1>Pacientes</h1>
        </div>
        <div class="cabecalho-2">
            <a href="logout.php">Sair</a>
        </div>    

    </div>
        <form class="form-cadastro" method="post">
            <div class="teste">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" placeholder="nome" required>
            </div>
            <div>
                <label for="data_agendamento">Data:</label>
                <input type="date" name="data_agendamento" id="" required>
            </div>    

            <div>
                <label for="horario">Horario:</label>
                <input type="text" name="horario" placeholder="horario" required>
            </div>    

            <div>
                <label for="convenio">Convenio:</label>
                  <select name="convenio" required>
                    <option value="">Selecione</option>
                    <option value="unimed">Unimed</option>
                    <option value="amil">Amil</option>
                    <option value="bradesco">Bradesco Saúde</option>
                    <option value="sulamerica">SulAmérica</option>
                    <option value="notredame">NotreDame</option>
                    <option value="particular">Particular</option>
                </select>
            </div>    


              

            <div>
                <button type="submit" name="cadastrar">Cadastrar</button>
            </div>
        

        
        </form>

    

<div class="lista-pacientes">

    <div class="paciente paciente-header">
        <div>Nome</div>
        <div>Data</div>
        <div>Horário</div>
        <div>Convênio</div>
    </div>

    <?php foreach($pessoas as $pessoa): ?>
        <div class="paciente">
            <div><?= $pessoa["nome"] ?></div>
            <div><?= $pessoa["data_agendamento"] ?></div>
            <div><?= $pessoa["horario"] ?></div>
            <div><?= $pessoa["convenio"] ?></div>
        </div>
    <?php endforeach ?>

</div>

</div>

</body>
</html>

