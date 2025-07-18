<?php
session_start();
require '../conexao/db.php';  // Conectar ao banco de dados

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo "Usuário não logado.";
    exit;
}

// Verificar se o novo avatar foi passado via POST
if (isset($_POST['avatar'])) {
    $novoAvatar = $_POST['avatar'];
    $userId = $_SESSION['user_id'];

    // Atualizar o avatar no banco de dados
    $stmt = $mysqli->prepare("UPDATE users SET avatar = ? WHERE id = ?");
    $stmt->bind_param("si", $novoAvatar, $userId);

    // Verificar se a atualização foi bem-sucedida
    if ($stmt->execute()) {
        echo "Avatar atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o avatar.";
    }
} else {
    echo "Avatar não fornecido.";
}
?>
