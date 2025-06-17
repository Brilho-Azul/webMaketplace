<?php
$db = new PDO('sqlite:' . __DIR__ . '/banco.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Aqui para deletar algum produto
$id = $_GET['id'] ?? null;
if ($id && is_numeric($id)) {
    $stmt = $db->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
}

// Aqui para deletar algum produto
$id = $_GET['id'] ?? null;
if ($id && is_numeric($id)) {
    $stmt = $db->prepare("DELETE FROM servicos WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: listar.php');
exit;
