<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name     = $_POST['name'] ?? '';
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $avatar   = $_POST['avatar'] ?? '';

    //verifica se o email já está cadastrado
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();


    $userExiste = ($result->num_rows > 0) ? true : false; 

    //insere o novo usuário no banco de dados
    if(!$userExiste) { 
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, avatar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $avatar);
        $stmt->execute();
    
        //verifica se a inserção foi bem-sucedida
        if ($stmt->affected_rows > 0) {

            $_SESSION['success_registro'] = 'Usuário cadastrado com sucesso!';
        echo"teste ";
            exit;
        } else {

            $_SESSION['erro_registro'] = 'Erro ao cadastrar usuário. Tente novamente.';
            echo"Erro ao cadastrar usuário. Tente novamente.";
            exit;
        }
    }
}

?>
<script>
    var user_existe = <?php echo $userExiste; ?>;
    document.addEventListener('DOMContentLoaded', function() {
          
        if (user_existe) {
           // header('Location: ./app/registrar.php');
            //alert('Email já cadastrado. Por favor, tente outro.');
   
            const url = '../app/registrar.php';
            fetch(url)
            .then(res => res.text())
            .then(html => {
            document.getElementById("conteudoMain").innerHTML = html;

            })
            .catch(err => console.error('Erro ao carregar tela:', err));
        } else {
            alert('Usuário cadastrado com sucesso!');
            //window.location.href = '../app/registrar.php';
        }
    });
</script>