<?php

require 'conexao.php';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $produtos = $db->query("SELECT * FROM produtos ORDER BY criado_em DESC")->fetchAll(PDO::FETCH_ASSOC);
    $servicos = $db->query("SELECT * FROM servicos ORDER BY criado_em DESC")->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Produtos e Serviços</title>
  <link rel="stylesheet" href="css/form.css" />
</head>
<body>
<header>
  <h1>Gerenciar Produtos & Serviços</h1>
  <button onclick="window.location.href='dashboard_gerente.php'">Voltar</button>
</header>

<main>
  <div class="container">
    <h2>Produtos</h2>
    <?php if(count($produtos) === 0): ?>
      <p>Nenhum produto cadastrado.</p>
    <?php else: ?>
      <div class="card-grid">
        <?php foreach($produtos as $produto): ?>
          <div class="card">
            <h3><?=htmlspecialchars($produto['nome'])?></h3>
            <p><?=nl2br(htmlspecialchars($produto['descricao']))?></p>
            <small>Preço: R$ <?=number_format($produto['preco'], 2, ',', '.')?></small><br/>
            <small>Estoque: <?=intval($produto['estoque'])?></small>
            <div class="btn-group">
              <button class="btn edit" onclick="window.location.href='editar.php?tipo=produto&id=<?=$produto['id']?>'">Editar</button>
              <button class="btn delete" onclick="if(confirm('Excluir este produto?')) window.location.href='excluir.php?tipo=produto&id=<?=$produto['id']?>'">Excluir</button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <h2 style="margin-top: 60px;">Serviços</h2>
    <?php if(count($servicos) === 0): ?>
      <p>Nenhum serviço cadastrado.</p>
    <?php else: ?>
      <div class="card-grid">
        <?php foreach($servicos as $servico): ?>
          <div class="card">
            <h3><?=htmlspecialchars($servico['nome'])?></h3>
            <p><?=nl2br(htmlspecialchars($servico['descricao']))?></p>
            <small>Preço: R$ <?=number_format($servico['preco'], 2, ',', '.')?></small>
            <div class="btn-group">
              <button class="btn edit" onclick="window.location.href='editar.php?tipo=servico&id=<?=$servico['id']?>'">Editar</button>
              <button class="btn delete" onclick="if(confirm('Excluir este serviço?')) window.location.href='excluir.php?tipo=servico&id=<?=$servico['id']?>'">Excluir</button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</main>
</body>
</html>
