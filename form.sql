-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 04-Fev-2022 às 02:54
-- Versão do servidor: 10.1.38-MariaDB
-- versão do PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
USE sugestaoprime;
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `resposta`
--

CREATE TABLE `resposta` (
  `id` int(11) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `sujestao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `resposta`
--

INSERT INTO `resposta` (`id`, `descricao`, `sujestao`) VALUES
(1, 'Aqui está a sua nova resposta', 2),
(3, 'Aqui está a sua nova resposta', 2),
(5, 'gggg', 13),
(6, 'fffff', 13),
(7, 'rrrrr', 13),
(8, 'ggggggggggggg', 11),
(9, 'ssssssss', 13),
(10, 'oooooo', 12);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sujestao`
--

CREATE TABLE `sujestao` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descricao` varchar(500) DEFAULT NULL,
  `date` varchar(15) DEFAULT NULL,
  `exibir` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sujestao`
--

INSERT INTO `sujestao` (`id`, `name`, `titulo`, `descricao`, `date`, `exibir`) VALUES
(2, 'a', 'a', 'a', '24/01/2022', NULL),
(3, 'Israel Zeferino', 'Minha humilde opinião', 'Aqui deixo minha singela opinião, sem desvalorizar ninguém, \r\napenas acrecentar askdkasdm asdasdasd asdasdasds \r\nasafafasf asfasfa asfafas asfasfas afafaf asfasfas fasf asfasf \r\nasfasf asf asf asf as fa f asf a dgf rh th  hd  f gsd g dg sd gsd gs g \r\ndsg sd gs g sdg sd gf', '25/01/2022', NULL),
(4, 'Israel', 'Salario', 'Quero um aumento!!!!!', '29/01/2022', NULL),
(6, 'israel', 'testando', 'teste', '03/02/2022', NULL),
(7, 'israel', 'aaaaaaaaaaa', 'Mais uma noite como todas as anteriores. Pego minha caneca de café cheia, acendo meu ultimo cigarro e \r\ncorro pra velha janela do quarto. Observo a noite fria e chuvosa, até parece confortável por um momento, se \r\nnão fossem as dezenas de preocupações que me desmotivam a cada dia.\r\n\r\nPenso em você, mesmo sabendo o quão longe está de mim, sinto aquele amor que continua a me desgraçar \r\nintensamente a cada dia, e penso quando enfim poderei te ter comigo. Sei lá, o café chega ao fim e trago a \r\nult', '03/02/2022', NULL),
(8, 'pp', 'pp', 'Mais uma noite como todas as anteriores. Pego minha caneca de café cheia, acendo meu ultimo cigarro e \r\ncorro pra velha janela do quarto. Observo a noite fria e chuvosa, até parece confortável por um momento, se \r\nnão fossem as dezenas de preocupações que me desmotivam a cada dia.\r\n\r\nPenso em você, mesmo sabendo o quão longe está de mim, sinto aquele amor que continua a me desgraçar \r\nintensamente a cada dia, e penso quando enfim poderei te ter comigo. Sei lá, o café chega ao fim e trago a \r\nult', '03/02/2022', NULL),
(9, 'dd', 'ddd', 'Mais uma noite como todas as anteriores. Pego minha caneca de café cheia, acendo meu ultimo cigarro e \r\ncorro pra velha janela do quarto. Observo a noite fria e chuvosa, até parece confortável por um momento, se \r\nnão fossem as dezenas de preocupações que me desmotivam a cada dia.\r\n\r\nPenso em você, mesmo sabendo o quão longe está de mim, sinto aquele amor que continua a me desgraçar \r\nintensamente a cada dia, e penso quando enfim poderei te ter comigo. Sei lá, o café chega ao fim e trago a \r\nult', '03/02/2022', NULL),
(10, 'hhh', 'hhh', 'hhhhh', '03/02/2022', NULL),
(11, 'ddd', 'ddddd', 'Mais uma noite como todas as anteriores. Pego minha caneca de café cheia, acendo meu ultimo cigarro e \r\ncorro pra velha janela do quarto. Observo a noite fria e chuvosa, até parece confortável por um momento, se \r\nnão fossem as dezenas de preocupações que me desmotivam a cada dia.\r\n\r\nPenso em você, mesmo sabendo o quão longe está de mim, sinto aquele amor que continua a me desgraçar \r\nintensamente a cada dia, e penso quando enfim poderei te ter comigo. Sei lá, o café chega ao fim e trago a \r\nult', '03/02/2022', NULL),
(12, 'll', 'lll', 'top: 30px;\r\n        opacity: 1;', '03/02/2022', NULL),
(13, 'kkkk', 'kkkk', 'top: 30px;\r\n        opacity: 1;', '03/02/2022', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `resposta`
--
ALTER TABLE `resposta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sujestao_resposta` (`sujestao`);

--
-- Indexes for table `sujestao`
--
ALTER TABLE `sujestao`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `resposta`
--
ALTER TABLE `resposta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sujestao`
--
ALTER TABLE `sujestao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `resposta`
--
ALTER TABLE `resposta`
  ADD CONSTRAINT `fk_sujestao_resposta` FOREIGN KEY (`sujestao`) REFERENCES `sujestao` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
