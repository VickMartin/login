<?php
require_once "../model/DTO/RegistrosDTO.php";
require_once "../model/DAO/RegistrosDAO.php";

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Pegar os dados enviados pelo formulário
    $documento = "";  // Nome do arquivo (documento)
    $tipo_arquivo = isset($_POST['tipo_arquivo']) ? $_POST['tipo_arquivo'] : '';  // Tipo de documento (relatório ou notas)
    $id_responsavel = isset($_POST['id_responsavel']) ? $_POST['id_responsavel'] : '';  // ID do responsável
    $matricula = isset($_POST['matricula']) ? $_POST['matricula'] : '';  // ID do aluno
    $data_atestado = isset($_POST['data_atestado']) ? $_POST['data_atestado'] : date('Y-m-d H:i:s');  // Data do atestado

    // Verifica se o arquivo PDF foi enviado
    if (isset($_FILES["arquivo_pdf"])) {
        if ($_FILES["arquivo_pdf"]["error"] === UPLOAD_ERR_OK) {
            // Recebe o nome do arquivo e cria um nome único
            $documento = $_FILES["arquivo_pdf"]["name"];
            $pastaDestino = "../uploads";

            // Verifica se o diretório existe, se não, cria
            if (!file_exists($pastaDestino)) {
                mkdir($pastaDestino, 0777, true); // Cria a pasta com permissões adequadas
            }

            // Cria um nome único para o arquivo
            $documento = uniqid() . "_" . $documento;
            $arqDestino = $pastaDestino . '/' . $documento;

            // Verifica se a movimentação do arquivo foi bem-sucedida
            if (move_uploaded_file($_FILES["arquivo_pdf"]["tmp_name"], $arqDestino)) {
                echo "Arquivo carregado com sucesso!";
            } else {
                echo "Erro ao carregar o arquivo.";
            }
        } else {
            echo "Erro no upload do arquivo: " . $_FILES["arquivo_pdf"]["error"];
        }
    }

    // Agora a variável $documento é a que contém o nome final do arquivo
    $arquivo_pdf = $documento;

    // Cria e configura o objeto DTO para registro
    $registroDTO = new RegistrosDTO();
    $registroDTO->setDocumento($arquivo_pdf);
    $registroDTO->setTipoDocumento($tipo_arquivo);
    $registroDTO->setIdAluno($matricula);
    $registroDTO->setIdResponsavel($id_responsavel);
    $registroDTO->setDatetime($data_atestado);

    // Exibe os dados do objeto DTO para depuração
    // echo "<pre>";
    // var_dump($registroDTO);
    // echo "</pre>";

    // Aqui você pode continuar com a lógica de inserção no banco de dados (comentado)
    
    $registroDAO = new RegistrosDAO();
    $resultado = $registroDAO->inserirRegistro($registroDTO);

    // Redireciona dependendo do sucesso ou falha
    if ($resultado) {
        echo "<script>
            alert('Registro Enviado com Sucesso!');
            window.location.href = '../view/relatorio.php?matricula=" . urlencode($matricula) . "'; 
        </script>";
    } else {
        echo "<script>
            alert('Falha ao enviar Registro, tente novamente!');
            window.location.href = '../view/relatorio.php?matricula=" . urlencode($matricula) . "'; 
        </script>";
    }
    
}
?>


