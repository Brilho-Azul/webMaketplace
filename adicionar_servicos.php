<?php
require_once 'conexao.php';

$nome = '';
$descricao = '';
$preco = '';
$fornecedor = '';
$erros = [];
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = floatval(str_replace(',', '.', $_POST['preco'] ?? '0'));
    $fornecedor = trim($_POST['fornecedor'] ?? '');

    if ($nome === '') {
        $erros[] = 'Nome é obrigatório.';
    }
    if ($preco <= 0) {
        $erros[] = 'Preço deve ser maior que zero.';
    }

    if (!$erros) {
        $stmt = $db->prepare("INSERT INTO servicos (nome, descricao, preco, fornecedor) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $descricao, $preco, $fornecedor]);

        $sucesso = "Serviço cadastrado com sucesso!";
        $nome = '';
        $descricao = '';
        $preco = '';
        $fornecedor = '';
    }
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Serviço</title>
    <link rel="stylesheet" href="css/form.css">
</head>
<body>

<header>
    <h1>Adicionar Serviço</h1>
    <a href="dashboard_gerente.php">
        <button>Voltar</button>
    </a>
</header>

<main>
    <div class="container">
        <h2>Novo Serviço</h2>

        <?php if ($sucesso): ?>
            <div class="message success"><?= htmlspecialchars($sucesso) ?></div>
        <?php endif; ?>

        <?php if ($erros): ?>
            <div class="message error">
                <ul>
                    <?php foreach ($erros as $erro): ?>
                        <li><?= htmlspecialchars($erro) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label>Nome</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($nome ?? '') ?>" required placeholder="Digite o nome do serviço">

            <label for="preco">Preço (R$):</label>
            <input type="text" id="preco" name="preco" value="<?= htmlspecialchars($preco) ?>" required pattern="^\d+(\,\d{1,2})?$" placeholder="0,00" />

            <label for="fornecedor">Fornecedor:</label>
            <input type="text" id="fornecedor" name="fornecedor" value="<?= htmlspecialchars($fornecedor) ?>" placeholder="Digite o nome do fornecedor" />
            
            <label>Descrição</label>
            <textarea name="descricao" rows="3" style="resize: none;"><?= htmlspecialchars($descricao ?? '') ?></textarea>



            <button type="submit" class="submit-btn">Cadastrar Serviço</button>
        </form>
    </div>
</main>
<script src="js/script.js"></script>
</body>
</html>
