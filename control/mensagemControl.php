<?php

require_once '../model/DTO/MensagemDTO.php';
require_once '../model/DAO/MensagemDAO.php';

// Verificar se os dados necessários estão presentes no POST
if (isset($_POST['id_responsavel'], $_POST['matricula'], $_POST['id_turma'], $_POST['id_professor'], $_POST['mensagem'])) {
    
    $idResponsavel = $_POST['id_responsavel'];
    $matricula = $_POST['matricula'];
    $idTurma = $_POST['id_turma'];
    $idProfessor = $_POST['id_professor'];
    $mensagem = $_POST['mensagem'];
    $tipoMensagem = $_POST['tipo_mensagem'];

    // Criando o objeto MensagemDTO e definindo seus valores
    $mensagemDTO = new MensagemDTO();
    $mensagemDTO->setIdResponsavel($idResponsavel);
    $mensagemDTO->setAlunoMatricula($matricula);
    $mensagemDTO->setIdTurma($idTurma);
    $mensagemDTO->setIdProfessor($idProfessor);
    $mensagemDTO->setMensagem($mensagem);
    $mensagemDTO->setTipoMensagem($tipoMensagem);  

    // Inserindo a mensagem no banco de dados
    $mensagemDAO = new MensagemDAO();
    $resultado = $mensagemDAO->inserirMensagem($mensagemDTO);

   
if ($resultado) {
    // Se a mensagem foi enviada com sucesso, redireciona para a página do perfil do aluno, 
    // incluindo a matrícula como parâmetro na URL (para garantir que a matrícula seja passada)
    echo "<script>
    alert('Mensagem Enviada!');
    window.location.href = '../view/perfilAluno.php?matricula=" . urlencode($matricula) . "';
 </script>";

} else {
    // Se ocorreu algum erro ao enviar a mensagem, ainda redireciona para o perfil do aluno,
    // mas com uma mensagem de erro. A matrícula também é passada na URL.
    echo "<script>
             alert('Falha ao enviar mensagem, tente novamente!');
             window.location.href = '../view/perfilAluno.php?matricula=" . urlencode($matricula) . "';
          </script>";
}
    

}
?>