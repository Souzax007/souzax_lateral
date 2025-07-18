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

/*ajax*/
function carregarTela(pagina) {
  const xhr = new XMLHttpRequest();
  xhr.open('GET', pagina, true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      document.getElementById('conteudoMain').innerHTML = xhr.responseText;
    } else {
      document.getElementById('conteudoMain').innerHTML = 'Erro ao carregar: ' + xhr.status;
    }
  };
  xhr.send();
}



/*função apara abrir o dropdow*/
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





