<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['name'] ?? '';
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $avatar   = $_POST['avatar'] ?? '';

    if (!$name || !$email || !$password || !$avatar) {
        header('Location: ../index.php?erro=campos');
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, avatar) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Erro na preparação: " . $conn->error);
        }

        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $avatar);
        $stmt->execute();

        header('Location: ../html/login.html');
        exit;

    } catch (mysqli_sql_exception $e) {
        if (str_contains($e->getMessage(), 'Duplicate entry')) {
            header('Location: ../index.php?erro=email');
        } else {
            header('Location: ../index.php?erro=geral');
        }
        exit;
    }
}
?>
