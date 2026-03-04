<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Tarefas</title>
    <!-- Fonte Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Header */
header {
    background: #2c3e50;
    color: #fff;
    padding: 15px 30px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

header h2 {
    margin: 0;
    font-size: 22px;
    color: #fff;
}

header nav a {
    color: #ecf0f1;
    text-decoration: none;
    margin-left: 20px;
    font-weight: bold;
    transition: color 0.3s;
}

header nav a:hover {
    color: #1abc9c;
}

/* Container principal */
.container {
    max-width: 1000px;
    margin: 20px auto;
    padding: 0 15px;
}

/* Footer */
footer {
    background: #2c3e50;
    color: #bdc3c7;
    text-align: center;
    padding: 15px;
    margin-top: 30px;
    font-size: 14px;
}
    </style>
</head>
<body>
<header>
    <div class="header-container">
        <h2><i class="fa-solid fa-list-check"></i> Sistema de Tarefas</h2>
        <nav>
            <?php if(isset($_SESSION['user'])): ?>
                <a href="/tarefas"><i class="fa-solid fa-tasks"></i> Tarefas</a>
                <a href="/logout"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
            <?php else: ?>
                <a href="/login"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<body>
    <div class="container">