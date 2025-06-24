<?php

require_once 'conexao.php';

$erros = [];
$sucesso = '';

$nome = '';
$descricao = '';
$preco = '';
$estoque = 0;
$marca = '';
$fabricante = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $marca = trim($_POST['marca'] ?? '');
    $fabricante = trim($_POST['fabricante'] ?? '');

    $preco_str = str_replace(',', '.', $_POST['preco'] ?? '0');
    $preco = floatval($preco_str);

    $estoque = intval($_POST['estoque'] ?? 0);

    if ($nome === '') {
        $erros[] = 'Nome é obrigatório.';
    }
    if ($preco <= 0) {
        $erros[] = 'Preço deve ser maior que zero.';
    }
    if ($estoque < 0) {
        $erros[] = 'Estoque não pode ser negativo.';
    }

    if (!$erros) {
        $stmt = $db->prepare("INSERT INTO produtos (nome, descricao, preco, estoque, marca, fabricante) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $descricao, $preco, $estoque, $marca, $fabricante]);

        $sucesso = "Produto adicionado com sucesso!";
        $nome = '';
        $descricao = '';
        $preco = '';
        $estoque = 0;
        $marca = '';
        $fabricante = '';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Adicionar Produto</title>
  <link rel="stylesheet" href="css/form.css" />
</head>
<body>
<header>
  <h1>Adicionar Produto</h1>
  <button onclick="window.location.href='dashboard_gerente.php'">Voltar</button>
</header>

<main>
  <div class="container">
    <?php if ($erros): ?>
      <div class="message error">
        <ul>
          <?php foreach ($erros as $erro): ?>
            <li><?= htmlspecialchars($erro) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php elseif ($sucesso): ?>
      <div class="message success"><?= htmlspecialchars($sucesso) ?></div>
    <?php endif; ?>

    <form method="POST">
      <label for="nome">Nome do Produto:</label>
      <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($nome) ?>" required placeholder="Digite o nome do produto"/>

      <label for="preco">Preço (R$):</label>
      <input type="text" id="preco" name="preco" value="<?= htmlspecialchars($preco) ?>" required pattern="^\d+(\,\d{1,2})?$" placeholder="0,00" />

      <label for="estoque">Estoque:</label>
      <input type="number" id="estoque" name="estoque" value="<?= htmlspecialchars($estoque) ?>" min="0"/>

      <label for="marca">Marca:</label>
      <input type="text" id="marca" name="marca" value="<?= htmlspecialchars($marca) ?>" placeholder="Digite a marca do produto" />

      <label for="fabricante">Fabricante:</label>
      <input type="text" id="fabricante" name="fabricante" value="<?= htmlspecialchars($fabricante) ?>" placeholder="Digite o nome do fabricante" />

      <label for="descricao">Descrição:</label>
      <textarea id="descricao" name="descricao" rows="4" style="resize: none;"><?= htmlspecialchars($descricao) ?></textarea>

      <button type="submit" class="submit-btn">Cadastrar Produto</button>
    </form>
  </div>
</main>
<script src="js/script.js"></script>
</body>
</html>

