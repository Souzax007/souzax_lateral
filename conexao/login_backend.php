<?php
   session_start();

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $email = $_POST["email"];
    $password = $_POST["password"];
   
  $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();

  $result = $stmt->get_result();

      if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();


        if ($password === $row['password']) {
            $_SESSION['email'] = $email; 
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $row['name'];
            echo "Usuário logado com sucesso!";
                header("Location: ../app/dashboard.php");
            exit;

        } else {
            $_SESSION['erro_login'] = "senha incorreta.";
            header("Location: ../app/login.php");
            exit;
        }
    } else {
        $_SESSION['erro_login'] = "Usuário não encontrado.";
        header("Location: ../app/login.php");
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>
