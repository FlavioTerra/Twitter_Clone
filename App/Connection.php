<?php

    namespace App;

    class Connection {

        private static $host = 'localhost';
        private static $dbname = 'mvc';
        private static $user = 'root';
        private static $pass = '';
        private static $charset = 'utf8';

        public static function getDb() {
            try {
                $conexao = new \PDO(
                    'mysql:host=' . Connection::$host . ';dbname=' . Connection::$dbname . ';charset=' . Connection::$charset, 
                    Connection::$user, 
                    Connection::$pass
                );
                
                return $conexao;

            } catch(\PDOException $err) {
                echo '<p>Erro: ' . $err->getCode() . '<br>Mensagem: ' . $err->getMessage() . '</p>';
                echo '<p><br>Linha: ' . $err->getLine() . '<br>Arquivo: ' . $err->getFile() . '</p>';
            }
        }
    }

?>