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

    $stmt = $pdo->prepare("INSERT INTO pessoas (nome, data_agendamento, horario, valor, convenio) VALUES (?, ?, ?, ?, ?)");

    if($stmt->execute([
        $_POST["nome"],
        $_POST["data_agendamento"],
        $_POST["horario"],
        $_POST["valor"],
        $_POST["convenio"]
    ])) {
        header("Location: dashboard.php?sucesso=1");
        exit;
    }
}

$pessoas = $pdo->query("SELECT * FROM pessoas")->fetchAll();


?>
<div class="corpo-dash">
    <div class="cabecalho">
        <div class="cabecalho-1">
            <h1>Agenda </h1>
        </div>
        <div class="cabecalho-2">
            <a href="logout.php"><button class="btn-sair">Sair</button></a>            
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
                <input type="time" name="horario" placeholder="horario" required>
            </div>  
            
            <div>
                <label for="valor">Valor: </label>
                <input type="number" name="valor" id="" step="0.01" min="0" placeholder="R$00,00">
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
        <?php if(isset($_GET["sucesso"])): ?>
            <span class="msg-sucesso">Paciente cadastrado com sucesso!</span>

        <?php endif; ?>

        <h3>Lista de pacientes</h3>

<div class="lista-pacientes">

    <div class="paciente paciente-header">
        <div>Nome</div>
        <div>Data</div>
        <div>Horário</div>
        <div>Valor</div>
        <div>Convênio</div>
        <div>Ações</div>
    </div>
            <?php $total = 0; ?>
    <?php foreach($pessoas as $pessoa): ?>
        <div class="paciente">
            <div><?= htmlspecialchars($pessoa["nome"]) ?></div>
            <div><?= date("d/m/Y", strtotime($pessoa["data_agendamento"])) ?></div>
            <div><?= htmlspecialchars($pessoa["horario"]) ?></div>
            <div><?= number_format($pessoa["valor"],2,",",".") ?></div>
            <div><?= htmlspecialchars($pessoa["convenio"]) ?></div>
            <?php $total += (int)$pessoa["valor"];?> 
            <div class="acoes">
                <a href="editar.php?id=<?= $pessoa["id"] ?>">
                    <button class="btn-editar">Editar</button>
                </a>

                <a href="excluir.php?id=<?= $pessoa["id"] ?>">
                    <button class="btn-excluir">Excluir</button>
                </a>
            </div>
        </div>
    <?php endforeach ?>


</div>
    <p>O TOTAL É <?= $total; ?></p>
</div>

</body>
</html>

