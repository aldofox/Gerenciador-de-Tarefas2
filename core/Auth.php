<?php

class Auth{
    public static function check() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
    }

    public static function user() {
        return $_SESSION ?? null;
    }

    public static function role() {
        return $_SESSION['usuario_role'] ?? null;
    }

    public static function isAdmin(){
        return self::role() === 'admin';
    }

    public static function requiredAdmin() {
        self::check();
        if (!self::isAdmin()) {
            http_response_code(403);
            require_once '../views/403.php';
            exit();
        }
    }

    public static function attempt($usuario) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];
    }

    public static function logout() {
        $_SESSION = [];

        if(ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
        header('Location: /login');
    }
}