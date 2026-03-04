<?php
require_once '../app/AuthMiddleware.php';
AuthMiddleware::check();
?>

<h1>Bem-vindo <?php echo $_SESSION['user']['name']; ?></h1>
<a href="/logout">Sair</a>
