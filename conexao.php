<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'banco_brilho_azul';

try {
    // Conecta no servidor MySQL (sem banco ainda)
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cria o banco se não existir
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

} catch (PDOException $e) {
    die("Erro ao criar banco: " . $e->getMessage());
}

// Agora conecta no banco
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cria as tabelas
    $db->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        usuario_tipo VARCHAR(50) NOT NULL DEFAULT 'cliente'
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS produtos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        descricao TEXT,
        preco DECIMAL(10,2) NOT NULL,
        estoque INT DEFAULT 0,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS servicos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        descricao TEXT,
        preco DECIMAL(10,2) NOT NULL,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Adiciona colunas se ainda não existirem
    $colunasProdutos = $db->query("SHOW COLUMNS FROM produtos")->fetchAll(PDO::FETCH_COLUMN);
    if (!in_array('marca', $colunasProdutos)) {
        $db->exec("ALTER TABLE produtos ADD COLUMN marca VARCHAR(100) DEFAULT NULL");
    }
    if (!in_array('fabricante', $colunasProdutos)) {
        $db->exec("ALTER TABLE produtos ADD COLUMN fabricante VARCHAR(100) DEFAULT NULL");
    }

    $colunasServicos = $db->query("SHOW COLUMNS FROM servicos")->fetchAll(PDO::FETCH_COLUMN);
    if (!in_array('fornecedor', $colunasServicos)) {
        $db->exec("ALTER TABLE servicos ADD COLUMN fornecedor VARCHAR(100) DEFAULT NULL");
    }

    // Criação do usuário gerente padrão
    $nome = 'Gerente';
    $email = 'gerente@admin.com';
    $senha = password_hash('gerente123', PASSWORD_DEFAULT);
    $usuario_tipo = 'gerente';

    $verifica = $db->prepare("SELECT * FROM usuarios WHERE email = :email");
    $verifica->bindParam(':email', $email);
    $verifica->execute();

    if ($verifica->rowCount() == 0) {
        $stmt = $db->prepare("INSERT INTO usuarios (nome, email, senha, usuario_tipo) VALUES (:nome, :email, :senha, :usuario_tipo)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':usuario_tipo', $usuario_tipo);
        $stmt->execute();
    }

} catch (PDOException $e) {
    die("Erro na conexão com o banco: " . $e->getMessage());
}
?>