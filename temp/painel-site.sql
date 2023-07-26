-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/07/2023 às 15:31
-- Versão do servidor: 10.4.19-MariaDB
-- Versão do PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `painel`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_transparencia`
--

CREATE TABLE `tipo_transparencia` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `tipo_transparencia`
--

INSERT INTO `tipo_transparencia` (`id`, `titulo`) VALUES
(1, 'DOCUMENTOS INSTITUCIONAIS'),
(2, 'BALANCETES CONTABEIS'),
(3, 'BALANÇO PATRIMONIAL'),
(6, 'PLANO DE TRABALHO'),
(7, 'TERMOS DE AJUSTES DE VERBAS PUBLICAS (PARCERIAS)'),
(8, 'RELAÇAO DE FORNECEDORES'),
(9, 'RELAÇAO DE FUNCIONARIOS'),
(10, 'VALORES REPASSADOS'),
(11, 'PRESTAÇAO DE CONTAS PUBLICAS');

-- --------------------------------------------------------

--
-- Estrutura para tabela `transparencia`
--

CREATE TABLE `transparencia` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `tipoid` int(11) NOT NULL,
  `ano` varchar(20) DEFAULT NULL,
  `src` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) NOT NULL,
  `email` varchar(220) NOT NULL,
  `login` varchar(220) NOT NULL,
  `senha` varchar(220) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `nome`, `email`, `login`, `senha`) VALUES
(1, 'Admin', 'admin@painel.org.br', 'admin', '$2y$10$a5Z7xFOKtqiAMXdWfrKCTuBgnyjcbbfsuZuOQoTp0/40vn2cXqVty');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tipo_transparencia`
--
ALTER TABLE `tipo_transparencia`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `transparencia`
--
ALTER TABLE `transparencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transparencia_fk` (`tipoid`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tipo_transparencia`
--
ALTER TABLE `tipo_transparencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `transparencia`
--
ALTER TABLE `transparencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `transparencia`
--
ALTER TABLE `transparencia`
  ADD CONSTRAINT `transparencia_ibfk_1` FOREIGN KEY (`tipoid`) REFERENCES `tipo_transparencia` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
