<?php
    class conexao {

        private static $host = '127.0.0.1';
        private static $user = 'root';
        private static $pass = '';
        private static $dbname = 'painel-site';
        private static $conn;

        public static function getconn() {
            try {
                self::$conn = new PDO("mysql:host=".self::$host.";dbname=".self::$dbname, self::$user, self::$pass);
                return ['result' => true, 'data' => self::$conn]; }
            catch(PDOException $err) {
                return ['result' => false, 'error' => $err->getMessage()]; }
        }

        public static function database() {
            $result = self::$conn->prepare("
                CREATE TABLE IF NOT EXISTS `users` (
                    `id` int(11) NOT NULL,
                    `nome` varchar(220) NOT NULL,
                    `email` varchar(220) NOT NULL,
                    `login` varchar(220) NOT NULL,
                    `senha` varchar(220) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

    }
?>