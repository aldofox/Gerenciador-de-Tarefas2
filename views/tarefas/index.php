<?php
// Proteção contra variáveis indefinidas
$totalAlertas     = $totalAlertas     ?? 0;
$totalPendentes   = $totalPendentes   ?? 0;
$totalAndamento   = $totalAndamento   ?? 0;
$totalConcluidas  = $totalConcluidas  ?? 0;
$temAlerta        = $temAlerta        ?? false;
$agora            = $agora            ?? date('Y-m-d H:i:s');
$tarefas          = $tarefas          ?? [];
$pagina           = $pagina           ?? 1;
$totalPaginas     = $totalPaginas     ?? 1;
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Minhas Tarefas</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: "Poppins", sans-serif;
    overflow-x: hidden;
}

.card {
    background: #fcfcfc;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.card-alta { border-left: 5px solid #ff4d4d; }
.card-media { border-left: 5px solid #ffc107; }
.card-baixa { border-left: 5px solid #28a745; }

.status {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    color: #fff;
}

.status.pendente { background: #6c757d; }
.status.em_andamento { background: #007bff; }
.status.concluida { background: #28a745; }

.btn {
    display: inline-block;
    padding: 8px 14px;
    margin: 5px 0;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    color: #fff;
    background: #2ecc71;
}

.btn.edit { background: #3498db; }
.btn.delete { background: #e74c3c; }

.card-alerta {
    border: 2px solid red;
    animation: piscar 1s infinite;
}

@keyframes piscar {
    0% { box-shadow: 0 0 5px red; }
    50% { box-shadow: 0 0 20px red; }
    100% { box-shadow: 0 0 5px red; }
}

.dashboard {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
}

.das-card {
    background: #dddee0;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid #ddd;
    flex: 1;
    text-align: center;
}

/* ====== GRÁFICOS ====== */

.graficos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, mimax(350px, 1fr));
    gap: 20px;
    margin-top: 60px;
    width: 80%;
}

.grafico-linha {
    margin-top: 30px;
    width: 80%;
}

.graficos-grid canvas,
.grafico-linha canvas {
    width: 80% !important;
    height: 350px !important;
    background: #fff;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

/* Responsivo */
@media (max-width: 900px) {
    .graficos-grid {
        grid-template-columns: 1fr;
    }
}

            label {
                font-weight: bold;
                color: #555;
            }

            input[type="text"],
            select
            {
                width: 50%;
                padding: 10px;
                margin-top: 5px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 6px;
                font-size: 14px;
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
</head>

<body>

<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<p>Bem-vindo, <?= $_SESSION['user']['nome'] ?? '' ?></p>

<h2>Minhas Tarefas</h2>
<a href="/tarefas/create" class="btn">+ Nova Tarefa</a>

<hr>

<div class="dashboard">
    <div class="das-card">
        <h3>🔔 Total de Alertas</h3>
        <p><?= $totalAlertas ?></p>
    </div>

    <div class="das-card">
        <h3>⏳ Pendentes</h3>
        <p><?= $totalPendentes ?></p>
    </div>

    <div class="das-card">
        <h3>🚀 Em Andamento</h3>
        <p><?= $totalAndamento ?></p>
    </div>

    <div class="das-card">
        <h3>✔ Concluídas</h3>
        <p><?= $totalConcluidas ?></p>
    </div>
</div>

<!-- FORM FILTRO -->
<form method="GET" style="margin-bottom:20px; display:flex; gap:10px; flex-wrap:wrap;">
    <input type="text" name="busca" placeholder="Buscar tarefa..."
        value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">

    <select name="status">
        <option value="">Todos Status</option>
        <option value="pendente" <?= (($_GET['status'] ?? '') == 'pendente') ? 'selected' : '' ?>>Pendente</option>
        <option value="concluida" <?= (($_GET['status'] ?? '') == 'concluida') ? 'selected' : '' ?>>Concluída</option>
        <option value="em_andamento" <?= (($_GET['status'] ?? '') == 'em_andamento') ? 'selected' : '' ?>>Em Andamento</option>
    </select>

    <select name="prioridade">
        <option value="">Todas Prioridades</option>
        <option value="alta" <?= (($_GET['prioridade'] ?? '') == 'alta') ? 'selected' : '' ?>>Alta</option>
        <option value="media" <?= (($_GET['prioridade'] ?? '') == 'media') ? 'selected' : '' ?>>Média</option>
        <option value="baixa" <?= (($_GET['prioridade'] ?? '') == 'baixa') ? 'selected' : '' ?>>Baixa</option>
    </select>

    <button type="submit" class="btn">Filtrar</button>
</form>

<!-- LISTA DE CARDS -->
<?php foreach ($tarefas as $tarefa): 

    $classePrioridade = match($tarefa['prioridade']) {
        'alta' => 'card-alta',
        'media' => 'card-media',
        'baixa' => 'card-baixa',
        default => ''
    };

    $alertaAtivo = (
        !empty($tarefa['lembrar_em']) &&
        $tarefa['lembrar_em'] <= $agora &&
        $tarefa['status'] !== 'concluida'
    );
?>

<div class="card <?= $classePrioridade ?> <?= $alertaAtivo ? 'card-alerta' : '' ?>">

    <h3><?= htmlspecialchars($tarefa['titulo']) ?></h3>

    <span class="status <?= $tarefa['status'] ?>">
        <?= ucfirst(str_replace('_',' ', $tarefa['status'])) ?>
    </span>

    <p><?= htmlspecialchars($tarefa['descricao']) ?></p>

    <small>
        Termina Em:
        <?= !empty($tarefa['lembrar_em']) 
            ? date('d/m/Y H:i', strtotime($tarefa['lembrar_em'])) 
            : '-' ?>
    </small>

    <div>
        <a href="/tarefas/edit?id=<?= $tarefa['id'] ?>" class="btn edit">Editar</a>
        <a href="/tarefas/delete?id=<?= $tarefa['id'] ?>" class="btn delete">Excluir</a>
    </div>

</div>

<?php endforeach; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="graficos-grid">
    <canvas id="statusChart"></canvas>
    <canvas id="prioridadeChart"></canvas>
</div>

<div class="grafico-linha">
    <canvas id="mesChart"></canvas>
</div>

<script>
    const statusData = <?= json_encode($statusData ?? []) ?>;
    const prioridadeData = <?= json_encode($prioridadeData) ?>;
    const mesData = <?= json_encode($mesData) ?>;
</script>

<script>

// 🎯 Status
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: statusData.map(item => item.status),
        datasets: [{
            data: statusData.map(item => item.total),
        }]
    },
    options: {
    responsive: true,
    maintainAspectRatio: false
}
});

// 🎯 Prioridade
new Chart(document.getElementById('prioridadeChart'), {
    type: 'bar',
    data: {
        labels: prioridadeData.map(item => item.prioridade),
        datasets: [{
            label: 'Quantidade',
            data: prioridadeData.map(item => item.total),
        }]
    },
    options: {
    responsive: true,
    maintainAspectRatio: false
}
});

// 🎯 Por mês
new Chart(document.getElementById('mesChart'), {
    type: 'line',
    data: {
        labels: mesData.map(item => item.mes),
        datasets: [{
            label: 'Tarefas Criadas',
            data: mesData.map(item => item.total),
            fill: false,
            tension: 0.3
        }]
    },
    options: {
    responsive: true,
    maintainAspectRatio: false
}
});

</script>

<!-- PAGINAÇÃO -->
<div style="margin-top:20px;">
<?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
    <a href="?<?= http_build_query(array_merge($_GET, ['pagina' => $i])) ?>"
        style="margin-right:5px;
            padding:6px 10px;
            text-decoration:none;
            background:<?= ($i == $pagina) ? '#ff0000' : '#333' ?>;
            color:white;">
        <?= $i ?>
    </a>
<?php endfor; ?>
</div>

<?php if ($temAlerta): ?>
<script>
if (!localStorage.getItem('alertaMostrado')) {
    setTimeout(() => {
        alert('Você tem tarefas com lembretes ativos!');
        localStorage.setItem('alertaMostrado', 'true');
    }, 500);
}
</script>
<?php endif; ?>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

</body>
</html>