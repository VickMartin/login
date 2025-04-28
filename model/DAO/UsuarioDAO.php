<?php
require_once'Conexao.php';
require_once'../model/DTO/UsuarioDTO.php';

class UsuarioDAO{
    public $pdo = null;
    //construtor da classe que estabelece a canexão com o banco de dados no momentoda criação do objeto DAO
    public function __construct(){
        $this->pdo = Conexao::getInstance();
    }


    public function cadastroUsuario(UsuarioDTO $UsuarioDTO, $idAdm, $telefone = null, $endereco = null, $formacao= null,) {
        try {
            // Inserir usuário na tabela 'usuarios'
            $sql = "INSERT INTO usuarios (nome, email, cpf, perfil, senha, id_adm) VALUES (?,?,?,?,?,?)";
            $stmt = $this->pdo->prepare($sql);
    
            $nome = $UsuarioDTO->getNome();
            $email = $UsuarioDTO->getEmail();
            $cpf = $UsuarioDTO->getCpf();
            $perfil = $UsuarioDTO->getPerfil();
            $senha = $UsuarioDTO->getSenha();
    
            // Associando os dados do usuário
            $stmt->execute([$nome, $email, $cpf, $perfil, $senha, $idAdm]);
    
            // Obtém o ID do usuário recém-cadastrado
            $idUsuario = $this->pdo->lastInsertId();
    
            // Verifica o perfil e cadastra na tabela correspondente
            if ($perfil === 'responsavel') {
                // Verifica se telefone e endereço foram fornecidos
                if (empty($telefone) || empty($endereco)) {
                    throw new Exception("Telefone e Endereço são obrigatórios para o perfil 'Responsável'.");
                }
    
                $sqlResponsavel = "INSERT INTO responsaveis (usuario_id, telefone, endereco) VALUES (?,?,?)";
                $stmtResponsavel = $this->pdo->prepare($sqlResponsavel);
                $stmtResponsavel->execute([$idUsuario, $telefone, $endereco]);
    
            } elseif ($perfil === 'professor') {
                // Verifica se telefone e endereço foram fornecidos
                if (empty($formacao) ) {
                    throw new Exception("Formação é obrigatório para o perfil 'Professor'.");
                }
                $sqlProfessor = "INSERT INTO professores (usuario_id, nivel_academico ) VALUES (?,?)";
                $stmtProfessor = $this->pdo->prepare($sqlProfessor);
                $stmtProfessor->execute([$idUsuario, $formacao]);
            }
    
            echo "Cadastro realizado com sucesso.";
            return ["status" => "success", "mensagem" => "Cadastro realizado com sucesso.", "id_usuario" => $idUsuario];
    
        } catch (PDOException $exe) {
            echo $exe->getMessage();
            return ["status" => "error", "mensagem" => $exe->getMessage()];
        } catch (Exception $exe) {
            echo $exe->getMessage();
            return ["status" => "error", "mensagem" => $exe->getMessage()];
        }
    }
    
    





    public function listarUsuarios() {
        try {
            // Consulta SQL para listar todos os usuários, sem filtrar pelo administrador
            $sql = "
                SELECT u.id_usuario, u.nome, u.email, u.cpf, u.perfil, p.id_professor, r.id_responsavel
                FROM usuarios AS u
                LEFT JOIN professores AS p ON u.id_usuario = p.usuario_id
                LEFT JOIN responsaveis AS r ON u.id_usuario = r.usuario_id
            ";
    
            // Prepara a consulta
            $stmt = $this->pdo->prepare($sql);
    
            // Executa a consulta
            $stmt->execute();
            
            // Retorna os dados dos usuários
            $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $retorno;
    
        } catch (PDOException $exe) {
            // Exibe a mensagem de erro em caso de exceção
            echo $exe->getMessage();
        }
    }
    
        
       
        
        public function excluirUsuario($id) {
            try {
                // Começa uma transação
                $this->pdo->beginTransaction();
        
                // Exclua as referências na tabela 'aluno'
                $sqlDeleteAluno = "DELETE FROM aluno WHERE id_responsavel = (SELECT id_responsavel FROM responsaveis WHERE usuario_id = :id_usuario)";
                $stmtAluno = $this->pdo->prepare($sqlDeleteAluno);
                $stmtAluno->bindParam(':id_usuario', $id, PDO::PARAM_INT);
                $stmtAluno->execute();
        
                // Exclua as referências na tabela 'responsaveis'
                $sqlDeleteResponsaveis = "DELETE FROM responsaveis WHERE usuario_id = :id_usuario";
                $stmtResponsaveis = $this->pdo->prepare($sqlDeleteResponsaveis);
                $stmtResponsaveis->bindParam(':id_usuario', $id, PDO::PARAM_INT);
                $stmtResponsaveis->execute();
        
                // Exclua as referências na tabela 'professores'
                $sqlDeleteProfessores = "DELETE FROM professores WHERE usuario_id = :id_usuario";
                $stmtProfessores = $this->pdo->prepare($sqlDeleteProfessores);
                $stmtProfessores->bindParam(':id_usuario', $id, PDO::PARAM_INT);
                $stmtProfessores->execute();
        
                // Em seguida, exclua o usuário na tabela 'usuarios'
                $sqlDeleteUsuario = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
                $stmtUsuario = $this->pdo->prepare($sqlDeleteUsuario);
                $stmtUsuario->bindParam(':id_usuario', $id, PDO::PARAM_INT);
        
                // Executa a exclusão
                $retorno = $stmtUsuario->execute();
        
                // Confirma a transação
                $this->pdo->commit();
        
                return $retorno;
            } catch (PDOException $exe) {
                // Desfaz a transação em caso de erro
                $this->pdo->rollBack();
                echo $exe->getMessage();
                return null;
            }
        }
        
    
            public function buscarUsuarioPorId($id) {
                try {
                    // Use um parâmetro nomeado corretamente
                    $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario;";
                    $stmt = $this->pdo->prepare($sql);
                    
                    // Liga o parâmetro
                    $stmt->bindParam(':id_usuario', $id, PDO::PARAM_INT);
                    
                    // Executa a consulta
                    $stmt->execute();
                    
                    // Busca o resultado da consulta em um array associativo
                    $retorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    return $retorno; // Retorna o resultado ou null se não encontrado
                    
                } catch (PDOException $exe) {
                    // Exibe a mensagem de erro em caso de exceção
                    echo $exe->getMessage();
                    
                }
            }
            
        
    
            public function buscarResponsavelPorCPF($cpf) {
                try {
                    // SQL ajustado para incluir as informações da tabela usuarios
                    $sql = "SELECT responsaveis.id_responsavel, usuarios.id_usuario, usuarios.cpf, usuarios.nome, usuarios.perfil
                            FROM responsaveis
                            INNER JOIN usuarios ON responsaveis.usuario_id = usuarios.id_usuario
                            WHERE usuarios.cpf = :cpf"; // Usando um parâmetro nomeado
                    
                    $stmt = $this->pdo->prepare($sql);
                    
                    // Liga o parâmetro
                    $stmt->bindParam(':cpf', $cpf);
                    
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
       
        
    
        public function listarProfessores() {
            try {
                // Consulta SQL para listar todos os professores, sem filtrar por id_adm
                $sql = "
                    SELECT u.id_usuario, u.nome, u.email, u.cpf, u.perfil, p.id_professor
                    FROM usuarios AS u
                    LEFT JOIN professores AS p ON u.id_usuario = p.usuario_id
                    WHERE p.id_professor IS NOT NULL
                ";
        
                // Prepara a consulta
                $stmt = $this->pdo->prepare($sql);
        
                // Executa a consulta
                $stmt->execute();
        
                // Retorna os dados dos professores
                $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $retorno;
        
            } catch (PDOException $exe) {
                // Exibe a mensagem de erro em caso de exceção
                echo $exe->getMessage();
            }
        }
        
        
    
        public function validarLogin($email, $senha) {
            // Supondo que você use PDO para a conexão com o banco de dados
            $sql = "SELECT * FROM usuarios WHERE email = :email AND senha = :senha LIMIT 1";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha); // Se estiver usando hash de senha, use password_verify aqui
            $stmt->execute();
    
            return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna os dados do usuário, incluindo o perfil
        }
    
    
        public function buscarIdProfessorPorUsuario($idUsuario) {
            $sql = "SELECT id_professor FROM professores WHERE usuario_id = :idUsuario";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna o ID do professor
        }
        
        
        public function buscarResponsavelPorId($id_responsavel) {
            try {
                // Usando a variável $this->pdo (a conexão com o banco de dados)
                $sql = "SELECT * FROM responsaveis WHERE id_responsavel = :id_responsavel";
                $stmt = $this->pdo->prepare($sql);  // Corrigido para usar $this->pdo
                $stmt->bindParam(':id_responsavel', $id_responsavel, PDO::PARAM_INT);  // Vincula o parâmetro
                $stmt->execute();  // Executa a consulta
        
                // Retorna os dados como array associativo
                return $stmt->fetch(PDO::FETCH_ASSOC);
        
            } catch (PDOException $exception) {
                echo "Erro na consulta: " . $exception->getMessage();
                return null;  // Retorna null em caso de erro
            }
        }
        
        
        public function buscarResponsavel($idUsuario) {
            $sql = "SELECT id_responsavel FROM responsaveis WHERE usuario_id = :idUsuario";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna o ID do professor
        }
    
    
        public function buscarIdusuarioPorIdprofessor($idProfessor) {
            // Consulta SQL com o parâmetro correto
            $sql = "SELECT usuario_id FROM professores WHERE id_professor = :id_professor";
            
            // Prepara a consulta
            $stmt = $this->pdo->prepare($sql);
            
            // Vincula o parâmetro :id_professor corretamente
            $stmt->bindParam(':id_professor', $idProfessor, PDO::PARAM_INT);
            
            // Executa a consulta
            $stmt->execute();
            
            // Retorna o resultado da consulta
            return $stmt->fetch(PDO::FETCH_ASSOC);  // Retorna o ID do professor ou null se não encontrado
        }
        
        public function buscarUsuario($id) {
            try {
                // Consulta SQL corrigida
                $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
                $stmt = $this->pdo->prepare($sql);
                
                // Liga o parâmetro
                $stmt->bindParam(':id_usuario', $id, PDO::PARAM_INT);
                
                // Executa a consulta
                $stmt->execute();
                
                // Busca o resultado da consulta
                $retorno = $stmt->fetch(PDO::FETCH_ASSOC);
                
                return $retorno; // Retorna o usuário ou null se não encontrado
                
            } catch (PDOException $exe) {
                echo $exe->getMessage();
            }
        }
    
    
        public function buscarEmail($email) {
            try{
                
                    $sql = "SELECT * FROM usuarios WHERE email = :email";
                    
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->bindParam(':email', $email);
                    
                    $stmt->execute();
                    
                    return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna os dados do usuário se encontrado
                
            }catch (PDOException $e) {
                // Captura qualquer exceção do PDO e registra o erro
                error_log("Erro : " . $e->getMessage());
                
            }
        }
    
        
        public function alterarSenha($email, $novaSenha) {
            try {
                // Verificar se o usuário existe pelo e-mail
                $sql = "SELECT id_usuario FROM usuarios WHERE email = :email";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                
                // Verifica se o usuário foi encontrado
                if ($stmt->rowCount() > 0) {
                    $dadosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idUsuario = $dadosUsuario['id_usuario'];
        
                    // Atualiza a senha do usuário
                    $sqlUpdate = "UPDATE usuarios 
                                  SET senha = :senha 
                                  WHERE id_usuario = :id_usuario";
                    $stmtUpdate = $this->pdo->prepare($sqlUpdate);
                    $stmtUpdate->bindParam(':senha', $novaSenha);
                    $stmtUpdate->bindParam(':id_usuario', $idUsuario);
                    
                    return $stmtUpdate->execute();
                } else {
                    // Usuário não encontrado pelo e-mail
                    echo "E-mail não encontrado.";
                    return false;
                }
            } catch (PDOException $e) {
                echo "Erro ao alterar a senha: " . $e->getMessage();
                return false;
            }
        }
        
        // Método para listar professores
    public function listarProfessoresUsuario() {
    $sql = "SELECT * FROM usuarios WHERE perfil = 'professor'"; // Filtra pelo perfil "professor"
    
    // Prepara a consulta
    $stmt = $this->pdo->prepare($sql);
    
    // Executa a consulta
    $stmt->execute();
    
    // Retorna todos os resultados da consulta como um array associativo
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarResponsaveisUsuario() {
        $sql = "SELECT * FROM usuarios WHERE perfil = 'responsavel'"; // Filtra pelo perfil "professor"
        
        // Prepara a consulta
        $stmt = $this->pdo->prepare($sql);
        
        // Executa a consulta
        $stmt->execute();
        
        // Retorna todos os resultados da consulta como um array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        
        public function buscarResponsavelIdUse($idUsuario) {
            // Seleciona todas as colunas da tabela responsaveis relacionadas ao id_usuario
            $sql = "SELECT * FROM responsaveis WHERE usuario_id = :idUsuario";
        
            try {
                // Prepara a consulta
                $stmt = $this->pdo->prepare($sql);
        
                // Verifica se o parâmetro foi vinculado corretamente
                $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
                
                // Executa a consulta
                $stmt->execute();
        
                // Verifica se há algum resultado
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($result) {
                    // Retorna as informações do responsável se encontrado
                    return $result;
                } else {
                    // Se não encontrar o responsável, retorna null ou false
                    return null;
                }
            } catch (PDOException $e) {
                // Caso ocorra erro na execução da consulta, exibe uma mensagem de erro
                echo "Erro: " . $e->getMessage();
                return false;
            }
        }
        
        public function buscarProfessorIdUse($idUsuario) {
            // Seleciona todas as colunas da tabela responsaveis relacionadas ao id_usuario
            $sql = "SELECT * FROM professores WHERE usuario_id = :idUsuario";
        
            try {
                // Prepara a consulta
                $stmt = $this->pdo->prepare($sql);
        
                // Verifica se o parâmetro foi vinculado corretamente
                $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
                
                // Executa a consulta
                $stmt->execute();
        
                // Verifica se há algum resultado
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($result) {
                    // Retorna as informações do responsável se encontrado
                    return $result;
                } else {
                    // Se não encontrar o responsável, retorna null ou false
                    return null;
                }
            } catch (PDOException $e) {
                // Caso ocorra erro na execução da consulta, exibe uma mensagem de erro
                echo "Erro: " . $e->getMessage();
                return false;
            }
        }
        
        
    public function alterarUsuario(UsuarioDTO $usuarioDTO) {
        try {
            $sql = "UPDATE usuarios 
                    SET nome = :nome, 
                        email = :email, 
                        cpf = :cpf, 
                        senha = :senha, 
                        perfil = :perfil 
                    WHERE id_usuario = :id_usuario";
                    
            $stmt = $this->pdo->prepare($sql);
    
            // Obtenha os valores do DTO
            $nome = $usuarioDTO->getNome();
            $email = $usuarioDTO->getEmail();
            $cpf = $usuarioDTO->getCpf();
            $senha = $usuarioDTO->getSenha();
            $perfil = $usuarioDTO->getPerfil();
            $id_usuario = $usuarioDTO->getId_usuario(); // Certifique-se de que isso existe no DTO
    
            // Vincule os parâmetros
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':perfil', $perfil);
            $stmt->bindParam(':id_usuario', $id_usuario);
    
            // Debug: Mostre a consulta SQL
            // Você pode usar var_dump para verificar os dados também
            // var_dump($stmt); // Para ver os parâmetros vinculados
            
            // Execute a atualização
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao alterar o usuário: " . $e->getMessage();
            return false;
        }
    }
        
    public function alterarInformaçãoResponsavel(UsuarioDTO $usuarioDTO) {
        try {
            // Corrigido: Removendo a vírgula extra
            $sql = "UPDATE responsaveis 
                    SET telefone = :telefone, 
                        endereco = :endereco
                    WHERE usuario_id = :usuario_id"; // Sem vírgula aqui
            
            $stmt = $this->pdo->prepare($sql);
    
            // Pegando os valores do DTO
            $telefone = $usuarioDTO->getTelefone();
            $endereco = $usuarioDTO->getEndereco();
            $usuario_id = $usuarioDTO->getId_usuario(); // Certifique-se de que o DTO tem esse método
    
            // Vinculando os parâmetros
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':endereco', $endereco);
            $stmt->bindParam(':usuario_id', $usuario_id); // Adicionando o parâmetro de usuario_id
    
            // Debug: Mostre a consulta SQL
            // var_dump($stmt); // Para ver os parâmetros vinculados
            
            // Execute a atualização
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao alterar o usuário: " . $e->getMessage();
            return false;
        }
    }
    
        
    
    public function buscarResponsavelId($idResponsavel) {
        // Seleciona todas as colunas da tabela responsaveis relacionadas ao id_usuario
        $sql = "SELECT * FROM responsaveis WHERE id_responsavel = :idResponsavel";
    
        try {
            // Prepara a consulta
            $stmt = $this->pdo->prepare($sql);
    
            // Verifica se o parâmetro foi vinculado corretamente
            $stmt->bindParam(':idResponsavel', $idResponsavel, PDO::PARAM_INT);
            
            // Executa a consulta
            $stmt->execute();
    
            // Verifica se há algum resultado
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                // Retorna as informações do responsável se encontrado
                return $result;
            } else {
                // Se não encontrar o responsável, retorna null ou false
                return null;
            }
        } catch (PDOException $e) {
            // Caso ocorra erro na execução da consulta, exibe uma mensagem de erro
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    public function buscarNome($idUsuario) {
        // Seleciona todas as colunas da tabela usuarios relacionadas ao idResponsavel
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :idUsuario";
        
        try {
            // Prepara a consulta
            $stmt = $this->pdo->prepare($sql);
            
            // Vincula o parâmetro ao valor de idResponsavel
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            
            // Executa a consulta
            $stmt->execute();
            
            // Verifica se há algum resultado
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Se encontrado, retorna os dados do responsável
            if ($result) {
                return $result;
            } else {
                // Caso não encontre, retorna null
                return null;
            }
        } catch (PDOException $e) {
            // Caso ocorra erro na execução da consulta, exibe uma mensagem detalhada de erro
            echo "Erro ao buscar responsável: " . $e->getMessage();
            return false;
        }
    }
    public function buscarResponsavelPorIdResponsavel($idResponsavel) {
        // Seleciona todas as colunas da tabela usuarios relacionadas ao idResponsavel
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :idResponsavel";
        
        try {
            // Prepara a consulta
            $stmt = $this->pdo->prepare($sql);
            
            // Vincula o parâmetro ao valor de idResponsavel
            $stmt->bindParam(':idResponsavel', $idResponsavel, PDO::PARAM_INT);
            
            // Executa a consulta
            $stmt->execute();
            
            // Verifica se há algum resultado
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Se encontrado, retorna os dados do responsável
            if ($result) {
                return $result;
            } else {
                // Caso não encontre, retorna null
                return null;
            }
        } catch (PDOException $e) {
            // Caso ocorra erro na execução da consulta, exibe uma mensagem detalhada de erro
            echo "Erro ao buscar responsável: " . $e->getMessage();
            return false;
        }
    }
    





} 
