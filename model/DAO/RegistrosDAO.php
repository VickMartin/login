<?php
require_once 'Conexao.php';
require_once '../model/DTO/RegistrosDTO.php';

class RegistrosDAO{
    public $pdo = null;
    //construtor da classe que estabelece a canexão com o banco de dados no momentoda criação do objeto DAO
    public function __construct(){
        $this->pdo = Conexao::getInstance();
    }



    // Função para inserir um novo registro no banco de dados
    public function inserirRegistro(RegistrosDTO $registroDTO) {
        try {
            $sql = "INSERT INTO registros (documento, tipo_documento, id_aluno, id_responsavel, datetime) 
                    VALUES (?, ?, ?, ?, ?)";
            
            $stmt = $this->pdo->prepare($sql);

            // Preparando os dados do DTO para inserir no banco
            $documento = $registroDTO->getDocumento();
            $tipo_documento = $registroDTO->getTipoDocumento();
            $id_aluno = $registroDTO->getIdAluno();
            $id_responsavel = $registroDTO->getIdResponsavel();
            $datetime = $registroDTO->getDatetime();

            // Associando os parâmetros
            $stmt->bindValue(1, $documento);
            $stmt->bindValue(2, $tipo_documento);
            $stmt->bindValue(3, $id_aluno);
            $stmt->bindValue(4, $id_responsavel);
            $stmt->bindValue(5, $datetime);

            // Executando a inserção
            return $stmt->execute();  // Retorna true se a inserção for bem-sucedida
        } catch (PDOException $e) {
            echo "Erro ao inserir registro: " . $e->getMessage();
            return false;
        }
    }

    public function listarRelatoriosPorAluno($matricula) {
        try {
            // Consulta SQL modificada para ordenar pela data de forma decrescente
            $sql = "SELECT * FROM registros WHERE id_aluno = ? ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $matricula);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar relatórios: " . $e->getMessage();
           
        }
    }


}
?>

