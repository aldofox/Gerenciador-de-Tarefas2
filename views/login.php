<?php
require_once __DIR__ . '/layouts/header.php';

require_once '../config/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'];
    $password = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    
    if ($user && password_verify($password, $user['senha'])) {
        
        $_SESSION['user']= [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email']
        ];
        header('Location: /home');
        exit;
    }else{
        $error = "Credenciais inválidas.(login da views)";

    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login do Sistema</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
    body {
    font-family: "Poppins", sans-serif;
    background: #f0f2f5;
    margin: 0;
    min-height: 100vh;

    display: flex;
    flex-direction: column; /* empilha header, card e footer */
}

/* Container central para o card */
.main {
    flex: 1; /* ocupa o espaço entre header e footer */
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.card {
    background: #fff;
    border-radius: 12px;
    padding: 40px;
    width: 400px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    text-align: center;
}
        .card h3 {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .card h3 img {
            width: 40px;
            margin-right: 10px;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }
        .btn {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: none;
            background: #2ecc71;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="card">
            <h3>
                <img src="https://cdn-icons-png.flaticon.com/512/3064/3064197.png" alt="Login">
                Login
            </h3>
            <form method="POST" action="/login">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <button type="submit" class="btn">Entrar</button>
            </form>
            <?php if(isset($error)) echo $error; ?>
        </div>
    </div>
        <?php require_once __DIR__ . '/layouts/footer.php'; ?>
</body>
</html>