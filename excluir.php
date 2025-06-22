<?php
require_once 'conexao.php';

$tipo = $_GET['tipo'] ?? null;
$id = $_GET['id'] ?? null;

if ($tipo && $id && is_numeric($id)) {
    if ($tipo === 'produto') {
        $stmt = $db->prepare("DELETE FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($tipo === 'servico') {
        $stmt = $db->prepare("DELETE FROM servicos WHERE id = ?");
        $stmt->execute([$id]);
    }
}

// Redireciona de volta para a lista
header('Location: listar.php');
exit;
?>