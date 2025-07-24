$(document).ready(function() {
  // Clicar no avatar: verifica sessão e carrega perfil ou login
  $('#menu-avatar').on('click', function() {
    $.get('verifica_sessao.php', function(data) {
      if (data.logado) {
        $('#auth-container').load('perfil.php');
      } else {
        $('#auth-container').load('login.php');
      }
    }, 'json');
  });

  // Envio do formulário de login
  $(document).on('submit', '#login-form', function(e) {
    e.preventDefault();

    $.post('process_login.php', $(this).serialize(), function(response) {
      if (response.success) {
        $('#auth-container').load('perfil.php');
        location.reload(); // atualiza para exibir botão logout, se necessário
      } else {
        $('#login-error').text(response.message);
      }
    }, 'json');
  });

  // Envio do formulário de registro
  $(document).on('submit', '#register-form', function(e) {
    e.preventDefault();

    $.post('process_register.php', $(this).serialize(), function(response) {
      if (response.success) {
        $('#register-error').text("Cadastro realizado! Faça login.");
        setTimeout(() => $('#auth-container').load('login.php'), 1500);
      } else {
        $('#register-error').text(response.message);
      }
    }, 'json');
  });

  // Alternância entre login e registro
  $(document).on('click', '#show-register', function() {
    $('#auth-container').load('registrar.php');
  });

  $(document).on('click', '#show-login', function() {
    $('#auth-container').load('login.php');
  });
});
