<?php

require_once '../model/DTO/UsuarioDTO.php';
require_once '../model/DAO/UsuarioDAO.php';

// Iniciar a sessão para pegar o ID do administrador logado
session_start();

// Verificar se o administrador está logado e pegar o ID do administrador
if (isset($_SESSION['id_usuario'])) {
    $idAdm = $_SESSION['id_usuario'];  // O ID do administrador logado
} else {
    // Se o administrador não estiver logado, redirecionar para a página de login ou exibir erro
    echo "Você precisa estar logado como administrador para cadastrar um usuário.";
    exit(); // Encerra o script caso o administrador não esteja logado
}

// Dados do formulário de cadastro
$nome = $_POST['nome'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$senha = $_POST['senha'];
$perfil = $_POST['perfil'];

// Variáveis para perfil 'responsavel' e 'professor'
$formacao = isset($_POST['formacao']) ? $_POST['formacao'] : null;
$telefone = isset($_POST['telefone']) ? $_POST['telefone'] : null;
$endereco = isset($_POST['endereco']) ? $_POST['endereco'] : null;

// Cria e configura o objeto DTO
$usuarioDTO = new UsuarioDTO();
$usuarioDTO->setNome($nome);
$usuarioDTO->setEmail($email);
$usuarioDTO->setCpf($cpf);
$usuarioDTO->setSenha($senha);
$usuarioDTO->setPerfil($perfil);

// var_dump($usuarioDTO);

// Definindo a formação, telefone e endereço apenas se existirem (dependendo do perfil)
if ($perfil === 'professor') {
    $usuarioDTO->setFormacao($formacao);  // Somente se o perfil for professor
} elseif ($perfil === 'responsavel') {
    $usuarioDTO->setTelefone($telefone);  // Somente se o perfil for responsável
    $usuarioDTO->setEndereco($endereco);  // Somente se o perfil for responsável
}

// Para debugging, removi o var_dump, mas você pode deixá-lo para ver o que foi atribuído ao DTO
// var_dump($usuarioDTO);

// Realiza o cadastro e define a mensagem de retorno
$usuarioDAO = new UsuarioDAO();
$resultado = $usuarioDAO->cadastroUsuario($usuarioDTO, $idAdm, $telefone, $endereco, $formacao);

if ($resultado) {
    echo "<script>
        alert('Usuário cadastrado com sucesso!');
        window.location.href = '../view/telaAdm.php';
    </script>";
} else {
    echo "<script>
        alert('Erro ao Cadastrar Usuário!');
        window.location.href = '..view/telaAdm.php';
    </script>";
}