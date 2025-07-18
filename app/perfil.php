<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require '../conexao/db.php'; 

$userId = $_SESSION['user_id'] ?? null;

if ($userId) {
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();
} else {
    echo "Usuário não logado.";
}

// Lista de avatares
$avatarFolder = '../avatars/';
$avatars = array_diff(scandir($avatarFolder), ['.', '..']);
?>  

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Bem-vindo</title>
  <link rel="stylesheet" href="css/perfil.css">
</head>
<body>

<div class="main">
  <h2>Olá, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h2>
  <img id="currentAvatar" src="<?= htmlspecialchars($usuario['avatar'] ?? '') ?>" width="120" alt="Seu avatar"><br>
  <button id="btnChangeAvatar">Trocar Avatar</button>
</div>

<!-- Modal -->
<div id="modal">
  <div id="modal-content">
    <span id="modal-close">&times;</span>
    <h3>Escolha seu novo avatar</h3>
    <div class="avatar-grid">
      <?php foreach ($avatars as $avatar): ?>
        <img src="../avatars/<?= htmlspecialchars($avatar) ?>" data-avatar="<?= htmlspecialchars('avatars/' . $avatar) ?>" alt="Avatar">
      <?php endforeach; ?>
    </div>
  </div>
</div>

<script>
  const btnChangeAvatar = document.getElementById('btnChangeAvatar');
  const modal = document.getElementById('modal');
  const modalClose = document.getElementById('modal-close');
  const avatarImages = modal.querySelectorAll('.avatar-grid img');
  const currentAvatar = document.getElementById('currentAvatar');

  btnChangeAvatar.addEventListener('click', () => {
    modal.classList.add('active');
  });

  modalClose.addEventListener('click', () => {
    modal.classList.remove('active');
  });

  avatarImages.forEach(img => {
    img.addEventListener('click', () => {
      const novoAvatar = img.getAttribute('data-avatar');
      currentAvatar.src = '../' + novoAvatar;

      fetch('update_avatar.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'avatar=' + encodeURIComponent(novoAvatar)
      })
      .then(res => res.text())
      .then(data => {
        console.log('Resposta backend:', data);
      })
      .catch(err => {
        alert('Erro ao atualizar avatar.');
        console.error(err);
      });
    });
  });
</script>

</body>
</html>
