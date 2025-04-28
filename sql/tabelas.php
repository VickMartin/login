<!-- -- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/11/2024 às 23:30
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `educamentes`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
--

CREATE TABLE `aluno` (
  `matricula` int(11) NOT NULL,
  `nome` varchar(225) NOT NULL,
  `ano_ingresso` year(4) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `tipo_sanguineo` varchar(45) DEFAULT NULL,
  `deficiencia` varchar(255) DEFAULT NULL,
  `alergia` varchar(255) DEFAULT NULL,
  `nome_mae` varchar(105) DEFAULT NULL,
  `id_responsavel` int(11) NOT NULL,
  `id_adm` int(11) DEFAULT NULL,
  `id_turma` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aluno`
--

INSERT INTO `aluno` (`matricula`, `nome`, `ano_ingresso`, `data_nascimento`, `tipo_sanguineo`, `deficiencia`, `alergia`, `nome_mae`, `id_responsavel`, `id_adm`, `id_turma`, `foto`) VALUES
(42, 'Alice Silva Souza', '2024', '2003-05-25', 'B+', 'Aluno que tem uma condição médica que exige precauções em relação ao uso de medicamentos (alergia a penicilina). Recebe acompanhamento médico constante e tem um plano de saúde escolar específico.', 'Nula', 'Maria Souza Oliveira', 62, 3, 41, '674762be39c10_OIP.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `atestado`
--

CREATE TABLE `atestado` (
  `id_atestado` int(11) NOT NULL,
  `imagem_atestado` varchar(255) DEFAULT NULL,
  `data_atestado` datetime DEFAULT NULL,
  `id_aluno` int(11) DEFAULT NULL,
  `id_responsavel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `atestado`
--

INSERT INTO `atestado` (`id_atestado`, `imagem_atestado`, `data_atestado`, `id_aluno`, `id_responsavel`) VALUES
(13, '674763ba75b67_Atestado_aluno.png', '2024-11-27 00:00:00', 42, 62);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastroadm`
--

CREATE TABLE `cadastroadm` (
  `id_Adm` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cadastroadm`
--

INSERT INTO `cadastroadm` (`id_Adm`, `nome`, `email`, `senha`, `foto`) VALUES
(2, 'Ana Maria ', 'anamariamartins@gmail.com', '0000', '../uploads/672cca0bbb96b-Screenshot_20240612_154540_WhatsApp.jpg'),
(3, 'Vitória Cristina Martins e Martins', 'vihmartins330@gmail.com', '0000', '../uploads/672cce909aaeb-music wallpaper2.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagens`
--

CREATE TABLE `mensagens` (
  `id_mensagem` int(11) NOT NULL,
  `id_responsavel` int(11) NOT NULL,
  `id_turma` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `data_envio` datetime DEFAULT current_timestamp(),
  `id_professor` int(11) NOT NULL,
  `aluno_matricula` int(11) NOT NULL,
  `tipo_mensagem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `mensagens`
--

INSERT INTO `mensagens` (`id_mensagem`, `id_responsavel`, `id_turma`, `mensagem`, `data_envio`, `id_professor`, `aluno_matricula`, `tipo_mensagem`) VALUES
(35, 62, 41, 'Prezados pais,\r\n\r\nNa reunião realizada em [data], discutimos o desempenho acadêmico dos alunos, atividades extracurriculares e medidas de segurança na escola. Reforçamos a importância do acompanhamento familiar e a colaboração para um ambiente respeitoso e seguro. Agradecemos a participação e continuamos à disposição para qualquer dúvida.', '2024-11-27 15:33:11', 45, 42, 'Resumo de Reunião'),
(36, 62, 41, 'Prezados pais,\r\n\r\nInformo que recebi o atestado médico de Alice Silva Souza e registre sua falta. O dever de casa referente ao dia ausente foi repassado, e o aluno deve realizar as seguintes atividades:\r\n\r\nMatemática: páginas 13 a 14 do livro.', '2024-11-27 15:39:44', 45, 42, 'Atividade de Reposição');

-- --------------------------------------------------------

--
-- Estrutura para tabela `professores`
--

CREATE TABLE `professores` (
  `id_professor` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `data_contratacao` date NOT NULL DEFAULT curdate(),
  `nivel_academico` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `professores`
--

INSERT INTO `professores` (`id_professor`, `usuario_id`, `data_contratacao`, `nivel_academico`) VALUES
(45, 93, '2024-11-27', 'Licenciatura em Matemática e Pedagogia');

-- --------------------------------------------------------

--
-- Estrutura para tabela `registros`
--

CREATE TABLE `registros` (
  `id_registro` int(11) NOT NULL,
  `id_aluno` int(11) NOT NULL,
  `id_responsavel` int(11) NOT NULL,
  `documento` varchar(255) NOT NULL,
  `tipo_documento` enum('relatorio','notas') NOT NULL,
  `datetime` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `registros`
--

INSERT INTO `registros` (`id_registro`, `id_aluno`, `id_responsavel`, `documento`, `tipo_documento`, `datetime`) VALUES
(7, 42, 62, '67476484380e3_EX_Boletim.pdf', 'notas', '2024-11-27 00:00:00'),
(8, 42, 62, '674764973d64f_Relatório Semestral.pdf', 'relatorio', '2024-11-27 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `responsaveis`
--

CREATE TABLE `responsaveis` (
  `id_responsavel` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `endereco` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `responsaveis`
--

INSERT INTO `responsaveis` (`id_responsavel`, `usuario_id`, `telefone`, `endereco`) VALUES
(62, 92, '(61) 99619-8145', 'QND 34, Taguatinga Norte - DF');

-- --------------------------------------------------------

--
-- Estrutura para tabela `turmas`
--

CREATE TABLE `turmas` (
  `id_turma` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `ano` int(11) DEFAULT NULL,
  `professor_responsavel` int(11) DEFAULT NULL,
  `turno` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `turmas`
--

INSERT INTO `turmas` (`id_turma`, `nome`, `ano`, `professor_responsavel`, `turno`) VALUES
(41, '5º Ano \"c\" ', 2024, 45, 'Matutino');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `perfil` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `id_adm` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `cpf`, `perfil`, `senha`, `id_adm`) VALUES
(92, 'Maria Souza Oliveira', 'mariaoliveira@gmail.com', '666.666.666-60', 'responsavel', '0000', 3),
(93, 'João Pereira Costa', 'joaocosta330@gmail.com', '888.888.888-80', 'professor', '0000', 3);

--
-- Acionadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `atualiza_nome_mae` AFTER UPDATE ON `usuarios` FOR EACH ROW BEGIN
    UPDATE aluno
    SET nome_mae = NEW.nome -- Substitua 'nome_completo' pelo nome correto da coluna da tabela 'usuarios'
    WHERE id_responsavel = (
        SELECT id_responsavel
        FROM responsaveis
        WHERE usuario_id = NEW.id_usuario
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `atualizar_nome_responsavel` AFTER UPDATE ON `usuarios` FOR EACH ROW BEGIN
    -- Atualiza o nome do responsável na tabela aluno com base no id_responsavel
    UPDATE aluno
    SET nome_mae = NEW.nome  -- Supondo que o nome do responsável vai para o campo nome_mae
    WHERE id_responsavel = NEW.id_usuario;  -- Atualiza o registro do aluno que possui este responsável
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `professor_para_responsavel` AFTER UPDATE ON `usuarios` FOR EACH ROW BEGIN
    IF NEW.perfil = 'responsavel' AND OLD.perfil = 'professor' THEN
        -- Insere na tabela responsavel
        INSERT INTO responsaveis (usuario_id) VALUES (NEW.id_usuario);
        
        -- Remove da tabela professor, se necessário
        DELETE FROM professores WHERE usuario_id = NEW.id_usuario;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `responsavel_para_professor` AFTER UPDATE ON `usuarios` FOR EACH ROW BEGIN
    IF NEW.perfil = 'professor' AND OLD.perfil = 'responsavel' THEN
        -- Insere na tabela professor
        INSERT INTO professores (usuario_id) VALUES (NEW.id_usuario);
        
        -- Remove da tabela responsavel, se necessário
        DELETE FROM responsaveis WHERE usuario_id = NEW.id_usuario;
    END IF;
END
$$
DELIMITER ;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`matricula`),
  ADD KEY `fk_responsavel_id` (`id_responsavel`),
  ADD KEY `fk_aluno_adm` (`id_adm`),
  ADD KEY `fk_id_turma` (`id_turma`);

--
-- Índices de tabela `atestado`
--
ALTER TABLE `atestado`
  ADD PRIMARY KEY (`id_atestado`),
  ADD KEY `atestado_ibfk_1` (`id_aluno`),
  ADD KEY `atestado_ibfk_2` (`id_responsavel`);

--
-- Índices de tabela `cadastroadm`
--
ALTER TABLE `cadastroadm`
  ADD PRIMARY KEY (`id_Adm`);

--
-- Índices de tabela `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`id_mensagem`),
  ADD KEY `id_responsavel` (`id_responsavel`),
  ADD KEY `fk_id_professor` (`id_professor`),
  ADD KEY `mensagens_ibfk_4` (`aluno_matricula`),
  ADD KEY `mensagens_ibfk_3` (`id_turma`);

--
-- Índices de tabela `professores`
--
ALTER TABLE `professores`
  ADD PRIMARY KEY (`id_professor`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `registros_ibfk_1` (`id_aluno`),
  ADD KEY `registros_ibfk_2` (`id_responsavel`);

--
-- Índices de tabela `responsaveis`
--
ALTER TABLE `responsaveis`
  ADD PRIMARY KEY (`id_responsavel`),
  ADD KEY `fk_usuario_id` (`usuario_id`);

--
-- Índices de tabela `turmas`
--
ALTER TABLE `turmas`
  ADD PRIMARY KEY (`id_turma`),
  ADD KEY `professor_responsavel` (`professor_responsavel`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `fk_usuarios_adm` (`id_adm`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `matricula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `atestado`
--
ALTER TABLE `atestado`
  MODIFY `id_atestado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `cadastroadm`
--
ALTER TABLE `cadastroadm`
  MODIFY `id_Adm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `id_mensagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `professores`
--
ALTER TABLE `professores`
  MODIFY `id_professor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de tabela `registros`
--
ALTER TABLE `registros`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `responsaveis`
--
ALTER TABLE `responsaveis`
  MODIFY `id_responsavel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de tabela `turmas`
--
ALTER TABLE `turmas`
  MODIFY `id_turma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `aluno_ibfk_1` FOREIGN KEY (`id_responsavel`) REFERENCES `responsaveis` (`id_responsavel`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_aluno_adm` FOREIGN KEY (`id_adm`) REFERENCES `cadastroadm` (`id_Adm`),
  ADD CONSTRAINT `fk_id_turma` FOREIGN KEY (`id_turma`) REFERENCES `turmas` (`id_turma`) ON DELETE SET NULL;

--
-- Restrições para tabelas `atestado`
--
ALTER TABLE `atestado`
  ADD CONSTRAINT `atestado_ibfk_1` FOREIGN KEY (`id_aluno`) REFERENCES `aluno` (`matricula`) ON DELETE CASCADE,
  ADD CONSTRAINT `atestado_ibfk_2` FOREIGN KEY (`id_responsavel`) REFERENCES `responsaveis` (`id_responsavel`) ON DELETE CASCADE;

--
-- Restrições para tabelas `mensagens`
--
ALTER TABLE `mensagens`
  ADD CONSTRAINT `fk_id_professor` FOREIGN KEY (`id_professor`) REFERENCES `professores` (`id_professor`) ON DELETE CASCADE,
  ADD CONSTRAINT `mensagens_ibfk_2` FOREIGN KEY (`id_responsavel`) REFERENCES `responsaveis` (`id_responsavel`),
  ADD CONSTRAINT `mensagens_ibfk_3` FOREIGN KEY (`id_turma`) REFERENCES `turmas` (`id_turma`) ON DELETE CASCADE,
  ADD CONSTRAINT `mensagens_ibfk_4` FOREIGN KEY (`aluno_matricula`) REFERENCES `aluno` (`matricula`) ON DELETE CASCADE;

--
-- Restrições para tabelas `professores`
--
ALTER TABLE `professores`
  ADD CONSTRAINT `professores_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `registros_ibfk_1` FOREIGN KEY (`id_aluno`) REFERENCES `aluno` (`matricula`) ON DELETE CASCADE,
  ADD CONSTRAINT `registros_ibfk_2` FOREIGN KEY (`id_responsavel`) REFERENCES `responsaveis` (`id_responsavel`) ON DELETE CASCADE;

--
-- Restrições para tabelas `responsaveis`
--
ALTER TABLE `responsaveis`
  ADD CONSTRAINT `responsaveis_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `turmas`
--
ALTER TABLE `turmas`
  ADD CONSTRAINT `turmas_ibfk_1` FOREIGN KEY (`professor_responsavel`) REFERENCES `professores` (`id_professor`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_adm` FOREIGN KEY (`id_adm`) REFERENCES `cadastroadm` (`id_Adm`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */; -->
