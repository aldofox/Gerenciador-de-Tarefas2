# 📋 Sistema de Gerenciamento de Tarefas

![PHP](https://img.shields.io/badge/PHP-8%2B-777BB4?style=for-the-badge\&logo=php\&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge\&logo=mysql\&logoColor=white)
![Chart.js](https://img.shields.io/badge/Chart.js-4.x-FF6384?style=for-the-badge\&logo=chartdotjs\&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)
![Version](https://img.shields.io/badge/Version-1.0.0-blue?style=for-the-badge)

Sistema web desenvolvido em **PHP + PDO + MySQL**, com autenticação de usuários, dashboard com gráficos interativos e gerenciamento completo de tarefas.

---

## 🚀 Funcionalidades

### 👤 Autenticação

* Cadastro de usuário
* Login e Logout
* Sessão protegida

### ✅ Gerenciamento de Tarefas

* Criar tarefa
* Editar tarefa
* Excluir tarefa
* Listagem com paginação
* Filtros por:

  * Status
  * Prioridade
  * Busca por texto

### ⏰ Sistema de Alertas

* Lembrete com data e hora
* Destaque visual para tarefas vencidas
* Notificação automática via `alert()`

### 📊 Dashboard com Gráficos (Chart.js)

* Gráfico de Status (Doughnut)
* Gráfico de Prioridade (Bar)
* Gráfico de Tarefas por Mês (Line)
* Layout responsivo

---

## 🛠 Tecnologias Utilizadas

* PHP 8+
* PDO (PHP Data Objects)
* MySQL
* HTML5
* CSS3
* JavaScript
* Chart.js

---

## 🗄 Estrutura do Projeto

```
/app
   /controllers
   /models
   /views
       /layouts
/config
/public
```

---

## ⚙️ Configuração do Projeto

### 1️⃣ Clonar o repositório

```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
```

---

### 2️⃣ Criar o banco de dados

```sql
CREATE DATABASE tarefas_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE tarefas_db;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tarefas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  titulo VARCHAR(150) NOT NULL,
  descricao TEXT,
  status ENUM('pendente','em_andamento','concluida') DEFAULT 'pendente',
  prioridade ENUM('baixa','media','alta') DEFAULT 'media',
  lembrar_em DATETIME NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES users(id) ON DELETE CASCADE
);
```

---

### 3️⃣ Configurar conexão com banco

Copie o arquivo `.env.example` para `.env` e ajuste os valores conforme seu ambiente:

```bash
cp .env.example .env
```

Variáveis disponíveis:

| Variável  | Descrição              | Padrão      |
|-----------|------------------------|-------------|
| `DB_HOST` | Host do banco de dados | `localhost` |
| `DB_NAME` | Nome do banco de dados | `tarefas`   |
| `DB_USER` | Usuário do banco       | `root`      |
| `DB_PASS` | Senha do banco         | *(vazio)*   |

As variáveis de ambiente são lidas em `config/Database.php` via `getenv()`. Você pode defini-las diretamente no servidor (Apache, Nginx, Docker, etc.) ou exportá-las no shell antes de iniciar o PHP.

---

### 4️⃣ Rodar o projeto

Se estiver usando PHP embutido, exporte as variáveis e inicie o servidor:

```bash
export DB_HOST=localhost
export DB_NAME=tarefas
export DB_USER=root
export DB_PASS=
php -S localhost:8000 -t public
```

Acesse:

```
http://localhost:8000
```

---

## 🔐 Segurança

* Senhas criptografadas com `password_hash()`
* Prepared Statements (PDO)
* Proteção contra SQL Injection
* Controle de sessão

---

## 🧠 Melhorias Futuras

* Modo Dark
* Exportação de relatório em PDF
* Filtro por período (7 dias, 30 dias)
* API REST
* Deploy em servidor

---

## 👨‍💻 Autor

Desenvolvido por **Aldo da Silveira**

---

## 📄 Licença

Este projeto está sob a licença MIT.
