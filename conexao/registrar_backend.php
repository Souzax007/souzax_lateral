<?php

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

  echo "Nome: " . htmlspecialchars($name) . "<br>";
  echo "Email: " . htmlspecialchars($email) . "<br>";
  echo "password: " . htmlspecialchars($password) . "<br>";

  $sql = "INSERT INTO users (name, email, password) VALUES ('$nome', '$email' , '$password')";

  if ($conn->query($sql) === TRUE) {
    echo "usuario cadastrado com sucesso";
  } else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
  }

}
?>