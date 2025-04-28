<?php

    require'../model/DTO/AlunoDTO.php';
    require'../model/DAO/AlunoDAO.php';

    $id_turma = $_POST['id_turma'];
    $matricula_aluno = $_POST['matricula_aluno'];

    // var_dump($id_turma, $matricula_aluno);


    $alunoDTO = new AlunoDTO();

    $alunoDTO->setMatricula($matricula_aluno);
    $alunoDTO->setIdTurma($id_turma);

    // echo"<pre>";
    // var_dump($alunoDTO);
      

    $alunoDAO = new AlunoDAO();

    $sucesso = $alunoDAO->adicionarAlunoATurma($alunoDTO, $id_turma);


    if ($sucesso) {
        echo "<script>
                 alert('Aluno(a) inserido como sucesso!');
                 window.location.href = '../view/turmas.php';
              </script>";
    } else {
        echo "<script>
                 alert('Falha ao inserir aluno(a)!');
                 window.location.href = '../view/turmas.php';
              </script>";
    }

?>







