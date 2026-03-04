<?php
require_once __DIR__ . '/../config/Database.php';

class Tarefa {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM tarefas WHERE deleted_at IS NULL");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM tarefas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    //Bucar tarefas conforme role
    public function getAll($usuario) {
        if ($usuario['role'] === 'admin') {
            $stmt = $this->db->query("
                SELECT t.*, u.nome AS usuario_nome
                FROM tarefas t
                JOIN usuarios u ON t.usuario_id = u.id
                ORDER BY t.data_vencimento ASC
            ");
            return $stmt->fetchAll();
        }

        $stmt = $this->db->prepare("
            SELECT * FROM tarefas
            WHERE usuario_id = ?
            ORDER BY ddata_vencimento ASC
        ");

        $stmt->execute([$usuario['id']]);
        return $stmt->fetchAll();
    }

    // ➕ Criar Tarefa

    public function create($dados) {
        $stmt = $this->db->prepare("
                INSERT INTO tarefas
                (titulo, descricao, prioridade, status, data_vencimento, lembrar_em, usuario_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
        

            return $stmt->execute([
                $dados['titulo'],
                $dados['descricao'],
                $dados['prioridade'],
                $dados['status'],
                $dados['data_vencimento'],
                $dados['lembrar_em'],
                $dados['usuario_id'],

            ]);
    }

    //❌ Excluir
    public function delete ($id) {
        $stmt = $this->db->prepare("DELETE FROM tarefas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    

    // ✏ Editar
    public function update()
{
    $pdo = Database::getConnection();

    $id = $_POST['id'] ?? null;

    if (!$id) {
        die("ID não informado.");
    }

    $dataVencimento = $_POST['data_vencimento'] ?? null;
    $tempoAlerta = $_POST['tempo_alerta'] ?? null;

    $lembrarEm = null;

    if ($dataVencimento && $tempoAlerta) {
        $lembrarEm = date(
            'Y-m-d H:i:s',
            strtotime($dataVencimento) - ($tempoAlerta * 60)
        );
    }

    $sql = "UPDATE tarefas SET
                titulo = :titulo,
                descricao = :descricao,
                prioridade = :prioridade,
                status = :status,
                data_vencimento = :data_vencimento,
                lembrar_em = :lembrar_em
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':titulo' => $_POST['titulo'],
        ':descricao' => $_POST['descricao'],
        ':prioridade' => $_POST['prioridade'],
        ':status' => $_POST['status'],
        ':data_vencimento' => $dataVencimento,
        ':lembrar_em' => $lembrarEm,
        ':id' => $id
    ]);

    header("Location: /tarefas");
    exit;
}
}