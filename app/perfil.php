<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require '../conexao/db.php'; // $conn é a conexão

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

// Lista de avatares
$avatarFolder = '../avatars/';
$avatars = array_diff(scandir($avatarFolder), ['.', '..']);

// Processar mudança de avatar via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['avatar'])) {
    $newAvatar = $_POST['avatar'];
    
    // Validar se o avatar existe na lista
    if (in_array(basename($newAvatar), $avatars)) {
        $stmt = $conn->prepare("UPDATE users SET avatar = ? WHERE id = ?");
        $stmt->bind_param("si", $newAvatar, $userId);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Avatar atualizado com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar avatar.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Avatar inválido.']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Bem-vindo</title>
  <link rel="stylesheet" href="css/perfil.css" />
  <link rel="stylesheet" href="css/menu.css" />

</head>
<body>

<div class="main">
  <h2>Olá, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h2>
  <img id="currentAvatar" src="<?= htmlspecialchars($usuario['avatar']) ?>" width="120" alt="Seu avatar" /><br>
  <button id="btnChangeAvatar">Trocar Avatar</button>
  
  <div id="successMessage" class="success-message"></div>
  <div id="errorMessage" class="error-message"></div>
</div>

<!-- Modal de seleção de avatar -->
<div id="avatarModal" class="modal">
  <div class="modal-content">
    <span id="closeModal" class="close">&times;</span>
    <h3>Escolha seu Avatar</h3>
    <div class="avatar-grid">
      <?php foreach ($avatars as $avatar): ?>
        <div class="avatar-option" data-avatar="avatars/<?= htmlspecialchars($avatar) ?>">
          <img src="../avatars/<?= htmlspecialchars($avatar) ?>" alt="Avatar <?= htmlspecialchars($avatar) ?>">
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<script>
const btnChangeAvatar = document.getElementById('btnChangeAvatar');
const closeModalBtn = document.getElementById('closeModal');
const modal = document.getElementById('avatarModal');
const avatarOptions = document.querySelectorAll('.avatar-option');
const currentAvatar = document.getElementById('currentAvatar');
const successMessage = document.getElementById('successMessage');
const errorMessage = document.getElementById('errorMessage');

btnChangeAvatar.onclick = () => {
    modal.classList.add('active');
};

closeModalBtn.onclick = () => {
    modal.classList.remove('active');
    // Remover seleções
    avatarOptions.forEach(option => option.classList.remove('selected'));
};

avatarOptions.forEach(option => {
    option.addEventListener('click', () => {
        avatarOptions.forEach(o => o.classList.remove('selected'));
        
        option.classList.add('selected');
        
        const avatarPath = option.getAttribute('data-avatar');
        
        updateAvatar(avatarPath);
    });
});

function updateAvatar(avatarPath) {
    const formData = new FormData();
    formData.append('avatar', avatarPath);
    
    fetch(window.location.href, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            currentAvatar.src = '../' + avatarPath;
            
            showMessage(data.message, 'success');
            
            // Fechar modal
            modal.classList.remove('active');
            avatarOptions.forEach(option => option.classList.remove('selected'));
        } else {
            showMessage(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        showMessage('Erro ao atualizar avatar. Tente novamente.', 'error');
    });
}

function showMessage(message, type) {
    const messageElement = type === 'success' ? successMessage : errorMessage;
    const otherMessageElement = type === 'success' ? errorMessage : successMessage;
    
    otherMessageElement.style.display = 'none';
    
    messageElement.textContent = message;
    messageElement.style.display = 'block';
    
    setTimeout(() => {
        messageElement.style.display = 'none';
    }, 3000);
}

window.onclick = function(event) {
    if (event.target === modal) {
        modal.classList.remove('active');
        avatarOptions.forEach(option => option.classList.remove('selected'));
    }
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && modal.classList.contains('active')) {
        modal.classList.remove('active');
        avatarOptions.forEach(option => option.classList.remove('selected'));
    }
});
</script>

</body>
</html>