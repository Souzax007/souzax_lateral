// ADICIONE ESTE CÓDIGO AO FINAL DO SEU ARQUIVO perfil.js

// Função fallback mais simples para inicializar modal
function initAvatarModalPerfil() {
    console.log('initAvatarModalPerfil - Tentando inicializar...');
    
    const btn = document.getElementById('btnChangeAvatar');
    const modal = document.getElementById('avatarModal');
    
    if (!btn || !modal) {
        console.warn('Elementos não encontrados ainda, tentando novamente...');
        // Tentar novamente após um delay
        setTimeout(initAvatarModalPerfil, 300);
        return;
    }
    
    console.log('Elementos encontrados! Configurando eventos...');
    
    // Limpar eventos anteriores clonando o elemento
    const newBtn = btn.cloneNode(true);
    btn.parentNode.replaceChild(newBtn, btn);
    
    // Configurar evento de abrir modal
    newBtn.addEventListener('click', function(e) {
        e.preventDefault();
        console.log('Botão clicado - abrindo modal');
        modal.style.display = 'flex';
        modal.classList.add('active');
    });
    
    // Configurar evento de fechar modal
    const closeBtn = document.getElementById('closeModal');
    if (closeBtn) {
        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Fechando modal');
            modal.style.display = 'none';
            modal.classList.remove('active');
        });
    }
    
    // Configurar seleção de avatares
    const avatarOptions = document.querySelectorAll('.avatar-option');
    avatarOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Visual feedback
            avatarOptions.forEach(o => o.classList.remove('selected'));
            option.classList.add('selected');
            
            const avatarPath = option.getAttribute('data-avatar');
            console.log('Avatar selecionado:', avatarPath);
            
            // Atualizar avatar
            updateAvatarSimple(avatarPath);
        });
    });
    
    // Fechar ao clicar fora
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            modal.classList.remove('active');
        }
    });
    
    console.log('Modal configurado com sucesso!');
}

// Função simplificada para atualizar avatar
function updateAvatarSimple(avatarPath) {
    console.log('Atualizando avatar:', avatarPath);
    
    const formData = new FormData();
    formData.append('avatar', avatarPath);
    
    fetch('app/perfil.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Atualizar imagem do perfil
            const currentAvatar = document.getElementById('currentAvatar');
            if (currentAvatar) {
                currentAvatar.src = '../' + avatarPath;
            }
            
            // Atualizar avatar do sidebar
            const sidebarAvatar = document.getElementById('user_avatar');
            if (sidebarAvatar) {
                sidebarAvatar.src = avatarPath;
            }
            
            // Fechar modal
            const modal = document.getElementById('avatarModal');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.remove('active');
            }
            
            // Mostrar sucesso
            //alert('Avatar atualizado com sucesso!');
            
        } else {
            alert('Erro ao atualizar avatar: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao atualizar avatar. Tente novamente.');
    });
}

// Função global para ser chamada pelo script.js
window.initPerfilPage = function() {
    console.log('initPerfilPage chamada pelo script.js');
    setTimeout(initAvatarModalPerfil, 100);
};

// Verificar se já está na página de perfil ao carregar este script
setTimeout(() => {
    if (document.getElementById('btnChangeAvatar')) {
        console.log('Página de perfil detectada no carregamento');
        initAvatarModalPerfil();
    }
}, 500);