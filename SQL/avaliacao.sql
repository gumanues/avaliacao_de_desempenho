-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/02/2024 às 23:50
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `avaliacao`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `colab`
--

CREATE TABLE `colab` (
  `id` int(11) NOT NULL,
  `nota1` int(11) DEFAULT NULL,
  `nota2` int(11) DEFAULT NULL,
  `nota3` int(11) DEFAULT NULL,
  `nota4` int(11) DEFAULT NULL,
  `nota5` int(11) DEFAULT NULL,
  `nota6` int(11) DEFAULT NULL,
  `nota7` int(11) DEFAULT NULL,
  `nota8` int(11) DEFAULT NULL,
  `nota9` int(11) DEFAULT NULL,
  `nota10` int(11) DEFAULT NULL,
  `setor` int(11) NOT NULL,
  `data` year(4) NOT NULL,
  `idsupervisor` int(11) DEFAULT NULL,
  `idusuarios` int(11) NOT NULL,
  `perguntaid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `coord`
--

CREATE TABLE `coord` (
  `id` int(11) NOT NULL,
  `nota1` int(11) DEFAULT NULL,
  `nota2` int(11) DEFAULT NULL,
  `nota3` int(11) DEFAULT NULL,
  `nota4` int(11) DEFAULT NULL,
  `nota5` int(11) DEFAULT NULL,
  `nota6` int(11) DEFAULT NULL,
  `nota7` int(11) DEFAULT NULL,
  `nota8` int(11) DEFAULT NULL,
  `nota9` int(11) DEFAULT NULL,
  `nota10` int(11) DEFAULT NULL,
  `setor` int(11) NOT NULL,
  `data` year(4) NOT NULL,
  `idsupervisor` int(11) DEFAULT NULL,
  `idusuarios` int(11) NOT NULL,
  `perguntaid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `delega_acoes`
--

CREATE TABLE `delega_acoes` (
  `id` int(11) NOT NULL,
  `ano_vigente` int(11) NOT NULL,
  `ds_ano_vigente` varchar(255) NOT NULL,
  `avalid_reter` varchar(11) NOT NULL,
  `ds_avalid_reter` varchar(255) NOT NULL,
  `avausu_reter` varchar(11) NOT NULL,
  `ds_avausu_reter` varchar(255) NOT NULL,
  `usu_esp_colab` varchar(11) NOT NULL,
  `ds_usu_esp_colab` varchar(255) NOT NULL,
  `usu_com_geren` varchar(11) NOT NULL,
  `ds_usu_com_geren` varchar(255) NOT NULL,
  `usu_com_geren_reter` varchar(11) NOT NULL,
  `ds_usu_com_geren_reter` varchar(255) NOT NULL,
  `geren_reter` varchar(11) NOT NULL,
  `ds_geren_reter` varchar(255) NOT NULL,
  `acess_av_reter` varchar(11) NOT NULL,
  `ds_acess_av_reter` varchar(255) NOT NULL,
  `lid_acess_lid_reter` varchar(11) NOT NULL,
  `ds_lid_acess_lid_reter` varchar(255) NOT NULL,
  `lid_acess_ger_reter` varchar(11) NOT NULL,
  `ds_lid_acess_ger_reter` varchar(255) NOT NULL,
  `acess_avaliacao` varchar(11) NOT NULL,
  `ds_acess_avaliacao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `delega_acoes`
--

INSERT INTO `delega_acoes` (`id`, `ano_vigente`, `ds_ano_vigente`, `avalid_reter`, `ds_avalid_reter`, `avausu_reter`, `ds_avausu_reter`, `usu_esp_colab`, `ds_usu_esp_colab`, `usu_com_geren`, `ds_usu_com_geren`, `usu_com_geren_reter`, `ds_usu_com_geren_reter`, `geren_reter`, `ds_geren_reter`, `acess_av_reter`, `ds_acess_av_reter`, `lid_acess_lid_reter`, `ds_lid_acess_lid_reter`, `lid_acess_ger_reter`, `ds_lid_acess_ger_reter`, `acess_avaliacao`, `ds_acess_avaliacao`) VALUES
(1, 2023, 'Define o Ano vigênte da Avaliação', '2,6,39', 'Estatísticas - Retém nome do avaliado com login de Gerência na avaliação líderes da pagina (avaliacoes_lideres.php)', '1,39', 'Estatísticas - Retém nome de avaliado na avaliações usuários da página (avaliacoes_usuarios.php)', '2', 'Avaliações Colaboradores - Usuários com acesso de gerência para aparecerem na auto-avaliação dos colaboradores da página (colaboradores.php)', '39,43', 'Acesso Especial - Acesso gerênte especial, usuários comuns como gerência de pessoa específica da pagina (gerencia.php)', '4', 'Acesso Especial - Usuários destinado a avaliação do gerênte especial, depende do parâmetro 4 na página (gerencia.php)', '2,4,6,39', 'Avaliação Gerência - Retem nome de avaliado às *Avaliações da Gerência* na página (gerencia.php) e (lider-gerencia.php)', '6', 'Auto-avaliação Coordenadores - Retem acesso coordenador de realizar a auto-avaliação, *para terceiros* na página (lider-colaboradores.php)', '1,43', 'Avaliação Gerência - Concede acesso total à Avaliação *Gerência avalia competência liderança* na pagina (log-lider.php)', '1', 'Avaliação Gerência - Concede acesso parcial à Avaliação *Gerência avalia competências gerais* na página (log-lider.php)', '1,2,39', 'Estatísticas - Concede acesso às avaliações na página (log-lider.php)');

-- --------------------------------------------------------

--
-- Estrutura para tabela `gerencia`
--

CREATE TABLE `gerencia` (
  `id` int(11) NOT NULL,
  `nota1` int(11) DEFAULT NULL,
  `nota2` int(11) DEFAULT NULL,
  `nota3` int(11) DEFAULT NULL,
  `nota4` int(11) DEFAULT NULL,
  `nota5` int(11) DEFAULT NULL,
  `nota6` int(11) DEFAULT NULL,
  `nota7` int(11) DEFAULT NULL,
  `nota8` int(11) DEFAULT NULL,
  `nota9` int(11) DEFAULT NULL,
  `nota10` int(11) DEFAULT NULL,
  `setor` int(11) NOT NULL,
  `data` year(4) NOT NULL,
  `idsupervisor` int(11) DEFAULT NULL,
  `idusuarios` int(11) NOT NULL,
  `perguntaid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `lidercoord`
--

CREATE TABLE `lidercoord` (
  `id` int(11) NOT NULL,
  `nota1` int(11) DEFAULT NULL,
  `nota2` int(11) DEFAULT NULL,
  `nota3` int(11) DEFAULT NULL,
  `nota4` int(11) DEFAULT NULL,
  `nota5` int(11) DEFAULT NULL,
  `nota6` int(11) DEFAULT NULL,
  `nota7` int(11) DEFAULT NULL,
  `nota8` int(11) DEFAULT NULL,
  `nota9` int(11) DEFAULT NULL,
  `nota10` int(11) DEFAULT NULL,
  `setor` int(11) NOT NULL,
  `data` year(4) NOT NULL,
  `idsupervisor` int(11) DEFAULT NULL,
  `idusuarios` int(11) NOT NULL,
  `perguntaid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `modifica_pergunta`
--

CREATE TABLE `modifica_pergunta` (
  `id` int(11) NOT NULL,
  `gerencia` int(11) DEFAULT NULL,
  `lidercoord` int(11) DEFAULT NULL,
  `colab` int(11) DEFAULT NULL,
  `coord` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `modifica_pergunta`
--

INSERT INTO `modifica_pergunta` (`id`, `gerencia`, `lidercoord`, `colab`, `coord`) VALUES
(1, 2, 1, 1, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pergunta`
--

CREATE TABLE `pergunta` (
  `id` int(11) NOT NULL,
  `pergunta1` varchar(255) DEFAULT NULL,
  `pergunta2` varchar(255) DEFAULT NULL,
  `pergunta3` varchar(255) DEFAULT NULL,
  `pergunta4` varchar(255) DEFAULT NULL,
  `pergunta5` varchar(255) DEFAULT NULL,
  `pergunta6` varchar(255) DEFAULT NULL,
  `pergunta7` varchar(255) DEFAULT NULL,
  `pergunta8` varchar(255) DEFAULT NULL,
  `pergunta9` varchar(255) DEFAULT NULL,
  `pergunta10` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `pergunta`
--

INSERT INTO `pergunta` (`id`, `pergunta1`, `pergunta2`, `pergunta3`, `pergunta4`, `pergunta5`, `pergunta6`, `pergunta7`, `pergunta8`, `pergunta9`, `pergunta10`) VALUES
(1, 'Trabalho em Equipe', 'Foco em resultados', 'Flexibilidade', 'Produtividade', 'Relacionamento Interpessoal', 'Comportamento Ético', 'Comunicação', 'Conhecimento Técnico', '', ''),
(2, 'Realiza reuniões Periódicas?', 'Realiza treinamento para desenvolvimento da equipe?', 'Delega tarefas aos funcionários?', 'Cumpre com os prazos estabelecidos nos processos da Qualidade?', 'Divulga resultados de seus processos/indicadores para a instituição?', 'Age com decisão, enfrenta os problemas?', 'Administra custos efetivamente?', 'Fornece feedbacks aos seus liderados? Evidenciar.', 'Monitora o desempenho dos seus liderados?', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `setor`
--

CREATE TABLE `setor` (
  `id` int(11) NOT NULL,
  `setor` varchar(255) DEFAULT NULL,
  `situacao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `setor`
--

INSERT INTO `setor` (`id`, `setor`, `situacao`) VALUES
(1, 'Procedimentos Ambulatoriais', '1'),
(2, 'Centro Cirúrgico', '1'),
(3, 'Faturamento', '1'),
(4, 'Compras', '1'),
(5, 'Recepção', '1'),
(6, 'Farmácia', '1'),
(7, 'Qualidade', '1'),
(8, 'Recursos Humanos', '1'),
(9, 'Informática', '1'),
(10, 'Gerência', '1'),
(11, 'Financeiro', '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nomecompleto` varchar(255) NOT NULL,
  `situacao` int(11) NOT NULL,
  `cargo` varchar(255) NOT NULL,
  `senha` longtext NOT NULL,
  `lider` int(11) NOT NULL,
  `setorid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nomecompleto`, `situacao`, `cargo`, `senha`, `lider`, `setorid`) VALUES
(1, 'Joana Gerênte', 1, 'Gerente Geral', '', 2, 10),
(2, 'Alisson RH', 1, 'Recursos Humanos', '', 2, 8),
(3, 'Indianara', 1, 'Coordenadora Recepção', '', 1, 5),
(4, 'Flaviane', 1, 'Coordenadora Amb', '', 1, 1),
(5, 'Luísa ', 1, 'Coordenadora Faturamento', '', 1, 3),
(6, 'Pâmela', 1, 'Coordenador TI', '', 1, 9),
(7, 'Maiara', 1, 'Coordenadora Farmácia', '', 1, 6),
(8, 'Alexsandro', 1, 'Enfermeiro', 'a', 0, 1),
(9, 'Diego', 1, 'Enfermeiro', 'a', 0, 1),
(10, 'Fernando', 1, 'Enfermeiro', 'a', 0, 1),
(15, 'Elisangela', 1, 'Enfermeira', 'a', 0, 2),
(16, 'Daiana', 1, 'Enfermeira', 'a', 0, 2),
(17, 'Alexandra', 1, 'Enfermeira', 'a', 0, 2),
(18, 'Jussara', 1, 'Enfermeira', 'a', 0, 2),
(19, 'Lucia', 1, 'Faturamento', 'a', 0, 3),
(20, 'Simone ', 1, 'Faturamento', 'a', 0, 3),
(21, 'João', 1, 'Faturamento', 'a', 0, 3),
(22, 'Tania', 1, 'Compras', 'a', 0, 4),
(23, 'Katia', 1, 'Recepcionista', 'a', 0, 5),
(24, 'Andreia', 1, 'Recepcionista', 'a', 0, 5),
(25, 'Fernanda', 0, 'Recepcionista', '', 0, 5),
(26, 'Pablo', 0, 'Recepcionista', '', 0, 5),
(27, 'Henrique', 0, 'Recepcionista', '', 0, 5),
(28, 'Dayane', 1, 'Recepcionista', 'a', 0, 5),
(29, 'Jefferson', 1, 'Recepcionista', 'a', 0, 5),
(30, 'Késia', 1, 'Recepcionista', 'a', 0, 5),
(31, 'Guilherme', 1, 'Recepcionista', 'a', 0, 5),
(32, 'Leticia', 1, 'Recepcionista', 'a', 0, 5),
(33, 'Isabel', 1, 'Recepcionista', 'a', 0, 5),
(34, 'Maria', 1, 'Recepcionista', '', 0, 5),
(35, 'Jussara', 1, 'Recepcionista', 'a', 0, 5),
(36, 'Patricia ', 1, 'Recepcionista', 'a', 0, 5),
(37, 'Viviano', 1, 'Recepcionista', 'a', 0, 5),
(38, 'Joana', 1, 'Estagiaria', 'a', 0, 6),
(39, 'Acesso TI', 1, 'TI', 'e00fba6fedfb8a49e13346f7099a23fc', 2, 9),
(40, 'Diego ', 0, 'TI', '', 0, 9),
(41, 'Vanessa', 1, 'Financeiro', 'a', 0, 11),
(42, 'Gislaine', 1, 'Qualidade', 'a', 0, 7),
(43, 'Fabricia', 1, 'Coordenadora Enfermagem', '', 2, 2),
(44, 'Valéria', 1, 'Financeiro', '', 1, 11),
(45, 'Sarah', 1, 'Recepcionista', 'a', 0, 5),
(46, 'Gabriela', 1, 'Recepcionista', 'a', 0, 5),
(47, 'Gustavo Manuel Espindola', 1, 'TI', 'a', 0, 9);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `colab`
--
ALTER TABLE `colab`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_colabcoord_usuarios1_idx` (`idusuarios`),
  ADD KEY `fk_colab_pergunta1_idx` (`perguntaid`);

--
-- Índices de tabela `coord`
--
ALTER TABLE `coord`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_colabcoord_usuarios1_idx` (`idusuarios`),
  ADD KEY `fk_coord_pergunta1_idx` (`perguntaid`);

--
-- Índices de tabela `delega_acoes`
--
ALTER TABLE `delega_acoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `gerencia`
--
ALTER TABLE `gerencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_colabcoord_usuarios1_idx` (`idusuarios`),
  ADD KEY `fk_gerencia_pergunta1_idx` (`perguntaid`);

--
-- Índices de tabela `lidercoord`
--
ALTER TABLE `lidercoord`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_colabcoord_usuarios1_idx` (`idusuarios`),
  ADD KEY `fk_lidercoord_pergunta1_idx` (`perguntaid`);

--
-- Índices de tabela `modifica_pergunta`
--
ALTER TABLE `modifica_pergunta`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pergunta`
--
ALTER TABLE `pergunta`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `setor`
--
ALTER TABLE `setor`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `fk_usuarios_setor1_idx` (`setorid`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `colab`
--
ALTER TABLE `colab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT de tabela `coord`
--
ALTER TABLE `coord`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de tabela `delega_acoes`
--
ALTER TABLE `delega_acoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `gerencia`
--
ALTER TABLE `gerencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de tabela `lidercoord`
--
ALTER TABLE `lidercoord`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de tabela `modifica_pergunta`
--
ALTER TABLE `modifica_pergunta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `pergunta`
--
ALTER TABLE `pergunta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `setor`
--
ALTER TABLE `setor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `colab`
--
ALTER TABLE `colab`
  ADD CONSTRAINT `fk_colab_pergunta1` FOREIGN KEY (`perguntaid`) REFERENCES `pergunta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_colabcoord_usuarios1` FOREIGN KEY (`idusuarios`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `coord`
--
ALTER TABLE `coord`
  ADD CONSTRAINT `fk_colabcoord_usuarios11` FOREIGN KEY (`idusuarios`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_coord_pergunta1` FOREIGN KEY (`perguntaid`) REFERENCES `pergunta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `gerencia`
--
ALTER TABLE `gerencia`
  ADD CONSTRAINT `fk_colabcoord_usuarios1101` FOREIGN KEY (`idusuarios`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_gerencia_pergunta1` FOREIGN KEY (`perguntaid`) REFERENCES `pergunta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `lidercoord`
--
ALTER TABLE `lidercoord`
  ADD CONSTRAINT `fk_colabcoord_usuarios110` FOREIGN KEY (`idusuarios`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lidercoord_pergunta1` FOREIGN KEY (`perguntaid`) REFERENCES `pergunta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuarios_setor1` FOREIGN KEY (`setorid`) REFERENCES `setor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
