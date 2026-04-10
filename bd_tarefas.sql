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
ON DELETE CASCADE;

-- =============================================
-- Indexes for `tarefas` table
-- =============================================

-- Filtering by priority (WHERE prioridade = ?) and GROUP BY prioridade
ALTER TABLE tarefas ADD INDEX idx_prioridade (prioridade);

-- Alert queries: WHERE lembrar_em <= NOW() / lembrar_em IS NOT NULL
ALTER TABLE tarefas ADD INDEX idx_lembrar_em (lembrar_em);

-- Monthly report chart: GROUP BY DATE_FORMAT(created_at, '%Y-%m')
ALTER TABLE tarefas ADD INDEX idx_created_at (created_at);

-- Soft-delete filtering: WHERE deleted_at IS NULL
ALTER TABLE tarefas ADD INDEX idx_deleted_at (deleted_at);

-- Composite: most common query pattern (dashboard counts, list filtering)
-- WHERE usuario_id = ? AND status = ?
ALTER TABLE tarefas ADD INDEX idx_usuario_status (usuario_id, status);

-- Composite: task list sorted by due date per user
-- WHERE usuario_id = ? ORDER BY data_vencimento DESC
ALTER TABLE tarefas ADD INDEX idx_usuario_data_vencimento (usuario_id, data_vencimento);

-- Composite: priority grouping per user (chart queries)
-- WHERE usuario_id = ? GROUP BY prioridade
ALTER TABLE tarefas ADD INDEX idx_usuario_prioridade (usuario_id, prioridade);

-- Composite: monthly chart per user
-- WHERE usuario_id = ? GROUP BY DATE_FORMAT(created_at, '%Y-%m')
ALTER TABLE tarefas ADD INDEX idx_usuario_created_at (usuario_id, created_at);

-- Composite: alert system queries
-- WHERE lembrar_em <= NOW() AND status != 'concluida'
ALTER TABLE tarefas ADD INDEX idx_lembrar_em_status (lembrar_em, status);

-- =============================================
-- Indexes for `usuarios` table
-- =============================================

-- email already has a UNIQUE constraint (implicit index)
-- Filtering active/inactive users: WHERE ativo = ?
ALTER TABLE usuarios ADD INDEX idx_ativo (ativo);

-- Role-based filtering: used in application logic to determine query scope
ALTER TABLE usuarios ADD INDEX idx_role (role);
