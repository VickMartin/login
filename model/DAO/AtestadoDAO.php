<?php
require_once 'Conexao.php';
require_once '../model/DTO/AtestadoDTO.php';

class AtestadoDAO{
    public $pdo = null;
    //construtor da classe que estabelece a canexão com o banco de dados no momentoda criação do objeto DAO
    public function __construct(){
        $this->pdo = Conexao::getInstance();
    }

    public function inserirAtestado(AtestadoDTO $atestadoDTO) {
        try {
            $sql = "INSERT INTO atestado (imagem_atestado, data_atestado, id_aluno, id_responsavel) 
                    VALUES (?,?,?,?)";
            
            $stmt = $this->pdo->prepare($sql);

            $imagem_atestado = $atestadoDTO->getImagemAtestado();
            $data_atestado = $atestadoDTO->getDataAtestado();
            $id_aluno = $atestadoDTO->getIdAluno();
            $id_responsavel = $atestadoDTO->getIdResponsavel();
            
    
            // Associando o ID do administrador
            $stmt->bindValue(1, $imagem_atestado);
            $stmt->bindValue(2, $data_atestado);
            $stmt->bindValue(3, $id_aluno);
            $stmt->bindValue(4, $id_responsavel);
          
            

            return $stmt->execute();  // Retorna true se a inserção foi bem-sucedida
        } catch (PDOException $e) {
            echo "Erro ao inserir mensagem: " . $e->getMessage();
            
        }
    }

    public function listarAtestadosPorAluno($id_aluno) {
        try {
            $sql = "SELECT * FROM atestado WHERE id_aluno = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $id_aluno, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Retorna um array de atestados
        } catch (PDOException $e) {
            echo "Erro ao listar atestados do aluno: " . $e->getMessage();
        }
    } 
}