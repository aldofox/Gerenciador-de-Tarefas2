<p>Ola, <?= $_SESSION['usuario_id'] ?> | <a href="/logout">Sair</a></p>
<h1>Lista de Tarefas</h1>
<?php foreach ($tarefas as $tarefas): ?>
    <p><?= $tarefa['titulo'] ?></p>
<?php endforeach; ?>