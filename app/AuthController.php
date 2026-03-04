<?php
require_once __DIR__ . '../../config/Database.php';

class AuthController {
    public function showlogin() {
        require_once __DIR__ . '../../views/login.php';
    }
    public function login() {

        $pdo = Database::getConnection();

        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($senha, $user['senha'])) {

                session_regenerate_id(true);

                $_SESSION['user'] = $user;
                $_SESSION['last_activity'] = time();

                header('Location: /tarefas');
                exit;
            } 
            echo "Email ou senha inválidos.";
            var_dump($senha);
exit;
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }
    
    public function homeRedirect() {

        if (isset($_SESSION['user'])) {
            header("Location: /tarefas");
        } else {
            header("Location: /login");
        }

        exit;
    }
}