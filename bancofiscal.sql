-- Criação do banco de dados Fiscal Cidadão
CREATE DATABASE fiscal_cidadao;
USE fiscal_cidadao;
-- Tabela de usuários
CREATE TABLE usuarios (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  telefone VARCHAR(20),
  endereco VARCHAR(255),
  cidade VARCHAR(100),
  estado CHAR(2),
  cep VARCHAR(10),
  data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orgaos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(255) NOT NULL
);

-- Tabela de chamados
CREATE TABLE chamados (
  id INT PRIMARY KEY AUTO_INCREMENT,
  titulo VARCHAR(255) NOT NULL,
  descricao TEXT NOT NULL,
  cep VARCHAR(10) NOT NULL,           -- Campo para armazenar o CEP
  endereco VARCHAR(255) NOT NULL,     -- Campo para armazenar o endereço completo
  data_hora DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  status ENUM('pendente', 'em_progresso', 'concluido') DEFAULT 'pendente',
  usuario_id INT NOT NULL,
  orgao_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (orgao_id) REFERENCES orgaos(id) ON DELETE SET NULL,
  INDEX idx_status (status),
  INDEX idx_usuario_id (usuario_id),
  INDEX idx_orgao_id (orgao_id)
);


SELECT * FROM usuarios WHERE id = 2;  -- Exemplo para o usuário
SELECT * FROM orgaos WHERE id = 4;    -- Exemplo para o órgão
INSERT INTO orgaos (nome)
VALUES 
  ('Secretaria de Saúde'),
  ('Departamento de Trânsito'),
  ('Prefeitura Municipal'),
    ('Detran');



SHOW GRANTS FOR 'root'@'localhost';
DESCRIBE chamados;
select *from orgaos;

select * from usuarios;

ALTER TABLE chamados MODIFY localizacao POINT NOT NULL;
ALTER TABLE chamados ADD SPATIAL INDEX (localizacao);
select*from chamados;

-- Tabela de histórico de status
CREATE TABLE historico_status (
  id INT PRIMARY KEY AUTO_INCREMENT,
  chamado_id INT NOT NULL,
  status ENUM('pendente', 'em_progresso', 'concluido') NOT NULL,
  data_alteracao DATETIME DEFAULT CURRENT_TIMESTAMP,
  observacao TEXT,
  FOREIGN KEY (chamado_id) REFERENCES chamados(id) ON DELETE CASCADE
);

-- Tabela de notificações
CREATE TABLE notificacoes (
  id INT PRIMARY KEY AUTO_INCREMENT,
  chamado_id INT NOT NULL,
  usuario_id INT NOT NULL,
  mensagem TEXT NOT NULL,
  lida BOOLEAN DEFAULT FALSE,
  data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (chamado_id) REFERENCES chamados(id) ON DELETE CASCADE,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

