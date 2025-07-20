<?php
session_start();
// Lista de avatares disponíveis
  $avatarFolder = '../avatars/';
  $avatars = array_diff(scandir($avatarFolder), array('.', '..'));


if (isset($_SESSION['erro'])) {
    $mensagem = '';

    switch ($_SESSION['erro']) {
        case 'campos':
            $mensagem = 'Preencha todos os campos.';
            break;
        case 'email':
            $mensagem = 'E-mail inválido ou já cadastrado.';
            break;
        case 'geral':
            $mensagem = 'Ocorreu um erro ao processar o registro.';
            break;
    }

    echo "<p style='color: red; text-align: center;'>$mensagem</p>";

    unset($_SESSION['erro']); // Limpa a mensagem após exibir
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Registro</title>
  <link rel="stylesheet" href="css/registrar.css">
</head>
<body>
  <div class="form">
    <h2>Registrar</h2>
    <form id="registroForm" method="POST" action="conexao/registrar.php">
      <div class="avatar">
        <img id="previewAvatar" src="" alt="Avatar escolhido">
        <button type="button" id="openAvatarModal">Escolher Avatar</button>
        <input type="hidden" name="avatar" id="selectedAvatar" required>
      </div>
      
      <input type="text" name="name" value="<?= $_SESSION['old']['name'] ?? '' ?>" placeholder="Nome" required>
      <input type="email" name="email"  placeholder="Email" required>
      <input type="password" name="password" placeholder="Senha" required>
      <button type="submit">Cadastrar</button>

    </form>

    <button class="register-btn" onclick="carregarTela('app/login.php')">Login</button> 
  </div>

  <div id="avatarModal" class="modal">
    <div class="modal-content">
      <span id="closeModal" class="close">&times;</span>
      <h3>Escolha seu Avatar</h3>
      <div class="avatar-grid">
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

    openModalBtn.onclick = () => modal.classList.add('active');
    closeModalBtn.onclick = () => modal.classList.remove('active');

    avatarOptions.forEach(option => {
      option.addEventListener('click', () => {
        avatarOptions.forEach(o => o.classList.remove('selected'));
        option.classList.add('selected');

        const avatarPath = option.getAttribute('data-avatar');
        selectedAvatarInput.value = avatarPath;
        previewAvatar.src = '../' + avatarPath;
        previewAvatar.style.display = 'block';
        modal.classList.remove('active');
      });
    });

    window.onclick = function(event) {
      if (event.target === modal) {
        modal.classList.remove("active");
      }
    }
  </script>

</body>
</html>
