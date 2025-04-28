function exibirModal(mensagem, status) {
    var modal = document.getElementById('modal');
    var mensagemP = document.getElementById('mensagem');

    mensagemP.textContent = mensagem;

    // Define a cor do texto de acordo com o status
    if (status === 'success') {
        mensagemP.classList.add('success');
    } else {
        mensagemP.classList.add('error');
    }

    // Exibe o modal
    modal.style.display = 'block';
}

function fecharModal() {
    // Fecha o modal
    var modal = document.getElementById('modal');
    modal.style.display = 'none';

    // Redireciona o usuário para a página home.php
    window.location.href = '../view/telaAdm.php';
}
