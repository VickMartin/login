<?php
require_once '../model/DAO/AdmDAO.php';
require_once '../model/DTO/AdmDTO.php'; // Inclui o DTO do administrador

session_start();

// Verifica se o usuário está logado como administrador
if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'administrador') {
    echo "<script>
        alert('Acesso não autorizado!');
        window.location.href = '../index.php';
    </script>";
    exit;
}

// Dados do formulário de alteração
$id_usuario = $_POST['id_usuario'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$foto = $_FILES['foto'] ?? null; // Captura a nova foto, se houver

// Cria e configura o objeto DTO
$admDTO = new AdmDTO();
$admDTO->setIdAdm($id_usuario);
$admDTO->setNome($nome);
$admDTO->setEmail($email);

// Define o caminho para salvar a imagem
$diretorio = '../uploads/'; // Diretório onde as imagens serão salvas

// Cria o diretório se não existir
if (!is_dir($diretorio)) {
    mkdir($diretorio, 0755, true); // Cria o diretório com permissão de leitura e escrita
}

// Verifica se há uma nova foto para upload
if ($foto && $foto['error'] === UPLOAD_ERR_OK) {
    $nomeArquivo = uniqid() . '-' . basename($foto['name']); // Gera um nome único para o arquivo
    $caminhoArquivo = $diretorio . $nomeArquivo;

    // Move o arquivo enviado para o diretório
    if (move_uploaded_file($foto['tmp_name'], $caminhoArquivo)) {
        // Armazena o caminho da imagem no DTO
        $admDTO->setFoto($caminhoArquivo);
    } else {
        echo "<script>
            alert('Erro ao fazer upload da foto! Verifique as permissões do diretório de upload.');
            window.location.href = '../view/telaAdm.php';
        </script>";
        exit;
    }
} else {
    // Se não houver uma nova foto, pode-se manter o caminho anterior ou não atualizar
    $admDTO->setFoto(null); // ou pode deixar o campo inalterado dependendo da sua lógica
}

// Cria uma instância do DAO para atualizar os dados do administrador
$admDAO = new AdmDAO();

// Tenta atualizar o administrador no banco de dados
if ($admDAO->atualizarAdministrador($admDTO)) {
    echo "<script>
        alert('Dados do administrador atualizados com sucesso!');
        window.location.href = '../index.php';
    </script>";
} else {
    echo "<script>
        alert('Erro ao atualizar os dados do administrador!');
        window.location.href = '../view/formMeuperfil.php';
    </script>";
}



?>