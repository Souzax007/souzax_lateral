<?php
session_start();
if (!isset($_SESSION['user'])) {
    echo "Você não está logado.";
    exit;
}
?>
<h2>Bem-vindo, <?php echo $_SESSION['user']; ?>!</h2>
<p>Este é seu perfil.</p>
