<?php

require_once 'conexao.php';

$tipo = $_GET['tipo'] ?? 'produto';
$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: listar.php");
    exit;
}

$erros = [];
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = floatval(str_replace(',', '.', $_POST['preco'] ?? '0'));
    $estoque = intval($_POST['estoque'] ?? 0);

    if ($nome === '') {
        $erros[] = 'Nome é obrigatório.';
    }
    if ($preco <= 0) {
        $erros[] = 'Preço deve ser maior que zero.';
    }
    if ($tipo === 'produto' && $estoque < 0) {
        $erros[] = 'Estoque não pode ser negativo.';
    }

    if (!$erros) {
        if ($tipo === 'produto') {
            $stmt = $db->prepare("UPDATE produtos SET nome = ?, descricao = ?, preco = ?, estoque = ? WHERE id = ?");
            $stmt->execute([$nome, $descricao, $preco, $estoque, $id]);
        } else {
            $stmt = $db->prepare("UPDATE servicos SET nome = ?, descricao = ?, preco = ? WHERE id = ?");
            $stmt->execute([$nome, $descricao, $preco, $id]);
        }
        $sucesso = ucfirst($tipo) . " atualizado com sucesso!";
    }
} else {
    if ($tipo === 'produto') {
        $stmt = $db->prepare("SELECT * FROM produtos WHERE id = ?");
    } else {
        $stmt = $db->prepare("SELECT * FROM servicos WHERE id = ?");
    }
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        header("Location: listar.php");
        exit;
    }

    $nome = $item['nome'];
    $descricao = $item['descricao'] ?? '';
    $preco = $item['preco'];
    $estoque = $item['estoque'] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar <?= ucfirst($tipo) ?></title>
    <link rel="stylesheet" href="css/form.css">
</head>
<body>

<header>
    <h1>Editar <?= ucfirst($tipo) ?></h1>
    <a href="listar.php">
        <button>Voltar</button>
    </a>
</header>

<main>
    <div class="container">
        <h2>Editar <?= ucfirst($tipo) ?></h2>

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
            <input type="text" name="nome" value="<?= htmlspecialchars($nome) ?>" required>

            <label>Descrição</label>
            <textarea name="descricao" rows="3"><?= htmlspecialchars($descricao) ?></textarea>

            <label>Preço (R$)</label>
            <input type="number" step="0.01" min="0" name="preco" value="<?= htmlspecialchars($preco) ?>" required>

            <?php if ($tipo === 'produto'): ?>
                <label>Estoque</label>
                <input type="number" min="0" name="estoque" value="<?= htmlspecialchars($estoque) ?>" required>
            <?php endif; ?>

            <button type="submit" class="submit-btn">Salvar Alterações</button>
        </form>
    </div>
</main>

</body>
</html>
