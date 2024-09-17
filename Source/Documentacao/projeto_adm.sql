-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema projeto_adm
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema projeto_adm
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `projeto_adm` DEFAULT CHARACTER SET utf8 ;
USE `projeto_adm` ;

-- -----------------------------------------------------
-- Table `projeto_adm`.`cargo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projeto_adm`.`cargo` (
  `idcargo` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  `funcao` VARCHAR(100) NULL,
  PRIMARY KEY (`idcargo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projeto_adm`.`cadastro_departamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projeto_adm`.`cadastro_departamento` (
  `idcadastro_departamento` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `telefone` VARCHAR(45) NULL,
  PRIMARY KEY (`idcadastro_departamento`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projeto_adm`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projeto_adm`.`usuario` (
  `idcadastrar_usuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `telefone` VARCHAR(45) NULL,
  `nivel_acesso` VARCHAR(45) NULL COMMENT 'O nível de permissões ou privilégios concedidos ao usuário (por exemplo, administrador, usuário padrão, etc.).',
  `data_acesso` DATETIME NULL COMMENT 'A data e hora em que o usuário foi registrado no sistema.',
  `senha` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idcadastrar_usuario`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projeto_adm`.`funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projeto_adm`.`funcionario` (
  `idfuncionario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  `cpf` VARCHAR(45) NULL,
  `cadastro_departamento_idcadastro_departamento` INT NOT NULL,
  `numero_matricula` VARCHAR(200) NOT NULL,
  `usuario_idcadastrar_usuario` INT NOT NULL,
  `cargo_idcargo` INT NOT NULL,
  PRIMARY KEY (`idfuncionario`, `cadastro_departamento_idcadastro_departamento`),
  INDEX `fk_servidor_cadastro_departamento1_idx` (`cadastro_departamento_idcadastro_departamento` ASC) VISIBLE,
  INDEX `fk_servidor_usuario1_idx` (`usuario_idcadastrar_usuario` ASC) VISIBLE,
  INDEX `fk_servidor_cargo1_idx` (`cargo_idcargo` ASC) VISIBLE,
  CONSTRAINT `fk_servidor_cadastro_departamento1`
    FOREIGN KEY (`cadastro_departamento_idcadastro_departamento`)
    REFERENCES `projeto_adm`.`cadastro_departamento` (`idcadastro_departamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_servidor_usuario1`
    FOREIGN KEY (`usuario_idcadastrar_usuario`)
    REFERENCES `projeto_adm`.`usuario` (`idcadastrar_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_servidor_cargo1`
    FOREIGN KEY (`cargo_idcargo`)
    REFERENCES `projeto_adm`.`cargo` (`idcargo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projeto_adm`.`tipo_processo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projeto_adm`.`tipo_processo` (
  `idtipo_processo` INT NOT NULL,
  `descricao` VARCHAR(45) NOT NULL,
  `prazo` INT NULL,
  `prioridade` VARCHAR(45) NULL,
  PRIMARY KEY (`idtipo_processo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projeto_adm`.`processo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projeto_adm`.`processo` (
  `idprocesso` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  `responsavel` VARCHAR(45) NULL,
  `prazo` DATETIME NULL,
  `data_abertura` DATETIME NULL,
  `cadastro_departamento_idcadastro_departamento` INT NOT NULL,
  `funcionario_idfuncionario` INT NOT NULL,
  `funcionario_cadastro_departamento_idcadastro_departamento` INT NOT NULL,
  `tipo_processo_idtipo_processo` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idprocesso`),
  INDEX `fk_cadastro_processo_cadastro_departamento1_idx` (`cadastro_departamento_idcadastro_departamento` ASC) VISIBLE,
  INDEX `fk_processo_funcionario1_idx` (`funcionario_idfuncionario` ASC, `funcionario_cadastro_departamento_idcadastro_departamento` ASC) VISIBLE,
  INDEX `fk_processo_tipo_processo1_idx` (`tipo_processo_idtipo_processo` ASC) VISIBLE,
  CONSTRAINT `fk_cadastro_processo_cadastro_departamento1`
    FOREIGN KEY (`cadastro_departamento_idcadastro_departamento`)
    REFERENCES `projeto_adm`.`cadastro_departamento` (`idcadastro_departamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_processo_funcionario1`
    FOREIGN KEY (`funcionario_idfuncionario` , `funcionario_cadastro_departamento_idcadastro_departamento`)
    REFERENCES `projeto_adm`.`funcionario` (`idfuncionario` , `cadastro_departamento_idcadastro_departamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_processo_tipo_processo1`
    FOREIGN KEY (`tipo_processo_idtipo_processo`)
    REFERENCES `projeto_adm`.`tipo_processo` (`idtipo_processo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projeto_adm`.`permissao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projeto_adm`.`permissao` (
  `idpermissao` INT NOT NULL,
  `nivel` VARCHAR(45) NULL,
  `cadastrar_usuario_idcadastrar_usuario` INT NOT NULL,
  `cadastrar_usuario_servidor_id` INT NOT NULL,
  PRIMARY KEY (`cadastrar_usuario_idcadastrar_usuario`, `cadastrar_usuario_servidor_id`),
  CONSTRAINT `fk_permissao_cadastrar_usuario1`
    FOREIGN KEY (`cadastrar_usuario_idcadastrar_usuario`)
    REFERENCES `projeto_adm`.`usuario` (`idcadastrar_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projeto_adm`.`etapas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projeto_adm`.`etapas` (
  `idetapas` INT NOT NULL AUTO_INCREMENT,
  `status` VARCHAR(45) NULL,
  `data_movimetacao` VARCHAR(45) NULL,
  `processo_idprocesso` INT NOT NULL,
  PRIMARY KEY (`idetapas`, `processo_idprocesso`),
  INDEX `fk_etapas_processo1_idx` (`processo_idprocesso` ASC) VISIBLE,
  CONSTRAINT `fk_etapas_processo1`
    FOREIGN KEY (`processo_idprocesso`)
    REFERENCES `projeto_adm`.`processo` (`idprocesso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projeto_adm`.`tarefa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projeto_adm`.`tarefa` (
  `idtarefa` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NULL,
  `etapas_idetapas` INT NOT NULL,
  `etapas_processo_idprocesso` INT NOT NULL,
  `funcionario_idfuncionario` INT NOT NULL,
  `funcionario_cadastro_departamento_idcadastro_departamento` INT NOT NULL,
  `data_terminar` VARCHAR(45) NULL,
  `data_iniciar` VARCHAR(45) NULL,
  `crerated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idtarefa`),
  INDEX `fk_tarefa_etapas1_idx` (`etapas_idetapas` ASC, `etapas_processo_idprocesso` ASC) VISIBLE,
  INDEX `fk_tarefa_funcionario1_idx` (`funcionario_idfuncionario` ASC, `funcionario_cadastro_departamento_idcadastro_departamento` ASC) VISIBLE,
  CONSTRAINT `fk_tarefa_etapas1`
    FOREIGN KEY (`etapas_idetapas` , `etapas_processo_idprocesso`)
    REFERENCES `projeto_adm`.`etapas` (`idetapas` , `processo_idprocesso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tarefa_funcionario1`
    FOREIGN KEY (`funcionario_idfuncionario` , `funcionario_cadastro_departamento_idcadastro_departamento`)
    REFERENCES `projeto_adm`.`funcionario` (`idfuncionario` , `cadastro_departamento_idcadastro_departamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

 
INSERT INTO cargo (nome, funcao) VALUES ('Diretor de Finanças', 'Responsável pela gestão financeira da empresa');
INSERT INTO cargo (nome, funcao) VALUES ('Gerente de Recursos Humanos', 'Responsável pela gestão de pessoas e talentos da empresa');
INSERT INTO cargo (nome, funcao) VALUES ('Gerente de Operações', 'Responsável pela gestão das operações diárias da empresa');
INSERT INTO cargo (nome, funcao) VALUES ('TECH lead', 'Responsável pela gestão dos sistemas e tecnologias da informação da empresa');
INSERT INTO cargo (nome, funcao) VALUES ('Gerente de Marketing', 'Responsável pela gestão das estratégias de marketing e comunicação da empresa');
INSERT INTO cargo (nome, funcao) VALUES ('Gerente de Vendas', 'Responsável pela gestão das vendas e atendimento ao cliente da empresa');
INSERT INTO cargo (nome, funcao) VALUES ('Auditor Interno', 'Responsável pela auditoria interna dos processos e contas da empresa');
INSERT INTO cargo (nome, funcao) VALUES ('Assistente de Direção', 'Auxiliar o diretor em suas tarefas e responsabilidades');
INSERT INTO cargo (nome, funcao) VALUES ('Analista de Crédito', 'Avaliar o risco de crédito e tomar decisões de empréstimo');
INSERT INTO cargo (nome, funcao) VALUES ('Especialista em RH', 'Auxiliar na gestão de pessoas e talentos da empresa');