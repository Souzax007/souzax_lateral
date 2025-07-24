<?php
session_start();
$logado = isset($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Minha App</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="assets/js/main.js"></script>
</head>
<body>

  <!-- Menu -->
  <nav>
    <img src="assets/img/avatar.png" id="menu-avatar" alt="Perfil" style="cursor: pointer; width: 40px;">
    
    <?php if ($logado): ?>
      <a href="logout.php" id="logout">Sair</a>
    <?php endif; ?>
  </nav>

  <!-- Conteúdo dinâmico -->
  <div id="auth-container">
    <!-- Aqui será carregado login.php, perfil.php, registrar.php etc -->
  </div>

</body>
</html>
