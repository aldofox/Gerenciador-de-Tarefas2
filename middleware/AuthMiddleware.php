<?php

class AuthMiddleware{
    public static function handle(){
        
        if(!isset($_SESSION['user'])){
            header('Location: /login');
            exit();
        }

        /*Expiraçao 30 minutos*/
        if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)){
            session_unset();
            session_destroy();
            header('Location: /login');
            exit();
        }
        $_SESSION['last_activity'] = time();
    }
}