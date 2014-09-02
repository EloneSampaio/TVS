-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 20-Ago-2014 às 12:08
-- Versão do servidor: 5.5.38-0ubuntu0.14.04.1
-- versão do PHP: 5.5.9-1ubuntu4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `TvS`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `nome` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `telefone` int(11) NOT NULL,
  `data` date NOT NULL,
  `codigo` int(4) NOT NULL,
  `morada` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='tabela dos clientes' AUTO_INCREMENT=18 ;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`nome`, `telefone`, `data`, `codigo`, `morada`, `id`) VALUES
('jj m', 0, '2014-08-15', 106798495, 'hhhh', 12),
('teeee sssss', 927769579, '2014-08-16', 92479827, 'aaa', 13),
('marcos sampaio', 927769570, '2014-08-17', 93585339, 'cazenga', 14),
('elone sampaio', 927769571, '2014-08-17', 116761949, 'cazenga', 15),
('wwwwwwwwwwww wwwwwwww', 11234, '2014-08-18', 99286670, 'aaaaaa', 16),
('kkkkkkk pppppp', 55677, '2014-08-18', 107867471, 'mmmmmm', 17);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos`
--

CREATE TABLE IF NOT EXISTS `pagamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mes` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `data` date NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_cliente` int(4) NOT NULL,
  `status` set('on','off') COLLATE latin1_general_ci NOT NULL DEFAULT 'off',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='tabela de pagamentos' AUTO_INCREMENT=22 ;

--
-- Extraindo dados da tabela `pagamentos`
--

INSERT INTO `pagamentos` (`id`, `mes`, `data`, `id_usuario`, `id_cliente`, `status`) VALUES
(5, 'janeiro', '2014-08-17', 1, 12, 'on'),
(6, 'janeiro', '2014-08-17', 1, 13, 'on'),
(7, 'janeiro', '2014-08-17', 1, 14, 'on'),
(8, 'fevereiro', '2014-08-13', 1, 13, 'off'),
(9, 'feveiro', '2014-08-18', 1, 13, 'on'),
(10, 'marÃ§o', '2014-08-18', 1, 13, 'on'),
(11, 'abril', '2014-08-18', 1, 13, 'on'),
(12, 'maio', '2014-08-18', 1, 13, 'on'),
(13, 'junho', '2014-08-18', 1, 13, 'on'),
(14, 'julho', '2014-08-18', 1, 13, 'on'),
(15, 'agosto', '2014-08-18', 1, 13, 'on'),
(16, 'setembro', '2014-08-18', 1, 13, 'on'),
(17, 'outubro', '2014-08-18', 1, 13, 'on'),
(18, 'novembro', '2014-08-18', 1, 13, 'on'),
(19, 'dezembro', '2014-08-18', 1, 13, 'on'),
(20, 'marÃ§o', '2014-08-18', 1, 14, 'on'),
(21, 'agosto', '2014-08-18', 1, 14, 'on');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `nome` varchar(40) NOT NULL,
  `login` varchar(20) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `nivel` set('admin','usuario') NOT NULL DEFAULT 'usuario',
  `status` set('on','off') NOT NULL DEFAULT 'on',
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COMMENT='tabela de usuario' AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`nome`, `login`, `senha`, `nivel`, `status`, `id_usuario`) VALUES
('admin', 'root', 'c34977ad7935188f0d061758935da833', 'admin', 'on', 1),
('elone', 'sampaio', 'b78f3759dd139a3e9ce65aa0d190663a', 'usuario', 'on', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
