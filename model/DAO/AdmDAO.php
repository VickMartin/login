<?php

require_once'Conexao.php';

class AdmDAO{
    //estabelecer conexão com o banco de dados
    public $pdo = null;
    //construtor da classe que estabelece a canexão com o banco de dados no momentoda criação do objeto DAO
    public function __construct(){
        $this->pdo = Conexao::getInstance();
    }

    public function validarLogin($email, $senha) {
        try {
            $sql = "SELECT * FROM cadastroadm WHERE email = :email AND senha = :senha;";
            $stml = $this->pdo->prepare($sql);
            $stml->bindParam(':email', $email);
            $stml->bindParam(':senha', $senha);
            $stml->execute();
    
            // Busca o resultado como um array associativo
            $retorno = $stml->fetch(PDO::FETCH_ASSOC);
    
            return $retorno;
        } catch(PDOException $exe) {
            echo $exe->getMessage();
        }
    }
    
    

    public function buscarDadosAdministrador($email) {
        
        $sql = "SELECT id_Adm, nome, email, foto FROM cadastroadm WHERE email = :email"; // Ajuste conforme sua tabela
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function atualizarAdministrador(AdmDTO $admDTO) {
        try {
            $query = "UPDATE cadastroadm SET nome = :nome, email = :email" . 
                     ($admDTO->getFoto() ? ", foto = :foto" : "") . 
                     " WHERE id_Adm = :id_Adm";
    
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':nome', $admDTO->getNome());
            $stmt->bindValue(':email', $admDTO->getEmail());
            $stmt->bindValue(':id_Adm', $admDTO->getIdAdm());
            
            // Bind the foto only if it's set
            if ($admDTO->getFoto()) {
                $stmt->bindValue(':foto', $admDTO->getFoto());
            }
    
            // Executa a consulta
            if (!$stmt->execute()) {
                // Se a execução falhar, obtenha os erros
                $errors = $stmt->errorInfo();
                error_log("Erro ao atualizar o administrador: " . implode(", ", $errors));
                return false;
            }
    
            return true; // Retorna true se a atualização for bem-sucedida
        } catch (PDOException $e) {
            // Captura qualquer exceção do PDO e registra o erro
            error_log("Erro PDO ao atualizar administrador: " . $e->getMessage());
            return false;
        }
    }
    
    public function buscarEmail($email) {
        try{
        $sql = "SELECT * FROM cadastroadm WHERE email = :email";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna os dados do administrador se encontrado
    }catch (PDOException $e) {
        // Captura qualquer exceção do PDO e registra o erro
        error_log("Erro : " . $e->getMessage());
        
    }
}

public function alterarSenha($email, $novaSenha) {
    try {
        // Verificar se o administrador existe pelo e-mail
        $sql = "SELECT id_Adm FROM cadastroadm WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Verifica se o administrador foi encontrado
        if ($stmt->rowCount() > 0) {
            $dadosAdm = $stmt->fetch(PDO::FETCH_ASSOC);
            $idAdm = $dadosAdm['id_Adm'];

            // Atualiza a senha do administrador
            $sqlUpdate = "UPDATE cadastroadm 
                          SET senha = :senha 
                          WHERE id_Adm = :id_Adm";
            $stmtUpdate = $this->pdo->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':senha', $novaSenha); // Note que você pode querer usar password_hash aqui
            $stmtUpdate->bindParam(':id_Adm', $idAdm);
            
            return $stmtUpdate->execute();
        } else {
            // Administrador não encontrado pelo e-mail
            echo "E-mail não encontrado.";
            return false;
        }
    } catch (PDOException $e) {
        echo "Erro ao alterar a senha do administrador: " . $e->getMessage();
        return false;
    }
}


   
    
    
    






















    }
  









   
    




?>