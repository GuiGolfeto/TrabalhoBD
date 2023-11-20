-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 20-Nov-2023 às 16:27
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `trabalhobd`
--

DELIMITER $$
--
-- Procedimentos
--
DROP PROCEDURE IF EXISTS `GravaLogSistema`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GravaLogSistema` (IN `p_tabela` VARCHAR(30), IN `p_evento` VARCHAR(45), IN `p_id` INT, IN `p_campo` VARCHAR(20), IN `p_novo_valor` VARCHAR(40), IN `p_valor_antigo` VARCHAR(40), IN `p_data_hora` DATETIME, IN `p_usuario` VARCHAR(30))   BEGIN
    INSERT INTO logsis (LogTabela, LogEvento, LogID, LogCampo, LogNew, LogOld, LogDatahora, LogUsu)
    VALUES (p_tabela, p_evento, p_id, p_campo, p_novo_valor, p_valor_antigo, p_data_hora, p_usuario);
END$$

DROP PROCEDURE IF EXISTS `p_buscamecanico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `p_buscamecanico` (IN `p_valor` CHAR(30), OUT `p_status` CHAR(1))   begin
   SELECT mecanicos.statusmecanico
      from mecanicos
      where mecanicos.idmecanicos = p_valor
      into p_status;
end$$

DROP PROCEDURE IF EXISTS `p_buscaprofissional`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `p_buscaprofissional` (IN `p_valor` CHAR(30), OUT `p_status` CHAR(1))   begin
   SELECT profissionais.statusprofissional
      from profissionais
      where profissionais.idprofissional = p_valor
      into p_status;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `idClientes` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Cli_Nome` varchar(40) DEFAULT NULL,
  `Cli_Status` char(1) DEFAULT NULL,
  `idOficina` int NOT NULL,
  PRIMARY KEY (`idClientes`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`idClientes`, `Cli_Nome`, `Cli_Status`, `idOficina`) VALUES
(1, 'Guilherme Golfeto', 'A', 1),
(2, 'Maria', 'A', 1),
(4, 'Joaquim', 'A', 1),
(19, 'Cainã', 'A', 1),
(20, 'Clayton', 'A', 1),
(21, 'Rafao', 'A', 1);

--
-- Acionadores `clientes`
--
DROP TRIGGER IF EXISTS `tgr_clientesBD`;
DELIMITER $$
CREATE TRIGGER `tgr_clientesBD` BEFORE DELETE ON `clientes` FOR EACH ROW BEGIN
  -- Declaração de Variaveis
  -- DECLARE nomevariavel tipo;
  -- Corpo da TRIGGER 
  IF (old.cli_status <> 'I') THEN
     SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Exclusão de Clientes nao permitida'; 
  END IF;   
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tgr_clientesBI`;
DELIMITER $$
CREATE TRIGGER `tgr_clientesBI` BEFORE INSERT ON `clientes` FOR EACH ROW BEGIN
   if ( (new.cli_status NOT IN ('A', 'I', 'B')) OR new.cli_status is null) THEN
       SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Status Invalido. Aceito somente A. I ou B'; 
   end if;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tgr_clientesBU`;
DELIMITER $$
CREATE TRIGGER `tgr_clientesBU` BEFORE UPDATE ON `clientes` FOR EACH ROW BEGIN
   if ((new.cli_status NOT IN ('A', 'I', 'B')) OR new.cli_status is null) THEN
       SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Status Invalido. Aceito somente A. I ou B'; 
   end if;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `logsis`
--

DROP TABLE IF EXISTS `logsis`;
CREATE TABLE IF NOT EXISTS `logsis` (
  `idLogSis` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `LogTabela` varchar(30) DEFAULT NULL,
  `LogEvento` varchar(45) DEFAULT NULL,
  `LogID` int UNSIGNED DEFAULT NULL,
  `LogCampo` varchar(20) DEFAULT NULL,
  `LogNew` varchar(40) DEFAULT NULL,
  `LogOld` varchar(40) DEFAULT NULL,
  `LogDatahora` datetime DEFAULT NULL,
  `LogUsu` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idLogSis`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `logsis`
--

INSERT INTO `logsis` (`idLogSis`, `LogTabela`, `LogEvento`, `LogID`, `LogCampo`, `LogNew`, `LogOld`, `LogDatahora`, `LogUsu`) VALUES
(14, 'Mecanico', 'Insert', 4, 'nomemecanico', 'Tonhão', NULL, '2023-10-23 20:06:32', 'root@localhost'),
(15, 'Mecanico', 'Insert', 5, 'nomemecanico', 'Robissão', NULL, '2023-10-23 20:10:33', 'root@localhost'),
(16, 'Mecanico', 'Insert', 5, 'statusmecanico', 'A', NULL, '2023-10-23 20:10:33', 'root@localhost'),
(17, 'Mecanico', 'Insert', 5, 'comissaomecanico', NULL, NULL, '2023-10-23 20:10:33', 'root@localhost'),
(18, 'Mecanico', 'Insert', 6, 'nomemecanico', 'Torrado', NULL, '2023-10-23 20:13:34', 'root@localhost'),
(19, 'Mecanico', 'Insert', 6, 'statusmecanico', 'A', NULL, '2023-10-23 20:13:34', 'root@localhost'),
(20, 'Mecanico', 'Insert', 6, 'comissaomecanico', NULL, NULL, '2023-10-23 20:13:34', 'root@localhost'),
(21, 'Mecanico', 'Insert', 6, 'nomemecanico', 'Klebirson', NULL, '2023-10-23 20:17:53', 'root@localhost'),
(22, 'Mecanico', 'Update', 6, 'nomemecanico', 'Torrado', 'Klebirson', '2023-10-23 20:19:42', 'root@localhost'),
(23, 'Mecanico', 'Update', 6, 'nomemecanico', 'Torrado', 'Torrado', '2023-10-23 20:20:57', 'root@localhost'),
(24, 'Mecanico', 'Update', 6, 'Statusmecanico', 'A', 'I', '2023-10-23 20:25:59', 'root@localhost'),
(25, 'Mecanico', 'Update', 4, 'comissaomecanico', '18.00', '15.00', '2023-10-23 20:28:09', 'root@localhost'),
(26, 'Mecanico', 'Insert', 7, 'nomemecanico', 'Borracha', NULL, '2023-10-23 20:33:07', 'root@localhost'),
(27, 'Mecanico', 'Insert', 7, 'statusmecanico', 'A', NULL, '2023-10-23 20:33:07', 'root@localhost'),
(28, 'Mecanico', 'Insert', 7, 'comissaomecanico', '0.00', NULL, '2023-10-23 20:33:07', 'root@localhost'),
(29, 'Mecanico', 'Insert', 8, 'nomemecanico', 'Erick', NULL, '2023-10-23 20:33:37', 'root@localhost'),
(30, 'Mecanico', 'Insert', 8, 'statusmecanico', 'A', NULL, '2023-10-23 20:33:37', 'root@localhost'),
(31, 'Mecanico', 'Insert', 8, 'comissaomecanico', '10.00', NULL, '2023-10-23 20:33:37', 'root@localhost');

-- --------------------------------------------------------

--
-- Estrutura da tabela `oficinas`
--

DROP TABLE IF EXISTS `oficinas`;
CREATE TABLE IF NOT EXISTS `oficinas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `razaosocial` varchar(255) NOT NULL,
  `cnpj` varchar(14) NOT NULL,
  `anoOperacao` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `oficinas`
--

INSERT INTO `oficinas` (`id`, `razaosocial`, `cnpj`, `anoOperacao`) VALUES
(1, 'Oficina do Marquin', '0000000000000', 2023);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos`
--

DROP TABLE IF EXISTS `pagamentos`;
CREATE TABLE IF NOT EXISTS `pagamentos` (
  `idpagamentos` int NOT NULL AUTO_INCREMENT,
  `datapagto` date DEFAULT NULL,
  `mecanicos_idmecanico` int DEFAULT NULL,
  `valorpagto` decimal(12,2) DEFAULT NULL,
  `idOficina` int NOT NULL,
  PRIMARY KEY (`idpagamentos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pecas`
--

DROP TABLE IF EXISTS `pecas`;
CREATE TABLE IF NOT EXISTS `pecas` (
  `idpecas` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `pecas_nome` varchar(40) DEFAULT NULL,
  `pecas_preco` decimal(12,2) DEFAULT NULL,
  `pecas_saldo` int DEFAULT NULL,
  `idOficina` int NOT NULL,
  PRIMARY KEY (`idpecas`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `pecas`
--

INSERT INTO `pecas` (`idpecas`, `pecas_nome`, `pecas_preco`, `pecas_saldo`, `idOficina`) VALUES
(1, 'Oleo de Motor', '15.90', 8, 1),
(2, 'Retrovisor', '32.00', 13, 1),
(3, 'Pneu Dianteiro', '100.00', 15, 1),
(33, 'Comando Twister', '280.00', 1, 1);

--
-- Acionadores `pecas`
--
DROP TRIGGER IF EXISTS `tgr_pecasBI`;
DELIMITER $$
CREATE TRIGGER `tgr_pecasBI` BEFORE INSERT ON `pecas` FOR EACH ROW BEGIN
   if (new.pecas_saldo < 0) THEN
       SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Saldo nao pode ficar negativo'; 
   end if;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tgr_pecasBU`;
DELIMITER $$
CREATE TRIGGER `tgr_pecasBU` BEFORE UPDATE ON `pecas` FOR EACH ROW BEGIN
   if (new.pecas_saldo < 0) THEN
       SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Saldo nao pode ficar negativo'; 
   end if;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pecas_do_servico`
--

DROP TABLE IF EXISTS `pecas_do_servico`;
CREATE TABLE IF NOT EXISTS `pecas_do_servico` (
  `idPecas_do_Servico` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `pecas_idpecas` int UNSIGNED NOT NULL,
  `Servicos_idServicos` int UNSIGNED NOT NULL,
  `ps_quantidade` int UNSIGNED DEFAULT NULL,
  `ps_preco` decimal(12,2) DEFAULT NULL,
  `idOficina` int NOT NULL,
  PRIMARY KEY (`idPecas_do_Servico`),
  KEY `Pecas_do_Servico_FKIndex1` (`Servicos_idServicos`),
  KEY `Pecas_do_Servico_FKIndex2` (`pecas_idpecas`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `pecas_do_servico`
--

INSERT INTO `pecas_do_servico` (`idPecas_do_Servico`, `pecas_idpecas`, `Servicos_idServicos`, `ps_quantidade`, `ps_preco`, `idOficina`) VALUES
(8, 1, 1, 1, '15.90', 1),
(9, 3, 1, 2, '100.00', 1),
(10, 2, 2, 2, '32.00', 1),
(11, 1, 2, 1, '15.90', 1);

--
-- Acionadores `pecas_do_servico`
--
DROP TRIGGER IF EXISTS `tgr_pecas_do_servicoBI`;
DELIMITER $$
CREATE TRIGGER `tgr_pecas_do_servicoBI` BEFORE INSERT ON `pecas_do_servico` FOR EACH ROW BEGIN
    -- Criar uma variavel para armazenar o preco
    declare v_preco decimal(12,2);
    declare v_idstatus int;
    declare v_bloqueiaservico char(1);
    
    -- Buscar o preco da peca que esta sendo vendida
    select pecas.pecas_preco
        from pecas
        where pecas.idpecas = new.pecas_idpecas
        INTO v_preco;
    
    -- Atualizar o campo preco da tabela pecas_do_Servico    
    SET new.ps_preco = v_preco;    
    
    -- Validar o Status do Serviço
    -- Buscar o ID do status_do_servico
    select servicos.status_idStatusServico
	   from servicos
	   where servicos.idservicos = new.servicos_idservicos
	   into v_idstatus;

    -- Buscar o Status_do_servico
	select statusservico.bloqueiaservico
	   from statusservico
	   where statusservico.idstatusservico = v_idstatus
       into v_bloqueiaservico; 
       
    -- Testar a variavel v_bloqueiaservico
    IF (v_bloqueiaservico = 'S') then
       SIGNAL SQLSTATE '45000' SET message_text = 'Status Bloqueado, nao pode incluir pecas';
    end if;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tgr_pecas_do_servicoBU`;
DELIMITER $$
CREATE TRIGGER `tgr_pecas_do_servicoBU` BEFORE UPDATE ON `pecas_do_servico` FOR EACH ROW BEGIN
	IF (new.pecas_idpecas <> old.pecas_idpecas) then
	   SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Não é permitido alterar o codigo de uma peca. Apague e crie novamente'; 
	END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tgr_pecasdoservicoAD`;
DELIMITER $$
CREATE TRIGGER `tgr_pecasdoservicoAD` AFTER DELETE ON `pecas_do_servico` FOR EACH ROW BEGIN
  -- Declaração de Variaveis
  -- DECLARE msg varchar(40);
  -- Corpo da TRIGGER 
   UPDATE pecas SET pecas.pecas_saldo = pecas.pecas_saldo
                                    + OLD.ps_quantidade 
                WHERE pecas.idpecas = old.pecas_idpecas;                    
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tgr_pecasdoservicoAI`;
DELIMITER $$
CREATE TRIGGER `tgr_pecasdoservicoAI` AFTER INSERT ON `pecas_do_servico` FOR EACH ROW BEGIN
  -- Declaração de Variaveis
  -- DECLARE msg varchar(40);
  -- Corpo da TRIGGER 
  -- Atualizar o Saldo em Estoque da Peca Vendida 
   UPDATE pecas SET pecas.pecas_saldo = pecas.pecas_saldo
									- new.ps_quantidade
                WHERE pecas.idpecas = new.pecas_idpecas;  
  -- Atualizar o Valor total do Servico
  update servicos
     SET servicos.valortotalservico = valortotalservico
									+ (new.ps_quantidade * new.ps_preco)
     WHERE servicos.idservicos = new.servicos_idservicos;                               
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tgr_pecasdoservicoAU`;
DELIMITER $$
CREATE TRIGGER `tgr_pecasdoservicoAU` AFTER UPDATE ON `pecas_do_servico` FOR EACH ROW BEGIN
  -- Declaração de Variaveis
  -- DECLARE msg varchar(40);
  -- Corpo da TRIGGER 
  -- if (new.ps_quantidade <> old.ps_quantidade) then
   UPDATE pecas SET pecas.pecas_saldo = pecas.pecas_saldo
                                    + OLD.ps_quantidade 
									- new.ps_quantidade
                WHERE pecas.idpecas = new.pecas_idpecas;                    
  -- end if;              
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `profissionais`
--

DROP TABLE IF EXISTS `profissionais`;
CREATE TABLE IF NOT EXISTS `profissionais` (
  `idprofissional` int NOT NULL AUTO_INCREMENT,
  `nomeprofissional` varchar(45) DEFAULT NULL,
  `statusprofissional` char(1) DEFAULT 'A',
  `comissaoprofissional` decimal(12,2) DEFAULT NULL,
  `idOficina` int NOT NULL,
  PRIMARY KEY (`idprofissional`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `profissionais`
--

INSERT INTO `profissionais` (`idprofissional`, `nomeprofissional`, `statusprofissional`, `comissaoprofissional`, `idOficina`) VALUES
(1, 'Japones', 'A', '15.00', 1),
(2, 'Macalé', 'I', '2.00', 1),
(3, 'Caio Castro', 'A', '50.00', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `servicos`
--

DROP TABLE IF EXISTS `servicos`;
CREATE TABLE IF NOT EXISTS `servicos` (
  `idServicos` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Clientes_idClientes` int UNSIGNED NOT NULL,
  `profissionais_idprofissionais` int DEFAULT NULL,
  `DataServico` date DEFAULT NULL,
  `ValorTotalServico` decimal(12,2) DEFAULT '0.00',
  `Status_idStatusServico` int DEFAULT NULL,
  `valormaoobraServico` decimal(12,2) DEFAULT '0.00',
  `idOficina` int NOT NULL,
  PRIMARY KEY (`idServicos`),
  KEY `Servicos_FKIndex1` (`Clientes_idClientes`),
  KEY `servicos_ibfk_2_idx` (`Status_idStatusServico`),
  KEY `servicos_ibfk_3_idx` (`profissionais_idprofissionais`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `servicos`
--

INSERT INTO `servicos` (`idServicos`, `Clientes_idClientes`, `profissionais_idprofissionais`, `DataServico`, `ValorTotalServico`, `Status_idStatusServico`, `valormaoobraServico`, `idOficina`) VALUES
(1, 2, 1, '2023-11-08', '5000.00', 1, '150.00', 1),
(2, 2, 2, '2023-07-15', '79.90', 4, '180.00', 1),
(3, 1, 2, '2023-07-16', '2580.00', 5, '150.00', 1),
(5, 1, 1, '2023-09-25', '170.00', 4, '36.89', 1),
(6, 4, 2, '2023-09-24', '0.00', 5, '240.00', 1),
(7, 2, 1, '2023-10-02', '0.00', 1, '180.00', 1),
(9, 4, 2, '2023-11-06', '0.00', 1, '0.00', 1),
(10, 1, 1, '2023-11-13', '0.00', 1, '0.00', 1),
(12, 1, 1, '2023-11-29', '800.00', 1, '150.00', 1),
(13, 1, 1, '2023-11-25', '800.00', 1, '150.00', 1),
(15, 1, 1, '2023-11-18', '800.00', 1, '150.00', 1);

--
-- Acionadores `servicos`
--
DROP TRIGGER IF EXISTS `tgr_servicosBU`;
DELIMITER $$
CREATE TRIGGER `tgr_servicosBU` BEFORE UPDATE ON `servicos` FOR EACH ROW BEGIN
    declare statuscli varchar(01);
    -- Validar o Status do Cliente
	   select clientes.cli_status
		  from clientes
		  where clientes.idclientes = new.clientes_idclientes
		  into statuscli;
	   if (statuscli IN ('I', 'B')) then
	      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cliente Inativo. Nao pode ser usado';
	   end if;
    -- Fim da Validacao do Cliente
    -- Validar a data do Servico (nao pode ser inferior a hoje)
    -- if (new.dataservico < curdate()) then
       -- signal sqlstate '45000' SET message_text =  'Data do Servico nao pode ser inferior ao dia de hoje';
    -- end if;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tgr_servicos_BI`;
DELIMITER $$
CREATE TRIGGER `tgr_servicos_BI` BEFORE INSERT ON `servicos` FOR EACH ROW BEGIN
   declare statuscli varchar(1);
   declare statusprof varchar(1);
   -- Validar o Status do Cliente
	   select clientes.cli_status
		  from clientes
		  where clientes.idclientes = new.clientes_idclientes
		  into statuscli;
	   if (statuscli IN ('I', 'B')) then
	      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cliente Inativo. Nao pode ser usado';
	   end if;
    -- Fim da Validacao do Cliente
    -- Validar a data do Servico (nao pode ser inferior a hoje)
    if (new.dataservico < curdate()) then
      signal sqlstate '45000' SET message_text =  'Data do Servico nao pode ser inferior ao dia de hoje';
    end if;
    
    -- Fim da Validação do Servico
    -- Validar se o Mecanico esta Ativo
    call p_buscaprofissional(new.profissionais_idprofissionais, statusprof);
    if statusprof <> 'A' then
      signal sqlstate '45000' SET message_text =  'Mecanico nao esta Ativo';
    end if;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusservico`
--

DROP TABLE IF EXISTS `statusservico`;
CREATE TABLE IF NOT EXISTS `statusservico` (
  `idStatusServico` int NOT NULL AUTO_INCREMENT,
  `DescricaoStatus` varchar(45) DEFAULT NULL,
  `BloqueiaServico` char(1) DEFAULT 'N',
  `idOficina` int NOT NULL,
  PRIMARY KEY (`idStatusServico`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `statusservico`
--

INSERT INTO `statusservico` (`idStatusServico`, `DescricaoStatus`, `BloqueiaServico`, `idOficina`) VALUES
(1, 'Agendado', 'S', 1),
(2, 'Aberto', 'N', 1),
(3, 'Em Execucao', 'N', 1),
(4, 'Bloqueado', 'S', 1),
(5, 'Finalizado', 'S', 1),
(6, 'Especial', 'N', 1);

--
-- Acionadores `statusservico`
--
DROP TRIGGER IF EXISTS `tgr_statusservicoBI`;
DELIMITER $$
CREATE TRIGGER `tgr_statusservicoBI` BEFORE INSERT ON `statusservico` FOR EACH ROW BEGIN
   if (new.bloqueiaservico not in ('S', 'N')) then
      signal sqlstate '45000' SET message_text = 'Status Invalido, deve ser informado S ou N';
   end if;
   if (new.bloqueiaservico is null) then
      signal sqlstate '45000' SET message_text = 'Status Invalido. Nao Pode ser Nulo';
   end if;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tgr_statusservicoBU`;
DELIMITER $$
CREATE TRIGGER `tgr_statusservicoBU` BEFORE UPDATE ON `statusservico` FOR EACH ROW BEGIN
   if (new.bloqueiaservico not in ('S', 'N')) then
      signal sqlstate '45000' SET message_text = 'Status Invalido, deve ser informado S ou N';
   end if;
   if (new.bloqueiaservico is null) then
      signal sqlstate '45000' SET message_text = 'Status Invalido. Nao Pode ser Nulo';
   end if;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `idusuarios` int NOT NULL AUTO_INCREMENT,
  `email` varchar(55) NOT NULL,
  `senha` varchar(55) NOT NULL,
  `idOficina` int NOT NULL,
  `nome` varchar(55) NOT NULL,
  PRIMARY KEY (`idusuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`idusuarios`, `email`, `senha`, `idOficina`, `nome`) VALUES
(1, 'teste@teste.com', '123', 1, 'Bié');

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `v_os`
-- (Veja abaixo para a view atual)
--
DROP VIEW IF EXISTS `v_os`;
CREATE TABLE IF NOT EXISTS `v_os` (
`Data` varchar(10)
,`ID_OS` int unsigned
,`Nome CLiente` varchar(40)
);

-- --------------------------------------------------------

--
-- Estrutura para vista `v_os`
--
DROP TABLE IF EXISTS `v_os`;

DROP VIEW IF EXISTS `v_os`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_os`  AS SELECT `servicos`.`idServicos` AS `ID_OS`, `clientes`.`Cli_Nome` AS `Nome CLiente`, date_format(`servicos`.`DataServico`,'%d/%m/%Y') AS `Data` FROM (`servicos` join `clientes`) WHERE (`clientes`.`idClientes` = `servicos`.`Clientes_idClientes`)  ;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `pecas_do_servico`
--
ALTER TABLE `pecas_do_servico`
  ADD CONSTRAINT `pecas_do_servico_ibfk_1` FOREIGN KEY (`Servicos_idServicos`) REFERENCES `servicos` (`idServicos`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pecas_do_servico_ibfk_2` FOREIGN KEY (`pecas_idpecas`) REFERENCES `pecas` (`idpecas`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `servicos`
--
ALTER TABLE `servicos`
  ADD CONSTRAINT `servicos_ibfk_1` FOREIGN KEY (`Clientes_idClientes`) REFERENCES `clientes` (`idClientes`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `servicos_ibfk_2` FOREIGN KEY (`Status_idStatusServico`) REFERENCES `statusservico` (`idStatusServico`),
  ADD CONSTRAINT `servicos_ibfk_3` FOREIGN KEY (`profissionais_idprofissionais`) REFERENCES `profissionais` (`idprofissional`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
