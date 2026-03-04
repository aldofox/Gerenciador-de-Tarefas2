<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Nova Tarefa</title>
        <style>
            body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column; /* força header em cima e conteúdo abaixo */
        min-height: 100vh;
    }
    header {
        width: 100%;
        background-color: #333;
        color: white;
        padding: 15px;
        text-align: center;
        display: block; /* garante que ocupe toda a largura */
    }


    .container {
        flex: 1; /* ocupa o espaço restante abaixo do header */
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }



            .card {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        width: 400px;
    }

            .card h2 {
                text-align: center;
                margin-bottom: 20px;
                color: #333;
            }

            label {
                font-weight: bold;
                color: #555;
            }

            input[type="text"],
            textarea,
            select,
            input[type="datetime-local"] {
                width: 100%;
                padding: 10px;
                margin-top: 5px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 6px;
                font-size: 14px;
            }

            textarea {
                resize: vertical;
                min-height: 80px;
            }

            button {
                width: 100%;
                padding: 12px;
                background-color: #4CAF50;
                border: none;
                border-radius: 6px;
                color: white;
                font-size: 16px;
                cursor: pointer;
                transition: background 0.3s ease;
            }

            button:hover {
                background-color: #45a049;
            }
            .btn {
                display: inline-block;
                padding: 8px 14px;
                margin: 5px 0;
                border-radius: 6px;
                text-decoration: none;
                font-size: 14px;
                transition: 0.3s;
            }
            .btn {
                background: #2ecc71;
                color: #fff;
            }
            .btn:hover {
                opacity: 0.85;
            }

        </style>
        <?php require_once __DIR__ . '/../layouts/header.php'; ?>
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>Nova Tarefa</h2>
            <form method="POST" action="/tarefas/store">
                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" placeholder="Título" required>

                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" placeholder="Descrição"></textarea>

                <label for="prioridade">Prioridade</label>
                <select id="prioridade" name="prioridade">
                    <option value="baixa">Baixa</option>
                    <option value="media">Média</option>
                    <option value="alta">Alta</option>
                </select>

                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="pendente">Pendente</option>
                    <option value="em_andamento">Em Andamento</option>
                    <option value="concluida">Concluída</option>
                </select>

                <label>Disparar alerta:</label>
                <select name="tempo_alerta">
                    <option value="">Sem alerta</option>
                    <option value="30">30 minutos antes</option>
                    <option value="60">1 hora antes</option>
                    <option value="1440">1 dia antes</option>
                </select>

                <label for="data_final">Data Final</label>
                <input type="datetime-local" id="data_vencimento" name="data_vencimento">

                <button type="submit"> 💾 Salvar</button>
                <a href="/tarefas/" class="btn">Voltar</a>
            </form>
        </div>
    </div>
    
    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>