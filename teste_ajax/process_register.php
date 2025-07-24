<?php
header('Content-Type: application/json');

$email = $_POST['email'] ?? '';
$senha = $_POST['password'] ?? '';
$nome  = $_POST['nome'] ?? '';

// Simulação de erro
if ($email === 'teste@exemplo.com') {
    echo json_encode(['success' => false, 'message' => 'Email já registrado.']);
} else {
    // Simular sucesso
    echo json_encode(['success' => true]);
}
