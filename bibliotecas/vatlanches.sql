-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2023 at 03:26 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vatlanches`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcliente`
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
-- Dumping data for table `tblcliente`
--

INSERT INTO `tblcliente` (`codigocliente`, `nome`, `cpf`, `email`, `telefone`, `endereco`) VALUES
(1, 'Letícia Hanna', '123.456.789-1', 'leticiahannah@hotmail.co', '+55 (32) 1234-567', 'Rua Machado Cortando Árvore da Silva Pereir'),
(2, 'Otávio Bigogno', '123.456.789-12', 'otaviobigogno@gmail.com', '+55 (32) 1234-5678', 'Rua Maria Não Sei Das Quantas Jesuis'),
(3, 'Leonardo Lacerda', '219.876.654-43', 'leonardolacerda@hotmail.com', '+55 (32) 9876-5432', 'Rua Onde O Judas Perdeu As Botas Da Minha Perspectiva'),
(5, 'Gabriel Cavalhiere', '152.238.126-03', 'gabrielcavalhiere2@gmail.com', '+55 (32) 99127-7540', 'Rua São Francisco Almeida Gama');

-- --------------------------------------------------------

--
-- Table structure for table `tblencomenda`
--

CREATE TABLE `tblencomenda` (
  `codigoencomenda` int(11) NOT NULL,
  `codigocliente` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(16) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblencomenda`
--

INSERT INTO `tblencomenda` (`codigoencomenda`, `codigocliente`, `data`, `status`) VALUES
(29, 5, '2023-05-06 05:17:55', 'Em andamento'),
(31, 5, '2023-05-11 03:30:59', 'Em processamento'),
(32, 5, '2023-06-13 20:41:36', 'Enviado');

-- --------------------------------------------------------

--
-- Table structure for table `tblitens`
--

CREATE TABLE `tblitens` (
  `codigoitem` int(11) NOT NULL,
  `codigoencomenda` int(11) NOT NULL,
  `codigoproduto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblitens`
--

INSERT INTO `tblitens` (`codigoitem`, `codigoencomenda`, `codigoproduto`, `quantidade`) VALUES
(61, 29, 1, 1),
(62, 29, 2, 2),
(66, 29, 4, 1),
(67, 29, 5, 1),
(68, 31, 1, 1),
(69, 31, 3, 1),
(70, 32, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblproduto`
--

CREATE TABLE `tblproduto` (
  `codigoproduto` int(11) NOT NULL,
  `categoria` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `preco` decimal(7,2) NOT NULL,
  `foto` varchar(2048) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblproduto`
--

INSERT INTO `tblproduto` (`codigoproduto`, `categoria`, `descricao`, `preco`, `foto`) VALUES
(1, 'Bebida', 'Coca-Cola', '9.90', 'http://localhost/TechorAko/VAT-Lanches/assets/produto_foto/569807836687.png'),
(2, 'Lanche', 'Misto Quente', '4.49', 'http://localhost/TechorAko/VAT-Lanches/assets/produto_foto/6588706588521.png'),
(3, 'Sobremesa', 'Açai', '14.90', 'http://localhost/TechorAko/VAT-Lanches/assets/produto_foto/3514464060828.png'),
(4, 'Bebida', 'Fanta Laranja', '8.49', 'http://localhost/TechorAko/VAT-Lanches/assets/produto_foto/9396432479347.png'),
(5, 'Lanche', 'Cachorro Quente', '6.59', 'http://localhost/TechorAko/VAT-Lanches/assets/produto_foto/1914691969305.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcliente`
--
ALTER TABLE `tblcliente`
  ADD PRIMARY KEY (`codigocliente`);

--
-- Indexes for table `tblencomenda`
--
ALTER TABLE `tblencomenda`
  ADD PRIMARY KEY (`codigoencomenda`),
  ADD KEY `fk_tblencomenda_tblcliente` (`codigocliente`);

--
-- Indexes for table `tblitens`
--
ALTER TABLE `tblitens`
  ADD PRIMARY KEY (`codigoitem`),
  ADD KEY `fk_tblitens_tblencomenda` (`codigoencomenda`),
  ADD KEY `fk_tblitens_tblproduto` (`codigoproduto`);

--
-- Indexes for table `tblproduto`
--
ALTER TABLE `tblproduto`
  ADD PRIMARY KEY (`codigoproduto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcliente`
--
ALTER TABLE `tblcliente`
  MODIFY `codigocliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblencomenda`
--
ALTER TABLE `tblencomenda`
  MODIFY `codigoencomenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tblitens`
--
ALTER TABLE `tblitens`
  MODIFY `codigoitem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `tblproduto`
--
ALTER TABLE `tblproduto`
  MODIFY `codigoproduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblencomenda`
--
ALTER TABLE `tblencomenda`
  ADD CONSTRAINT `fk_tblencomenda_tblcliente` FOREIGN KEY (`codigocliente`) REFERENCES `tblcliente` (`codigocliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblitens`
--
ALTER TABLE `tblitens`
  ADD CONSTRAINT `fk_tblitens_tblencomenda` FOREIGN KEY (`codigoencomenda`) REFERENCES `tblencomenda` (`codigoencomenda`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tblitens_tblproduto` FOREIGN KEY (`codigoproduto`) REFERENCES `tblproduto` (`codigoproduto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
