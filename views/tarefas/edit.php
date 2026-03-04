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
                <h2>Editar Tarefa</h2>
                
                <form method="POST" action="/tarefas/update">
                    <input type="hidden" name="id" value="<?= $tarefa['id'] ?>">
                    <input type="text" name="titulo" value="<?= $tarefa['titulo'] ?>"><br><br>
                    <textarea name="descricao"><?= $tarefa['descricao']?></textarea><br><br>

                    <select name="prioridade">
                        <option value="baixa" <?= $tarefa['prioridade'] == 'baixa' ? 'selected' : '' ?>>Baixa</option>
                        <option value="media" <?= $tarefa['prioridade'] == 'media' ? 'selected' : '' ?>>Média</option>
                        <option value="alta" <?= $tarefa['prioridade'] == 'alta' ? 'selected' : '' ?>>Alta</option>
                    </select><br><br>

                    <select name="status">
                        <option value="pendente" <?= $tarefa['status'] == 'pendente' ? 'selected' : '' ?>>Pendente</option>
                        <option value="em_andamento" <?= $tarefa['status'] == 'em_andamento' ? 'selected' : '' ?>>Em andamento</option>
                        <option value="concluida" <?= $tarefa['status'] == 'concluida' ? 'selected' : '' ?>>Concluída</option>
                    </select><br><br>
                    
                    <input type="datetime-local" name="data_vencimento" value="<?= !empty($tarefa['data_vencimento']) 
                            ? date('Y-m-d\TH:i', strtotime($tarefa['data_vencimento'])) 
                            : '' ?> placeholder="Data Inicial"><br><br>

                    <input type="datetime-local" name="lembrar_em" value="<?= !empty($tarefa['lembrar_em']) 
                            ? date('Y-m-d\TH:i', strtotime($tarefa['lembrar_em'])) 
                            : '' ?> placeholder="Lembrete de Tarefa"><br><br>


                    <button type="submit"> 💾 Atulizar</button>
                </form>
            </div>
        </div>
    
    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>