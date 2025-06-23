<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'gerente') {
    header('Location: index.php');
    exit;
}

$nome = htmlspecialchars($_SESSION['usuario_nome']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Gerente</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<header>
    <h1>Gerenciar Produtos</h1>
    <div class="user-info">
        <span>Olá, <?= $nome ?>!</span>
        <button onclick="window.location.href='logout.php'">Sair</button>
    </div>
</header>

<main>
    <div class="dashboard-container">
        <h2>Painel do Gerente</h2>
        <div class="card-grid">
            <div class="card" onclick="window.location.href='adicionar_produtos.php'">
                <h3>Adicionar Produto</h3>
                <p>Cadastre novos produtos no sistema.</p>
            </div>

            <div class="card" onclick="window.location.href='adicionar_servicos.php'">
                <h3>Adicionar Serviços</h3>
                <p>Cadastre novos serviços no sistema .</p>
            </div>

            <div class="card" onclick="window.location.href='listar.php'">
                <h3>Visualizar Produtos</h3>
                <p>Veja todos os produtos cadastrados.</p>
            </div>

            <!-- <div class="card" onclick="window.location.href='editar.php'">
                <h3>Editar Produtos</h3>
                <p>Atualize informações dos produtos.</p>
            </div>

            <div class="card" onclick="window.location.href='excluir.php'">
                <h3>Excluir Produtos</h3>
                <p>Remova produtos do sistema.</p>
            </div> -->
        </div>
    </div>
</main>

<footer>
    &copy; <?= date('Y') ?> Sistema de Gestão. Todos os direitos reservados.
</footer>

</body>
</html>
