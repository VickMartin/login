<?php
require_once'Conexao.php';
require_once'../model/DTO/UsuarioDTO.php';

class TurmaDAO{
    public $pdo = null;
    //construtor da classe que estabelece a canexão com o banco de dados no momentoda criação do objeto DAO
    public function __construct(){
        $this->pdo = Conexao::getInstance();
    }

    public function criarTurma(TurmaDTO $TurmaDTO, $idAdm) {
        try {
            // Consulta SQL para inserir uma nova turma
            $query = "INSERT INTO turmas (nome, ano, professor_responsavel, turno) VALUES (?,?,?,?)";
            $stmt = $this->pdo->prepare($query);


            $nome = $TurmaDTO->getNomeTurma();
            $ano = $TurmaDTO->getAno();
            $professor_responsavel = $TurmaDTO->getProfessorResponsavel();
            $turno = $TurmaDTO->getTurno();
           
    
            // Vincular os parâmetros
            $stmt->bindParam(1, $nome);
            $stmt->bindParam(2, $ano);
            $stmt->bindParam(3, $professor_responsavel);
            $stmt->bindParam(4, $turno);
            
    
            // Executar a consulta
            $retorno = $stmt->execute();
    
            return $retorno;
    
        } catch (PDOException $e) {
            // Tratar erros e exibir a mensagem
            echo "Erro ao criar turma: " . $e->getMessage();
           
        }
    }
    
    public function listarTurmas() {
        try {
            // Consulta SQL para listar todas as turmas, agora incluindo o campo "turno"
            $sql = "
                SELECT t.id_turma, t.nome AS nome_turma, t.ano, t.turno, u.nome AS nome_professor
                FROM turmas AS t
                LEFT JOIN professores AS p ON t.professor_responsavel = p.id_professor
                LEFT JOIN usuarios AS u ON p.usuario_id = u.id_usuario
            ";
    
            // Prepara a consulta
            $stmt = $this->pdo->prepare($sql);
    
            // Executa a consulta
            $stmt->execute();
    
            // Retorna os dados das turmas
            $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $retorno;
    
        } catch (PDOException $exe) {
            // Exibe a mensagem de erro em caso de exceção
            echo $exe->getMessage();
        }
    }
    


    public function listarTurmasPorProfessor($idProfessor) {
        try {
            $sql = 
                    "SELECT id_turma, nome, ano 
                    FROM turmas 
                    WHERE professor_responsavel = :idProfessor 
                    LIMIT 0, 25";
                    
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idProfessor', $idProfessor, PDO::PARAM_INT);
            $stmt->execute();
             
            

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Trate o erro, se necessário
            echo "Erro ao listar turmas: " . $e->getMessage();
            return [];
        }
    }
    
    function listarAlunosETurma($id_turma) {
        try {
    
            // Consulta SQL
            $sql = "
                SELECT 
                    aluno.matricula, 
                    aluno.nome AS nome_aluno,
                    usuarios.nome AS nome_professor,
                    turmas.nome AS nome_turma
                FROM 
                    aluno
                JOIN 
                    turmas ON aluno.id_turma = turmas.id_turma
                JOIN 
                    professores ON turmas.professor_responsavel = professores.id_professor
                JOIN 
                    usuarios ON professores.usuario_id = usuarios.id_usuario
                WHERE 
                    turmas.id_turma = :id_turma
            ";
    
            // Preparar e executar a consulta
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);
            $stmt->execute();
    
            // Obter resultados
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $resultados; // Retorna os dados para uso posterior
        } catch (PDOException $e) {
            // Tratar erros de conexão ou execução
            echo "Erro: " . $e->getMessage();
           
        }
    }


    public function excluirTurma($id_turma) {
        try {
            // Comando SQL para excluir a turma pela ID
            $sql = "DELETE FROM turmas WHERE id_turma = :id_turma";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);
    
            // Executa a exclusão e verifica se foi bem-sucedida
            $retorno = $stmt->execute();
            
            // Retorna o sucesso da execução da consulta
            return $retorno;
    
        } catch (PDOException $exception) {
            echo "Erro  " . $exception->getMessage();
           
        }
    }
    
    






}
?>