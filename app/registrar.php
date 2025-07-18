<?php

// Lista de avatares disponíveis
$avatarFolder = '../avatars/';
$avatars = array_diff(scandir($avatarFolder), array('.', '..'));
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Registro</title>
  <style>
    .form {
      width: 300px;
      margin: auto;
      padding: 20px;
      border-radius: 10px;
      background: #f9f9f9;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      font-family: Arial, sans-serif;
      text-align: center;
    }

    .form img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      margin-bottom: 10px;
    }

    #previewAvatar {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50px;
    }

    .form h3, .form h2 {
      margin-bottom: 20px;
      color: #333;
    }

    .form label {
      display: block;
      text-align: left;
      margin: 10px 0 5px;
      color: #444;
    }

    .form input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .form button {
      width: 100%;
      padding: 10px;
      margin-top: 15px;
      border: none;
      border-radius: 5px;
      background: #3498db;
      color: white;
      font-size: 16px;
      cursor: pointer;
    }

    .form button:hover {
      background: #2980b9;
    }

    .form .register-btn {
      background: #2ecc71;
    }

    .form .register-btn:hover {
      background: #27ae60;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
      background-color: #fff;
      margin: 10% auto;
      padding: 20px;
      width: 60%;
      max-width: 500px;
      border-radius: 10px;
    }

    .close {
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .avatar-option {
      display: inline-block;
      margin: 10px;
      cursor: pointer;
      border: 2px solid transparent;
      border-radius: 50%;
      transition: 0.3s;
    }

    .avatar-option.selected {
      border-color: #3498db;
    }

    .avatar-option img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
    }
  </style>
</head>
<body>

  <div class="form">
    <h2>Registrar</h2>

    <form id="registroForm" method="POST" action="conexao/registrar.php">
      
      <div class="avatar">
        <label for="selectedAvatar">Avatar escolhido:</label>
        <img id="previewAvatar" src="" alt="Avatar escolhido" style="display:none;">
        <button type="button" id="openAvatarModal">Escolher Avatar</button>
        <input type="hidden" name="avatar" id="selectedAvatar" required>
      </div>

      <label>Nome:</label>
      <input type="text" name="name" required>

      <label>Email:</label>
      <input type="email" name="email" required>
      
      <label>Senha:</label>
      <input type="password" name="password" required>

      <button type="submit">Cadastrar</button>
    </form>

    <button class="register-btn" onclick="carregarTela('app/login.php')">Login</button> 
  </div>

  <!-- Modal de seleção de avatar -->
  <div id="avatarModal" class="modal">
    <div class="modal-content">
      <span id="closeModal" class="close">&times;</span>
      <h3>Escolha seu Avatar</h3>
      <div id="avatarOptions">
        <?php foreach ($avatars as $avatar): ?>
          <div class="avatar-option" data-avatar="avatars/<?= $avatar ?>">
            <img src="../avatars/<?= $avatar ?>" alt="Avatar">
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <script>
    const openModalBtn = document.getElementById('openAvatarModal');
    const closeModalBtn = document.getElementById('closeModal');
    const modal = document.getElementById('avatarModal');
    const avatarOptions = document.querySelectorAll('.avatar-option');
    const selectedAvatarInput = document.getElementById('selectedAvatar');
    const previewAvatar = document.getElementById('previewAvatar');

    openModalBtn.onclick = () => modal.style.display = 'block';
    closeModalBtn.onclick = () => modal.style.display = 'none';

    avatarOptions.forEach(option => {
      option.addEventListener('click', () => {
        avatarOptions.forEach(o => o.classList.remove('selected'));
        option.classList.add('selected');

        const avatarPath = option.getAttribute('data-avatar');
        selectedAvatarInput.value = avatarPath;
        previewAvatar.src = '../' + avatarPath;
        previewAvatar.style.display = 'block';
        modal.style.display = 'none';
      });
    });

    // Fechar modal ao clicar fora
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>

</body>
</html>
