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
