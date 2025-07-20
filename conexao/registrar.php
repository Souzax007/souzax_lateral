<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start(); // Inicia a sessão

require 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['name'] ?? '';
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $avatar   = $_POST['avatar'] ?? '';

    if (!$name || !$email || !$password || !$avatar) {
        $_SESSION['erro'] = 'campos';
        header('Location: ../index.php');
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        if (!isset($conn)) {
            throw new Exception("Conexão com banco de dados não estabelecida.");
        }

        $stmt = $conn->prepare("INSERT INTO users (name, email, password, avatar) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Erro na preparação: " . $conn->error);
        }

        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $avatar);
        $stmt->execute();

        // Registro OK, limpa erros e redireciona
        unset($_SESSION['erro']);
        header('Location: ../app/login.php');
        exit;

    } catch (mysqli_sql_exception $e) {
        if (str_contains($e->getMessage(), 'Duplicate entry')) {
            $_SESSION['erro'] = 'email';
        } else {
            $_SESSION['erro'] = 'geral';
        }
        header('Location: ../index.php');
        exit;
    } catch (Exception $e) {
        $_SESSION['erro'] = 'geral';
        header('Location: ../index.php');
        exit;
    }
}
?>
