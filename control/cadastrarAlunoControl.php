<?php
require_once '../model/DTO/AlunoDTO.php';
require_once '../model/DAO/AlunoDAO.php';

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

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Pegar os dados enviados pelo formulário
    $foto_aluno = "";  // Arquivo de imagem (foto do aluno)
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';  // Nome do aluno
    $ano_ingresso = isset($_POST['ano_ingresso']) ? $_POST['ano_ingresso'] : '';  // Ano de ingresso
    $data_nascimento = isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : '';  // Data de nascimento
    $tipo_sanguineo = isset($_POST['tipo_sanguineo']) ? $_POST['tipo_sanguineo'] : '';  // Tipo sanguíneo
    $deficiencia = isset($_POST['deficiencia']) ? $_POST['deficiencia'] : '';  // Deficiência
    $alergia = isset($_POST['alergia']) ? $_POST['alergia'] : '';  // Alergia
    $nome_mae = isset($_POST['nome_mae']) ? $_POST['nome_mae'] : '';  // ID do responsável
    $id_responsavel = isset($_POST['id_responsavel']) ? $_POST['id_responsavel'] : '';  // ID do responsável
    $Arquivo = "";
    
    // Verifica se o arquivo de imagem foi enviado
    if (isset($_FILES["foto_aluno"]) && $_FILES["foto_aluno"]["error"] === UPLOAD_ERR_OK) {
        // Recebe o nome do arquivo e cria um nome único
        $Arquivo = $_FILES["foto_aluno"]["name"];
        $pastaDestino = "../uploads";
        $Arquivo = uniqid() . "_" . $Arquivo;  // Garantir que o nome do arquivo seja único
        $arqDestino = $pastaDestino . '/' . $Arquivo;

        // Verifica se o diretório de destino existe e tem permissões corretas
        if (move_uploaded_file($_FILES["foto_aluno"]["tmp_name"], $arqDestino)) {
            // Arquivo carregado com sucesso
            
        } else {
            // Erro ao mover o arquivo para o diretório de destino
            echo "Erro ao carregar a foto do aluno.";
            exit();  // Interrompe a execução se o arquivo não foi carregado com sucesso
        }
    } else {
        // Se não houver erro, exibe um erro para o usuário
        echo "Erro no upload da foto: " . $_FILES["foto_aluno"]["error"];
        exit();  // Interrompe a execução se o arquivo não for enviado corretamente
    }

    // Atualiza a variável com o nome final do arquivo da foto
    $foto_aluno = $Arquivo;

    // Cria e configura o objeto DTO
    $alunoDTO = new AlunoDTO();
    $alunoDTO->setNome($nome);
    $alunoDTO->setAnoIngresso($ano_ingresso);
    $alunoDTO->setDataNascimento($data_nascimento);
    $alunoDTO->setTipoSanguineo($tipo_sanguineo);
    $alunoDTO->setDeficiencia($deficiencia);
    $alunoDTO->setAlergia($alergia);
    $alunoDTO->setNomeMae($nome_mae);
    $alunoDTO->setIdResponsavel($id_responsavel);
    $alunoDTO->setFoto($foto_aluno);  // Setando a foto do aluno

    // Exibir os dados do objeto DTO para depuração (se necessário)
    // echo "<pre>"; var_dump($alunoDTO); echo "</pre>";

    // Inserindo o aluno no banco de dados
    $alunoDAO = new AlunoDAO();
    $resultado = $alunoDAO->cadastroAluno($alunoDTO, $idAdm);

    // Redireciona dependendo do sucesso ou falha
    if ($resultado) {
        echo "<script>
            alert('Aluno cadastrado com sucesso!');
            window.location.href = '../view/gerencia.php';
        </script>";
    } else {
        echo "<script>
            alert('Falha ao cadastrar aluno, tente novamente!');
            window.location.href = '../view/gerencia.php';
        </script>";
    }
}
?>
