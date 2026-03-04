CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    role ENUM('admin','colaborador') DEFAULT 'colaborador',
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descricao TEXT,
    prioridade ENUM('baixa','media','alta') DEFAULT 'media',
    status ENUM('pendente','em_andamento','concluida') DEFAULT 'pendente',
    usuario_id INT,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    acao VARCHAR(100),
    tabela_afetada VARCHAR(100),
    registro_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,

    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,

    prioridade ENUM('baixa','media','alta') DEFAULT 'media',
    status ENUM('pendente','em_andamento','concluida') DEFAULT 'pendente',

    data_vencimento DATETIME,
    lembrar_em DATETIME NULL,

    usuario_id INT NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_tarefa_usuario 
        FOREIGN KEY (usuario_id) 
        REFERENCES users(id) 
        ON DELETE CASCADE,

    INDEX idx_usuario (usuario_id),
    INDEX idx_status (status),
    INDEX idx_vencimento (data_vencimento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE tarefas
ADD COLUMN visivel BOOLEAN DEFAULT TRUE;

ALTER TABLE tarefas
DROP FOREIGN KEY fk_tarefa_usuario;

ALTER TABLE tarefas
ADD CONSTRAINT fk_tarefa_usuario
FOREIGN KEY (usuario_id)
REFERENCES usuarios(id)
ON DELETE CASCADE
