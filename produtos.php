<?php
session_start();
require 'conexao.php';

// Verifica se cliente está logado
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'cliente') {
    header('Location: index.php');
    exit;
}

try {
    $query = $db->query("SELECT * FROM produtos WHERE estoque > 0 ORDER BY nome");
    $produtos = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar produtos: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Produtos para compra</title>
    <link rel="stylesheet" href="css/dashboard.css" />
</head>
<body>

<header>
    <h1>Produtos disponíveis</h1>
    <div class="user-info">
        Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>! 
        <button onclick="window.location.href='dashboard_cliente.php'">Voltar</button>
    </div>
</header>

<main>
  <div class="dashboard-produtos">
    <h2>Produtos Disponíveis</h2>
    <?php if (count($produtos) > 0): ?>
      <div class="produtos-grid">
        <?php foreach ($produtos as $produto): ?>
          <div class="produto-card">
            <h3><?= htmlspecialchars($produto['nome']) ?></h3>
            <p><?= htmlspecialchars($produto['descricao']) ?></p>
            <p class="preco">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
            <button class="btn-comprar" data-id="<?= $produto['id'] ?>">Comprar</button>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p>Nenhum produto disponível no momento.</p>
    <?php endif; ?>
  </div>
</main>

</body>
</html>
