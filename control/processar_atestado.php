<?php
require_once '../model/DTO/AtestadoDTO.php';
require_once '../model/DAO/AtestadoDAO.php';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Pegar os dados enviados pelo formulário
    $imagem_atestado = "";  // Arquivo de imagem
    $data_atestado = isset($_POST['data_atestado']) ? $_POST['data_atestado'] : ''; // Data do atestado
    $id_aluno = isset($_POST['id_aluno']) ? $_POST['id_aluno'] : '';  // ID do aluno
    $id_responsavel = isset($_POST['id_responsavel']) ? $_POST['id_responsavel'] : '';  // ID do responsável
    $Arquivo = "";

    // Verifica se o arquivo de imagem foi enviado
    if (isset($_FILES["imagem_atestado"])) {
        if ($_FILES["imagem_atestado"]["error"] === UPLOAD_ERR_OK) {
            // Recebe o nome do arquivo e cria um nome único
            $Arquivo = $_FILES["imagem_atestado"]["name"];
            $pastaDestino = "../uploads";
            $Arquivo = uniqid() . "_" . $Arquivo;  // Garantir que o nome do arquivo seja único
            $arqDestino = $pastaDestino . '/' . $Arquivo;
            
            // Verifica se o diretório de destino existe e tem permissões corretas
            if (move_uploaded_file($_FILES["imagem_atestado"]["tmp_name"], $arqDestino)) {
                echo "Arquivo carregado com sucesso!";
            } else {
                echo "Erro ao carregar o arquivo.";
            }
        } else {
            echo "Erro no upload do arquivo: " . $_FILES["imagem_atestado"]["error"];
        }
    }

    $imagem_atestado = $Arquivo;  // Atualiza a variável com o nome final do arquivo

    // Cria e configura o objeto DTO
    $atestadoDTO = new AtestadoDTO();
    $atestadoDTO->setImagemAtestado($imagem_atestado);
    $atestadoDTO->setDataAtestado($data_atestado);
    $atestadoDTO->setIdAluno($id_aluno);
    $atestadoDTO->setIdResponsavel($id_responsavel);

    // Exibir os dados do objeto DTO para depuração
    echo "<pre>";
    var_dump($atestadoDTO);
    echo "</pre>";

    // Inserindo o atestado no banco de dados
    $atestadoDAO = new AtestadoDAO();
    $resultado = $atestadoDAO->inserirAtestado($atestadoDTO);

    // Redireciona dependendo do sucesso ou falha
    if ($resultado) {
        echo "<script>
            alert('Atestado Enviado com Sucesso!');
            window.location.href = '../view/envioAtestado.php?matricula=" . urlencode($id_aluno) . "';
        </script>";
    } else {
        echo "<script>
            alert('Falha ao enviar Atestado, tente novamente!');
            window.location.href = '../view/envioAtestado.php?matricula=" . urlencode($id_aluno) . "';
        </script>";
    }
}
?>
