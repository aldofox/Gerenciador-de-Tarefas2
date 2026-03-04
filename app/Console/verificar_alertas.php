<?php

require_once __DIR__ . '/../../config/Database.php';

$db = Database::getConnection();

$stmt = $db->prepare("
    SELECT * FROM tarefas
    WHERE lembrar_em IS NOT NULL
    AND lembrar_em <= NOW()
    AND alertado = 0
    AND status != 'concluida'
");

$stmt->execute();
$tarefas = $stmt->fetchAll();

foreach ($tarefas as $tarefa) {

    echo "🔔 Alerta: A tarefa '{$tarefa['titulo']}' está próxima do vencimento!\n";

    // Aqui futuramente pode virar:
    // email
    // notificação
    // push
    // etc

    $update = $db->prepare("UPDATE tarefas SET alertado = 1 WHERE id = ?");
    $update->execute([$tarefa['id']]);
}

echo "Verificação concluída.\n";