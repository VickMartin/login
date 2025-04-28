<?php

    require'../model/DTO/AlunoDTO.php';
    require'../model/DAO/AlunoDAO.php';

    //alunoDTO
    // Captura os dados enviados pelo formulário
    $matricula = $_POST['matricula'];

    $nome = $_POST['nome'];
    $ano_ingresso = $_POST['ano_ingresso'];
    $data_nascimento = $_POST['data_nascimento'];
    $tipo_sanguineo = $_POST['tipo_sanguineo'];
    $deficiencia = $_POST['deficiencia'];
    $alergia = $_POST['alergia'];
    $nome_responsavem =$_POST['nome_responsavel'];


    echo"<pre>";
    var_dump($nome_responsavem ,$nome, $ano_ingresso, $data_nascimento,$tipo_sanguineo, $deficiencia, $alergia, $nome_mae, $id_responsavel);

    // Cria e configura o objeto DTO
    $alunoDTO = new AlunoDTO();
    $alunoDTO->setNome($nome);
    $alunoDTO->setAnoIngresso($ano_ingresso);
    $alunoDTO->setDataNascimento($data_nascimento);
    $alunoDTO->setTipoSanguineo($tipo_sanguineo);
    $alunoDTO->setDeficiencia($deficiencia);
    $alunoDTO->setAlergia($alergia);
    $alunoDTO->setMatricula($matricula); // Adicione esta linha
    //   echo"<pre><br>";
    // var_dump($alunoDTO);

    $alunoDAO = new AlunoDAO();
    
    $alunoDAO->alterarAluno($alunoDTO);

    $alunoDAO = new AlunoDAO();

    $sucesso = $alunoDAO->alterarAluno($alunoDTO);
    if ($sucesso) {
        echo "<script>
                alert('Alteração concluída!');
                window.location.href = '../view/gerencia.php';
              </script>";
    } else {
        echo "<script>
                alert('Operação falhou!');
                window.location.href = '../view/gerencia.php';
              </script>";
    }
    