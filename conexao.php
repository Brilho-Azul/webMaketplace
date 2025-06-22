<?php
$host = 'localhost';
$dbname = 'banco_brilho_azul';
$user = 'root';
$pass = '';

// Caso o banco não exista, ele tenta criar um banco e coloca as tabelas.

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


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

    // Professor, acesse essa conta para utilizar os fundamentos do CRUD
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

    } else {

    }

} catch (PDOException $e) {
    echo "<script>console.error('❌ Erro na conexão: " . addslashes($e->getMessage()) . "');</script>";
    exit;
}
?>
