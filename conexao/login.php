<?php
session_start();
require_once 'db.php'; // Aqui $mysqli já existe e está conectado

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $mysqli->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];

        header("Location: ../index.php");
        exit;
    } else {
        echo "Senha incorreta";
    }
} else {
    echo "Usuário não encontrado";
}

$mysqli->close();


?>