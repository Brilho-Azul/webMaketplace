<?php
require_once 'conexao.php';

$nome = '';
$descricao = '';
$preco = '';
$erros = [];
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = floatval(str_replace(',', '.', $_POST['preco'] ?? '0'));

    if ($nome === '') {
        $erros[] = 'Nome é obrigatório.';
    }
    if ($preco <= 0) {
        $erros[] = 'Preço deve ser maior que zero.';
    }

    if (!$erros) {
        $stmt = $db->prepare("INSERT INTO servicos (nome, descricao, preco) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $descricao, $preco]);

        $sucesso = "Serviço cadastrado com sucesso!";
        $nome = '';
        $descricao = '';
        $preco = '';
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
            <input type="text" name="nome" value="<?= htmlspecialchars($nome ?? '') ?>" required>

            <label>Descrição</label>
            <textarea name="descricao" rows="3"><?= htmlspecialchars($descricao ?? '') ?></textarea>

            <label>Preço (R$)</label>
            <input type="number" step="0.01" min="0" name="preco" value="<?= htmlspecialchars($preco ?? '') ?>" required>

            <button type="submit" class="submit-btn">Cadastrar Serviço</button>
        </form>
    </div>
</main>

</body>
</html>
