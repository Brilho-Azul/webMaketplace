<?php
session_start();
require 'conexao.php';

// Verifica se cliente está logado
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'cliente') {
    header('Location: index.php');
    exit;
}

try {
    // Certifica que a coluna ativo existe (executa só uma vez, ou remova depois)
    $db->exec("ALTER TABLE servicos ADD COLUMN ativo INTEGER DEFAULT 1");
} catch (PDOException $e) {
    // ignora erro se já existir a coluna
}

try {
    $query = $db->query("SELECT * FROM servicos WHERE ativo = 1 ORDER BY nome");
    $servicos = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar serviços: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Serviços para solicitar</title>
    <link rel="stylesheet" href="css/dashboard.css" />
</head>
<body>

<header>
    <h1>Serviços disponíveis</h1>
    <div class="user-info">
        Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>! 
        <button onclick="window.location.href='dashboard_cliente.php'">Voltar</button>
    </div>
</header>

<main>
  <div class="dashboard-produtos">
    <h2>Serviços Disponíveis</h2>
    <?php if (count($servicos) > 0): ?>
      <div class="produtos-grid">
        <?php foreach ($servicos as $servico): ?>
          <div class="produto-card">
            <h3><?= htmlspecialchars($servico['nome']) ?></h3>
            <p><?= htmlspecialchars($servico['descricao']) ?></p>
            <p class="preco">R$ <?= number_format($servico['preco'], 2, ',', '.') ?></p>
            <button class="btn-comprar" data-id="<?= $servico['id'] ?>">Solicitar</button>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p>Nenhum serviço disponível no momento.</p>
    <?php endif; ?>
  </div>
</main>
