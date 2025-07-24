<?php
session_start();
header('Content-Type: application/json');

$email = $_POST['email'] ?? '';
$senha = $_POST['password'] ?? '';

// Simulação (substituir com DB real)
if ($email === 'teste@exemplo.com' && $senha === '123456') {
    $_SESSION['user'] = $email;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Credenciais inválidas.']);
}
