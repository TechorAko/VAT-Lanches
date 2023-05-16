-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05-Maio-2023 às 20:05
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `vatlanches`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblcliente`
--

CREATE TABLE `tblcliente` (
  `codigocliente` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cpf` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(320) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(19) COLLATE utf8_unicode_ci NOT NULL,
  `endereco` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tblcliente`
--

INSERT INTO `tblcliente` (`codigocliente`, `nome`, `cpf`, `email`, `telefone`, `endereco`) VALUES
(1, 'Letícia Hannah', '123.456.789-12', 'leticiahannah@hotmail.com', '+55 (32) 1234-5678', 'Rua Machado Cortando Árvore da Silva Pereira'),
(2, 'Otávio Bigogno', '123.456.789-12', 'otaviobigogno@gmail.com', '+55 (32) 1234-5678', 'Rua Maria Não Sei Das Quantas Jesuis'),
(3, 'Leonardo Lacerda', '219.876.654-43', 'leonardolacerda@hotmail.com', '+55 (32) 9876-5432', 'Rua Onde O Judas Perdeu As Botas Da Minha Perspectiva'),
(5, 'Gabriel Cavalhiere', '152.238.126-03', 'gabrielcavalhiere2@gmail.com', '+55 (32) 99127-7540', 'Rua São Francisco Almeida Gama');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblencomenda`
--

CREATE TABLE `tblencomenda` (
  `codigoencomenda` int(11) NOT NULL,
  `codigocliente` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(16) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tblencomenda`
--

INSERT INTO `tblencomenda` (`codigoencomenda`, `codigocliente`, `data`, `status`) VALUES
(3, 1, '2023-05-04 17:25:28', 'Em processamento');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblitens`
--

CREATE TABLE `tblitens` (
  `codigoitem` int(11) NOT NULL,
  `codigoencomenda` int(11) NOT NULL,
  `codigoproduto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tblitens`
--

INSERT INTO `tblitens` (`codigoitem`, `codigoencomenda`, `codigoproduto`, `quantidade`) VALUES
(1, 3, 1, 1),
(2, 3, 2, 1),
(3, 3, 3, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblproduto`
--

CREATE TABLE `tblproduto` (
  `codigoproduto` int(11) NOT NULL,
  `categoria` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `preco` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tblproduto`
--

INSERT INTO `tblproduto` (`codigoproduto`, `categoria`, `descricao`, `preco`) VALUES
(1, 'Bebida', 'Coca-Cola', '9.90'),
(2, 'Lanche', 'Misto Quente', '4.49'),
(3, 'Sobremesa', 'Açai', '14.90'),
(4, 'Bebida', 'Fanta Laranja', '8.49');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tblcliente`
--
ALTER TABLE `tblcliente`
  ADD PRIMARY KEY (`codigocliente`);

--
-- Índices para tabela `tblencomenda`
--
ALTER TABLE `tblencomenda`
  ADD PRIMARY KEY (`codigoencomenda`),
  ADD KEY `fk_tblencomenda_tblcliente` (`codigocliente`);

--
-- Índices para tabela `tblitens`
--
ALTER TABLE `tblitens`
  ADD PRIMARY KEY (`codigoitem`),
  ADD KEY `fk_tblitens_tblencomenda` (`codigoencomenda`),
  ADD KEY `fk_tblitens_tblproduto` (`codigoproduto`);

--
-- Índices para tabela `tblproduto`
--
ALTER TABLE `tblproduto`
  ADD PRIMARY KEY (`codigoproduto`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tblcliente`
--
ALTER TABLE `tblcliente`
  MODIFY `codigocliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tblencomenda`
--
ALTER TABLE `tblencomenda`
  MODIFY `codigoencomenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tblitens`
--
ALTER TABLE `tblitens`
  MODIFY `codigoitem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tblproduto`
--
ALTER TABLE `tblproduto`
  MODIFY `codigoproduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tblencomenda`
--
ALTER TABLE `tblencomenda`
  ADD CONSTRAINT `fk_tblencomenda_tblcliente` FOREIGN KEY (`codigocliente`) REFERENCES `tblcliente` (`codigocliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tblitens`
--
ALTER TABLE `tblitens`
  ADD CONSTRAINT `fk_tblitens_tblencomenda` FOREIGN KEY (`codigoencomenda`) REFERENCES `tblencomenda` (`codigoencomenda`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tblitens_tblproduto` FOREIGN KEY (`codigoproduto`) REFERENCES `tblproduto` (`codigoproduto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
