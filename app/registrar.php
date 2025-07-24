<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Registro</title>
  <link rel="stylesheet" href="../css/registrar.css">
</head>
<body>

  <div class="form">
    <h2>Registrar</h2>
    <form id="registroForm" method="POST" action="../conexao/registrar_backend.php"> 
     
    <div class="avatar">
        <img id="previewAvatar" src="" alt="Avatar escolhido" style="display: none;" >
        <button type="button" id="openAvatarModal">Escolher Avatar</button>
        <input type="hidden" name="avatar" id="selectedAvatar" >
      </div>
      
      <input type="text" name="name" placeholder="Nome" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Senha" required>
      
      <button type="submit" id="btn_cadastrar" >Cadastrar</button>
    </form>

    <a href="./login.php">login</a>
  </div>

</body>
</html>
