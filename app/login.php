<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/login.css">
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <form action="../conexao/login_backend.php" method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Senha" required>
      <?php
        session_start();
      if (isset($_SESSION['erro_login'])) {
            echo '<div class="erro">'.htmlspecialchars($_SESSION['erro_login']).'</div>';
            unset($_SESSION['erro_login']);}
      ?>
      <div class="submit_btn">
        <button type="submit">Entrar</button>
        <a href="../app/registrar.php" id="link-registrar">Registrar</a>
      </div>
    </form>
  </div>
</body>
</html>
