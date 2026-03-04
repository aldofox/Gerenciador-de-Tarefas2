<?php
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../models/Tarefa.php';

class TarefaController {

private $model;
public function __construct()
{
    $this->model = new Tarefa();
}

// ➕ Formulário nova tarefa
public function create() {
    require_once __DIR__ . '/../views/tarefas/create.php';
}

// 💾 Salvar tarefa
public function store()
{
    $pdo = Database::getConnection();

    $dataVencimento = $_POST['data_vencimento'] ?? null;
    $tempoAlerta = $_POST['tempo_alerta'] ?? null;

    $lembrarEm = null;

    if ($dataVencimento && $tempoAlerta) {
        $lembrarEm = date(
            'Y-m-d H:i:s',
            strtotime($dataVencimento) - ($tempoAlerta * 60)
        );
    }

    $sql = "INSERT INTO tarefas 
            (titulo, descricao, prioridade, status, data_vencimento, lembrar_em, usuario_id) 
            VALUES 
            (:titulo, :descricao, :prioridade, :status, :data_vencimento, :lembrar_em, :usuario_id)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':titulo' => $_POST['titulo'],
        ':descricao' => $_POST['descricao'],
        ':prioridade' => $_POST['prioridade'],
        ':status' => $_POST['status'],
        ':data_vencimento' => $dataVencimento,
        ':lembrar_em' => $lembrarEm,
        ':usuario_id' => $_SESSION['user']['id']
    ]);

    header("Location: /tarefas");
    exit;
}

//Formulario de Ediçao
public function edit() {
    $id = $_GET['id'];

    $stmt = Database::getConnection()->prepare("SELECT * FROM tarefas WHERE id = ?");
    $stmt->execute([$id]);
    $tarefa = $stmt->fetch();

    require_once __DIR__ . '/../views/tarefas/edit.php';
}

// 🔄 Atualizar

public function update() {
    $id = $_POST['id'];

    $dados =[
        'titulo' => $_POST['titulo'],
        'descricao' => $_POST['descricao'],
        'prioridade' => $_POST['prioridade'],
        'status' => $_POST['status'],
        'data_vencimento' => $_POST['data_vencimento'],
        'lembrar_em' => $_POST['lembrar_em'] ? : null
    ];
    $this->model->update($id, $dados);
    header("Location: /tarefas");
    exit;
}

// Excluir
public function delete(){
    $id = $_GET['id'];
    $this->model->delete($id);
    header("Location: /tarefas");
    exit;
}
public function index()
{
    $pdo = Database::getConnection();
    $usuarioId = $_SESSION['user']['id'];

    $limite = 10;
    $pagina = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
    $pagina = max($pagina, 1);
    $offset = ($pagina - 1) * $limite;

    $where = ["usuario_id = :usuario_id"];
    $params = [':usuario_id' => $usuarioId];

    if (!empty($_GET['busca'])) {
        $where[] = "titulo LIKE :busca";
        $params[':busca'] = "%" . trim($_GET['busca']) . "%";
    }

    if (!empty($_GET['status'])) {
        $where[] = "status = :status";
        $params[':status'] = $_GET['status'];
    }

    if (!empty($_GET['prioridade'])) {
        $where[] = "prioridade = :prioridade";
        $params[':prioridade'] = $_GET['prioridade'];
    }

    $sql = "FROM tarefas WHERE " . implode(" AND ", $where);

    // 🔢 TOTAL REGISTROS
    $stmtCount = $pdo->prepare("SELECT COUNT(*) $sql");
    $stmtCount->execute($params);
    $totalRegistros = $stmtCount->fetchColumn();
    $totalPaginas = ceil($totalRegistros / $limite);

    // 📋 BUSCAR TAREFAS
    $stmt = $pdo->prepare("SELECT * $sql ORDER BY data_vencimento DESC LIMIT :limite OFFSET :offset");

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();
    $tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 📊 DASHBOARD
    $totalPendentes = $pdo->query("SELECT COUNT(*) FROM tarefas WHERE usuario_id = $usuarioId AND status = 'pendente'")->fetchColumn();
    $totalAndamento = $pdo->query("SELECT COUNT(*) FROM tarefas WHERE usuario_id = $usuarioId AND status = 'em_andamento'")->fetchColumn();
    $totalConcluidas = $pdo->query("SELECT COUNT(*) FROM tarefas WHERE usuario_id = $usuarioId AND status = 'concluida'")->fetchColumn();

    $agora = date('Y-m-d H:i:s');
    $stmtAlertas = $pdo->prepare("SELECT COUNT(*) FROM tarefas WHERE usuario_id = :usuario_id AND lembrar_em <= :agora AND status != 'concluida'");
    $stmtAlertas->execute([
        ':usuario_id' => $usuarioId,
        ':agora' => $agora
    ]);
    $totalAlertas = $stmtAlertas->fetchColumn();
    $temAlerta = $totalAlertas > 0;

    $pdo = Database::getConnection();
$usuarioId = $_SESSION['user']['id'];

// 📊 Status
$stmtStatus = $pdo->prepare("
    SELECT status, COUNT(*) as total 
    FROM tarefas 
    WHERE usuario_id = :usuario_id 
    GROUP BY status
");
$stmtStatus->execute([':usuario_id' => $usuarioId]);
$statusData = $stmtStatus->fetchAll(PDO::FETCH_ASSOC);

// 📊 Prioridade
$stmtPrioridade = $pdo->prepare("
    SELECT prioridade, COUNT(*) as total 
    FROM tarefas 
    WHERE usuario_id = :usuario_id 
    GROUP BY prioridade
");
$stmtPrioridade->execute([':usuario_id' => $usuarioId]);
$prioridadeData = $stmtPrioridade->fetchAll(PDO::FETCH_ASSOC);

// 📊 Tarefas por mês
$stmtMes = $pdo->prepare("
    SELECT DATE_FORMAT(created_at, '%Y-%m') as mes, COUNT(*) as total
    FROM tarefas
    WHERE usuario_id = :usuario_id
    GROUP BY mes
    ORDER BY mes
");
$stmtMes->execute([':usuario_id' => $usuarioId]);
$mesData = $stmtMes->fetchAll(PDO::FETCH_ASSOC);

    require_once __DIR__ . '/../views/tarefas/index.php';
}
}