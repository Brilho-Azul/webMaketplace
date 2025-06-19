<?php
// Adciona produtos
try {
    $db = new PDO('sqlite:' . __DIR__ . '/banco.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
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
    if ($estoque < 0) {
        $erros[] = 'Estoque não pode ser negativo.';
    }

    if (!$erros) {
        $stmt = $db->prepare("INSERT INTO produtos (nome, descricao, preco, estoque) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $descricao, $preco, $estoque]);

        $sucesso = "Produto adicionado com sucesso!";
        $nome = $descricao = '';
        $preco = $estoque = 0;
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
            <li><?=htmlspecialchars($erro)?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php elseif ($sucesso): ?>
      <div class="message success"><?=htmlspecialchars($sucesso)?></div>
    <?php endif; ?>

    <form method="POST">
      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" value="<?=htmlspecialchars($nome ?? '')?>" required />

      <label for="descricao">Descrição:</label>
      <textarea id="descricao" name="descricao" rows="4"><?=htmlspecialchars($descricao ?? '')?></textarea>

      <label for="preco">Preço (R$):</label>
      <input type="text" id="preco" name="preco" value="<?=htmlspecialchars($preco ?? '')?>" required pattern="^\d+(\,\d{1,2})?$" placeholder="0,00" />

      <label for="estoque">Estoque:</label>
      <input type="number" id="estoque" name="estoque" value="<?=htmlspecialchars($estoque ?? '0')?>" min="0" />

      <button type="submit" class="submit-btn">Adicionar Produto</button>
    </form>
  </div>
</main>
</body>
</html>
