<?php
session_start();
require '../conexao/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Usuário não logado.";
    exit;
}

if (isset($_POST['avatar'])) {
    $novoAvatar = $_POST['avatar'];
    $userId = $_SESSION['user_id'];

    $stmt = $conn->prepare("UPDATE users SET avatar = ? WHERE id = ?");
    $stmt->bind_param("si", $novoAvatar, $userId);

    if ($stmt->execute()) {
        echo "Avatar atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o avatar.";
    }
} else {
    echo "Avatar não fornecido.";
}
