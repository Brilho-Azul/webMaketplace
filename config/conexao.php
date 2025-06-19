<?php
try {
    $db = new PDO('sqlite:' . __DIR__ . '/banco.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Aqui cria as tabelas, caso não existe, e a chama de banco.db
    $db->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        senha TEXT NOT NULL,
        usuario_tipo TEXT NOT NULL DEFAULT 'cliente' 
    )");

    
    $db->exec("CREATE TABLE IF NOT EXISTS produtos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        descricao TEXT,
        preco REAL NOT NULL,
        estoque INTEGER DEFAULT 0,
        criado_em DATETIME DEFAULT (datetime('now'))
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS servicos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        descricao TEXT,
        preco REAL NOT NULL,
        criado_em DATETIME DEFAULT (datetime('now'))
    )");

} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit;
}
?>
