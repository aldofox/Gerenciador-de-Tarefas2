<?php

require_once '../config/Database.php';

$pdo = Database::getConnection();

$name= 'Flora';
$email= 'flora@gmail.com';
$senha = password_hash('123456', PASSWORD_DEFAULT);
$role = 'admin';
$ativo = 1;

$stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, role, ativo) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$name, $email, $senha, $role, $ativo]);
echo "Usuario criado com sucesso!";