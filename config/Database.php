<?php

class Database {

    private static $connection = null;

    public static function getConnection() {

        if (self::$connection === null) {

            $host = "localhost";
            $db   = "tarefas";
            $user = "root";
            $pass = "aldo";

            try {

                self::$connection = new PDO(
                    "mysql:host=$host;dbname=$db;charset=utf8",
                    $user,
                    $pass
                );

                self::$connection->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

            } catch (PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
