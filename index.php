<?php
session_start();
require 'conexao.php';

function respond_json($success, $message, $redirect = null) {
    header('Content-Type: application/json');
    echo json_encode(['success' => $success, 'message' => $message, 'redirect' => $redirect]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['form_type'])) {
        $form_type = $_POST['form_type'];

        if ($form_type === 'login') {
            $email = trim($_POST['email'] ?? '');
            $senha = $_POST['password'] ?? '';

            if (!$email || !$senha) {
                respond_json(false, 'Preencha todos os campos.');
            }

            $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_tipo'] = $usuario['usuario_tipo']; // assume que tem coluna 'tipo' = 'cliente' ou 'gerente'

                // Redirecionamento conforme tipo
                if ($usuario['usuario_tipo'] === 'gerente') {
                    respond_json(true, 'Login realizado com sucesso! Redirecionando para dashboard do gerente...', 'dashboard_gerente.php');
                } else {
                    respond_json(true, 'Login realizado com sucesso! Redirecionando para dashboard do cliente...', 'dashboard_cliente.php');
                }
            } else {
                respond_json(false, 'Email ou senha incorretos.');
            }

        } elseif ($form_type === 'signup') {
            // Cadastro só para clientes
            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $senha = $_POST['password'] ?? '';

            if (!$nome || !$email || !$senha) {
                respond_json(false, 'Preencha todos os campos.');
            }

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            try {
                // Aqui sempre insere tipo 'cliente'
                $stmt = $db->prepare("INSERT INTO usuarios (nome, email, senha, usuario_tipo) VALUES (?, ?, ?, 'cliente')");
                $stmt->execute([$nome, $email, $senhaHash]);
                respond_json(true, 'Cadastro realizado com sucesso! Faça login para continuar.');
            } catch (PDOException $e) {
                if ($e->getCode() == '23000') {
                    respond_json(false, 'Email já cadastrado.');
                } else {
                    respond_json(false, 'Erro: ' . $e->getMessage());
                }
            }
        } else {
            respond_json(false, 'Ação inválida.');
        }
    } else {
        respond_json(false, 'Ação não especificada.');
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Brilho Azul</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-toggle">
                <button id="login-toggle" class="active">Login</button>
                <button id="signup-toggle">Cadastro</button>
            </div>

            <form id="login-form" class="form" method="post" action="index.php">
                <h2>Login</h2>
                <input type="email" name="email" placeholder="Email" required />
                <div class="password-wrapper">
                    <input type="password" id="login_password" name="password" placeholder="Senha" required />
                    <span class="toggle-password" toggle="#login_password">&#128065;</span>
                </div>
                <input type="hidden" name="form_type" value="login" />
                <button type="submit">Entrar</button>
            </form>

            <form id="signup-form" class="form" style="display:none;" method="post" action="index.php">
                <h2>Cadastro</h2>
                <input type="text" name="nome" placeholder="Nome" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="email" name="confirm_email" placeholder="Confirmar Email" required />

                <div class="password-wrapper">
                    <input type="password" id="signup_password" name="password" placeholder="Senha" required />
                    <span class="toggle-password" toggle="#signup_password">&#128065;</span>
                </div>

                <div class="password-wrapper">
                    <input type="password" id="signup_confirm_password" name="confirm_password" placeholder="Confirmar Senha" required />
                    <span class="toggle-password" toggle="#signup_confirm_password">&#128065;</span>
                </div>

                <input type="hidden" name="form_type" value="signup" />
                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
