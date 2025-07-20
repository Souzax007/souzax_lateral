/*funcão para abrir e fechar o menu*/
document.getElementById('open_btn').addEventListener('click', function(){
    document.getElementById('sidebar').classList.toggle('open-sidebar');
});

/*função que vai adicionar a class active nos item da li*/
const itens = document.querySelectorAll('.side-item');
itens.forEach(item => {
    item.addEventListener('click',function() {
        //remove a class 'active' de todos os itens
        itens.forEach(i => i.classList.remove('active'));

        //adiciona 'active' somente no item clicado
        item.classList.add('active');

    });
});

/*ajax - VERSÃO ATUALIZADA PARA FUNCIONAR COM MODALS*/
function carregarTela(pagina) {
    console.log('Carregando página:', pagina);
    
    const xhr = new XMLHttpRequest();
    xhr.open('GET', pagina, true);
    
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('conteudoMain').innerHTML = xhr.responseText;
            
            // Verificar qual página foi carregada e inicializar funcionalidades específicas
            console.log('Página carregada com sucesso:', pagina);
            
            // Aguardar um pouco para o DOM ser renderizado
            setTimeout(() => {
                
                // Se carregou perfil.php, inicializar modal de avatar
                if (pagina.includes('perfil.php')) {
                    console.log('Perfil detectado, inicializando modal...');
                    if (typeof window.initPerfilPage === 'function') {
                        window.initPerfilPage();
                    } else if (typeof setupPerfilModal === 'function') {
                        setupPerfilModal();
                    } else {
                        console.warn('Função de inicialização do perfil não encontrada');
                        // Fallback - tentar inicializar diretamente
                        initAvatarModalPerfil();
                    }
                }
                
                // Se carregou registrar.php, inicializar modal de registro
                else if (pagina.includes('registrar.php')) {
                    console.log('Registro detectado, inicializando modal...');
                    if (typeof setupAvatarModal === 'function') {
                        setupAvatarModal();
                        if (typeof initAvatarModal === 'function') {
                            initAvatarModal();
                        }
                    }
                }
                
                // Se carregou outras páginas específicas
                else if (pagina.includes('movie.php')) {
                    console.log('Página de filmes carregada');
                    // Adicionar inicializações específicas para filmes se necessário
                }
                
                else if (pagina.includes('qr.php')) {
                    console.log('Página QR carregada');
                    // Adicionar inicializações específicas para QR se necessário
                }
                
            }, 150); // 150ms para garantir renderização
            
        } else {
            console.error('Erro ao carregar página:', xhr.status);
            document.getElementById('conteudoMain').innerHTML = 'Erro ao carregar: ' + xhr.status;
        }
    };
    
    xhr.onerror = function() {
        console.error('Erro de rede ao carregar:', pagina);
        document.getElementById('conteudoMain').innerHTML = 'Erro de rede ao carregar a página.';
    };
    
    xhr.send();
}

// Função auxiliar para debug - remover depois se não precisar
function debugCarregamento(pagina) {
    console.log('=== DEBUG CARREGAMENTO ===');
    console.log('Página:', pagina);
    console.log('Elemento conteudoMain:', !!document.getElementById('conteudoMain'));
    console.log('Funções disponíveis:', {
        initPerfilPage: typeof window.initPerfilPage,
        setupPerfilModal: typeof setupPerfilModal,
        setupAvatarModal: typeof setupAvatarModal,
        initAvatarModal: typeof initAvatarModal,
        initAvatarModalPerfil: typeof initAvatarModalPerfil
    });
}

/*função para abrir o dropdown*/
function abrirDropdown(el) {
  const menu = el.querySelector('.dropdown-menu');
  if (menu) {
    menu.style.display = 'block';
  }
}

function fecharDropdown(el) {
  const menu = el.querySelector('.dropdown-menu');
  if (menu) {
    menu.style.display = 'none';
  }
}