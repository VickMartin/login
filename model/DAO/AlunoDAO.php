<?php
require_once'Conexao.php';
require_once'../model/DTO/AlunoDTO.php';

class AlunoDAO{
    public $pdo = null;
    //construtor da classe que estabelece a canexão com o banco de dados no momentoda criação do objeto DAO
    public function __construct(){
        $this->pdo = Conexao::getInstance();
    }

    public function cadastroAluno(AlunoDTO $alunoDTO, $idAdm){
        try{
            // Modificando a consulta SQL para incluir o ID do administrador
            $sql = "INSERT INTO aluno (nome, ano_ingresso, data_nascimento, tipo_sanguineo, deficiencia, alergia, nome_mae, id_responsavel, foto, id_adm) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
            $stmt = $this->pdo->prepare($sql);
    
            $nome = $alunoDTO->getNome();
            $ano_ingresso = $alunoDTO->getAnoIngresso();
            $data_nascimento = $alunoDTO->getDataNascimento();
            $tipo_sanguineo = $alunoDTO->getTipoSanguineo();
            $deficiencia = $alunoDTO->getDeficiencia();
            $alergia = $alunoDTO->getAlergia();
            $nome_mae = $alunoDTO->getNomeMae();
            $id_responsavel = $alunoDTO->getIdResponsavel();
            $foto = $alunoDTO->getFoto();
    
            // Associando o ID do administrador
            $stmt->bindValue(1, $nome);
            $stmt->bindValue(2, $ano_ingresso);
            $stmt->bindValue(3, $data_nascimento);
            $stmt->bindValue(4, $tipo_sanguineo);
            $stmt->bindValue(5, $deficiencia);
            $stmt->bindValue(6, $alergia);
            $stmt->bindValue(7, $nome_mae);
            $stmt->bindValue(8, $id_responsavel);
            $stmt->bindValue(9, $foto);
            $stmt->bindValue(10, $idAdm);
         
    
            // Executando a consulta
            $retorno = $stmt->execute();
    
            return $retorno;
    
        }catch(PDOException $exe){
            echo $exe->getMessage();
           
        }
    }
    
       

        
    
    public function listarAlunos() {
        try {
            // Consulta SQL para listar todos os alunos, sem filtrar por id_adm
            $sql = "SELECT * FROM aluno";
    
            // Prepara a consulta
            $stmt = $this->pdo->prepare($sql);
    
            // Executa a consulta
            $stmt->execute();
    
            // Retorna todos os alunos
            $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $retorno;
    
        } catch (PDOException $exe) {
            // Exibe a mensagem de erro em caso de exceção
            echo $exe->getMessage();
            return null; // Retorna null em caso de erro
        }
    }
    
    
    


    public function buscarAlunoPorId($id) {
        try {
            // Use um parâmetro nomeado corretamente
            $sql = "SELECT * FROM aluno WHERE matricula = :matricula;";
            $stmt = $this->pdo->prepare($sql);
            
            // Liga o parâmetro
            $stmt->bindParam(':matricula', $id, PDO::PARAM_INT);
            
            // Executa a consulta
            $stmt->execute();
            
            // Busca o resultado da consulta em um array associativo
            $retorno = $stmt->fetch(PDO::FETCH_ASSOC);
            return $retorno; // Retorna o resultado ou null se não encontrado
            
        } catch (PDOException $exe) {
            // Exibe a mensagem de erro em caso de exceção
            echo $exe->getMessage();
            return null; // Retorna null em caso de erro
        }
    }


public function alterarAluno(AlunoDTO $alunoDTO) {
    try {
        $sql = "UPDATE aluno 
                SET nome = :nome, 
                    ano_ingresso = :ano_ingresso, 
                    data_nascimento = :data_nascimento, 
                    tipo_sanguineo = :tipo_sanguineo, 
                    deficiencia = :deficiencia, 
                    alergia = :alergia
                WHERE matricula = :matricula";
                
        $stmt = $this->pdo->prepare($sql);

        // Obtenha os valores do DTO
        $nome = $alunoDTO->getNome();
        $ano_ingresso = $alunoDTO->getAnoIngresso();
        $data_nascimento = $alunoDTO->getDataNascimento();
        $tipo_sanguineo = $alunoDTO->getTipoSanguineo();
        $deficiencia = $alunoDTO->getDeficiencia();
        $alergia = $alunoDTO->getAlergia();
        $matricula = $alunoDTO->getMatricula(); // Certifique-se de que o DTO contenha esse método
        
        // Vincule os parâmetros
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':ano_ingresso', $ano_ingresso);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->bindParam(':tipo_sanguineo', $tipo_sanguineo);
        $stmt->bindParam(':deficiencia', $deficiencia);
        $stmt->bindParam(':alergia', $alergia);
        $stmt->bindParam(':matricula', $matricula);
        
        // Execute a atualização
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro ao alterar o usuário: " . $e->getMessage();
        return false;
    }
}

public function adicionarAlunoATurma(AlunoDTO $alunoDTO, $id_turma) {
    try {
        // SQL para atualizar a turma do aluno pela matrícula
        $sql = "UPDATE aluno 
                SET id_turma = :id_turma
                WHERE matricula = :matricula";

        $stmt = $this->pdo->prepare($sql);

        // Obtenha os valores do DTO
        $matricula = $alunoDTO->getMatricula();
        $id_turma = $alunoDTO->getIdTurma();

        // Vincule os parâmetros
        $stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);
        $stmt->bindParam(':matricula', $matricula, PDO::PARAM_INT);

        // Execute a atualização
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro! " . $e->getMessage();
    }
}


public function listarFilhosPorResponsavel($idResponsavel) {
    try {
        // Busca todos os alunos associados a um responsável
    $sql = "SELECT matricula, nome, ano_ingresso,data_nascimento,tipo_sanguineo,deficiencia,alergia,nome_mae,id_responsavel,id_adm, id_turma  FROM aluno WHERE id_responsavel = :id_responsavel";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':id_responsavel', $idResponsavel, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os alunos encontrados
    } 
    catch (PDOException $e) {
        echo "Erro! " . $e->getMessage();
    }
}


public function excluirAluno($idAluno) {
    try {
        // Comando SQL para excluir o aluno pela matrícula
        $sql = "DELETE FROM aluno WHERE matricula = :idAluno";
        $stmt = $this->pdo->prepare($sql);
        
        // Vincula o parâmetro :idAluno com o valor da variável $idAluno
        $stmt->bindParam(':idAluno', $idAluno, PDO::PARAM_INT);

        // Executa a exclusão e verifica se foi bem-sucedida
        $retorno = $stmt->execute();
        
        // Retorna o sucesso da execução da consulta
        return $retorno;

    } catch (PDOException $exception) {
        echo "Erro: " . $exception->getMessage();
    }
}










} 
?>
