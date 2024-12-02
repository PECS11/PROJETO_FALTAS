-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS `projeto_faltas`;

-- Seleciona o banco de dados
USE `projeto_faltas`;

-- Criação da tabela 'turma'
CREATE TABLE IF NOT EXISTS `turma` (
    `id_turma` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(100) NOT NULL,
    `curso` VARCHAR(100) NOT NULL,
    `turno` ENUM('Manhã', 'Tarde', 'Noite') NOT NULL,
    PRIMARY KEY (`id_turma`)
);

-- Criação da tabela 'aluno'
CREATE TABLE IF NOT EXISTS `aluno` (
    `id_aluno` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(255) NOT NULL,
    `matricula` VARCHAR(50) NOT NULL,
    `data_nascimento` DATE NOT NULL,
    `telefone` VARCHAR(11) NOT NULL,
    `id_turma` INT NOT NULL,
    PRIMARY KEY (`id_aluno`),
    CONSTRAINT `fk_aluno_turma` FOREIGN KEY (`id_turma`) REFERENCES `turma` (`id_turma`) ON DELETE CASCADE
);

-- Criação da tabela 'funcionario'
CREATE TABLE IF NOT EXISTS `funcionario` (
    `id_funcionario` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(255) NOT NULL,
    `data_nascimento` DATE NOT NULL,
    `telefone` VARCHAR(20) NOT NULL,
    `cargo` VARCHAR(100) NOT NULL,
    `setor` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id_funcionario`)
);

-- Criação da tabela 'ocorrencia'
CREATE TABLE IF NOT EXISTS `ocorrencia` (
    `id_ocorrencia` INT NOT NULL AUTO_INCREMENT,
    `id_aluno` INT NOT NULL,
    `tipo_ocorrencia` ENUM('Falta', 'Atraso', 'Justificativa') NOT NULL,
    `data_oco` DATE NOT NULL,
    `descricao` TEXT,
    `justificativa` TEXT,
    `id_funcionario` INT NOT NULL,
    PRIMARY KEY (`id_ocorrencia`),
    CONSTRAINT `fk_ocorrencia_aluno` FOREIGN KEY (`id_aluno`) REFERENCES `aluno` (`id_aluno`) ON DELETE CASCADE,
    CONSTRAINT `fk_ocorrencia_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`) ON DELETE CASCADE
);

-- Criação da tabela 'registro'
CREATE TABLE IF NOT EXISTS `registro` (
    `id_registro` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(255) NOT NULL,
    `sobrenome` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `senha` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id_registro`)
);
