<?php
require_once'Conexao.php';
require_once'../model/DTO/MensagemDTO.php';

class MensagemDAO{
    public $pdo = null;
    //construtor da classe que estabelece a canexão com o banco de dados no momentoda criação do objeto DAO
    public function __construct(){
        $this->pdo = Conexao::getInstance();
    }

    public function inserirMensagem(MensagemDTO $mensagemDTO) {
        try {
            $sql = "INSERT INTO mensagens (aluno_matricula, id_responsavel, id_turma, id_professor, mensagem,tipo_mensagem) 
                    VALUES (?,?,?,?,?,?)";
            
            $stmt = $this->pdo->prepare($sql);

            $aluno_matricula = $mensagemDTO->getAlunoMatricula();
            $id_responsavel = $mensagemDTO->getIdResponsavel();
            $id_turma = $mensagemDTO->getIdTurma();
            $id_professor = $mensagemDTO->getIdProfessor();
            $mensagem = $mensagemDTO->getMensagem();
            $tipo_mensagem = $mensagemDTO->getTipoMensagem();
    
            // Associando o ID do administrador
            $stmt->bindValue(1, $aluno_matricula);
            $stmt->bindValue(2, $id_responsavel);
            $stmt->bindValue(3, $id_turma);
            $stmt->bindValue(4, $id_professor);
            $stmt->bindValue(5, $mensagem);
            $stmt->bindValue(6, $tipo_mensagem);
            

            return $stmt->execute();  // Retorna true se a inserção foi bem-sucedida
        } catch (PDOException $e) {
            echo "Erro ao inserir mensagem: " . $e->getMessage();
            
        }
    }

    public function buscarMensagensPorAluno($matricula) {
        try {
            // Preparando a consulta SQL para buscar mensagens com base na matrícula
            $sql = "SELECT * FROM mensagens WHERE aluno_matricula = :matricula ORDER BY data_envio DESC;";
            $stmt = $this->pdo->prepare($sql);
    
            // Ligando o parâmetro nomeado :matricula
            $stmt->bindParam(':matricula', $matricula, PDO::PARAM_STR);
    
            // Executando a consulta
            $stmt->execute();
    
            // Buscando todas as mensagens em um array associativo
            $mensagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $mensagens; // Retorna o array de mensagens ou um array vazio caso não haja mensagens
    
        } catch (PDOException $exe) {
            // Em caso de erro, exibe a mensagem de exceção
            echo "Erro ao buscar mensagens: " . $exe->getMessage();
            return []; // Retorna um array vazio em caso de erro
        }
    }
    
















}
?>