// script.js
function loadImage(event) {
    const preview = document.getElementById('foto-preview'); // Obtém o elemento de imagem para pré-visualização
    const file = event.target.files[0]; // Obtém o primeiro arquivo selecionado
    const reader = new FileReader(); // Cria um novo FileReader para ler o conteúdo do arquivo

    // Define o que acontece quando o arquivo for carregado
    reader.onload = function(e) {
        preview.src = e.target.result; // Atualiza a imagem de pré-visualização com o resultado lido
    };

    if (file) {
        reader.readAsDataURL(file); // Lê o arquivo como uma URL de dados
    }
}
