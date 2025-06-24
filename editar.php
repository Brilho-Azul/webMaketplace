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

$nome = '';
$descricao = '';
$preco = '';
$estoque = 0;
$marca = '';
$fabricante = '';
$fornecedor = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = floatval(str_replace(',', '.', $_POST['preco'] ?? '0'));

    if ($tipo === 'produto') {
        $estoque = intval($_POST['estoque'] ?? 0);
        $marca = trim($_POST['marca'] ?? '');
        $fabricante = trim($_POST['fabricante'] ?? '');
    } else {
        $fornecedor = trim($_POST['fornecedor'] ?? '');
    }

    // Validações
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
            $stmt = $db->prepare("UPDATE produtos SET nome = ?, descricao = ?, preco = ?, estoque = ?, marca = ?, fabricante = ? WHERE id = ?");
            $stmt->execute([$nome, $descricao, $preco, $estoque, $marca, $fabricante, $id]);
        } else {
            $stmt = $db->prepare("UPDATE servicos SET nome = ?, descricao = ?, preco = ?, fornecedor = ? WHERE id = ?");
            $stmt->execute([$nome, $descricao, $preco, $fornecedor, $id]);
        }

        $sucesso = ucfirst($tipo) . " atualizado com sucesso!";
    }
} else {
    // Carrega dados do item
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
    $preco = number_format($item['preco'], 2, ',', '');

    if ($tipo === 'produto') {
        $estoque = $item['estoque'] ?? 0;
        $marca = $item['marca'] ?? '';
        $fabricante = $item['fabricante'] ?? '';
    } else {
        $fornecedor = $item['fornecedor'] ?? '';
    }
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
            <label>Nome:</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($nome) ?>" required>

            <label>Preço (R$):</label>
            <input type="text" id="preco" name="preco" value="<?= htmlspecialchars($preco) ?>" required pattern="^\d+(\,\d{1,2})?$" placeholder="0,00" />

            <?php if ($tipo === 'produto'): ?>
                <label>Estoque:</label>
                <input type="number" name="estoque" value="<?= htmlspecialchars($estoque) ?>" min="0" required>

                <label>Marca:</label>
                <input type="text" name="marca" value="<?= htmlspecialchars($marca) ?>" placeholder="Digite a marca">

                <label>Fabricante:</label>
                <input type="text" name="fabricante" value="<?= htmlspecialchars($fabricante) ?>" placeholder="Digite o fabricante">
            <?php else: ?>
                <label>Fornecedor:</label>
                <input type="text" name="fornecedor" value="<?= htmlspecialchars($fornecedor) ?>" placeholder="Digite o fornecedor">
            <?php endif; ?>

            <label>Descrição:</label>
            <textarea name="descricao" rows="3" style="resize: none;"><?= htmlspecialchars($descricao) ?></textarea>

            <button type="submit" class="submit-btn">Salvar Alterações</button>
        </form>
    </div>
</main>

<script src="js/script.js"></script>

</body>
</html>
