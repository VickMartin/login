<?php

require_once '../model/DTO/TurmaDTO.php';
require_once '../model/DAO/TurmaDAO.php';

    // Obter os dados do formulário
    $nomeTurma = $_POST['nome_turma'];
    $ano = $_POST['ano'];
    $professorResponsavel = $_POST['professor_responsavel'];
    $idAdm = $_POST['id_adm'];
    $turno = $_POST['turno'];

    // var_dump($nomeTurma,$ano, $professorResponsavel, $idAdm );

    $turmaDTO = new TurmaDTO();


    $turmaDTO->setNomeTurma($nomeTurma);
    $turmaDTO->setProfessorResponsavel($professorResponsavel);
    $turmaDTO->setAno($ano);
    $turmaDTO->setIdAdm($idAdm);
    $turmaDTO->setTurno($turno);

    echo"<pre>";
    var_dump($turmaDTO);

        // Criar uma instância de TurmaDAO e inserir os dados
        $turmaDAO = new TurmaDAO();
        $resultado = $turmaDAO->criarTurma($turmaDTO, $idAdm);

        // // Verificar se a operação foi bem-sucedida
        if ($resultado) {
            echo "<script>
                alert('Turma criada com sucesso!'); 
                window.location.href = '../view/criarTurmas.php';
            </script>";
        } else {
            echo "<script>
                alert('Falha ao criar turma. Tente novamente.'); 
                window.location.href = '../view/criarTurmas.php';
            </script>";
        }
    


?>
