<?php
session_start();
require_once 'db.php'; 

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    //$_SESSION['old'] = $_POST;

    if (!$email || !$password) {
        $_SESSION['erro_login'] = 'Preencha todos os campos.';
        header('Location: ../login.php');
        exit;
    }

    $stmt = $conn->prepare("SELECT id, name, email, password, avatar FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id']     = $row['id'];
            $_SESSION['user_name']   = $row['name'];
            $_SESSION['user_email']  = $row['email'];
            $_SESSION['user_avatar'] = $row['avatar'];

            unset($_SESSION['erro_login']);
            //unset($_SESSION['old']);
            header("Location: ../index.php");
            exit;
        } else {
            $_SESSION['erro_login'] = 'É só digitar certo';
            header('Location: ../login.php');
            exit;
        }
    } else {
         $_SESSION['erro_login'] = 'É só digitar certo';
        header('Location: ../login.php');
        exit;
    }

    $conn->close();
}
?>
