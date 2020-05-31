<?php 

    namespace App;

    class Connection {

        public static function getDb(){
            try {

                $dsn = "mysql:host=localhost;dbname=twitter;charset=utf8";
                $root = "root";
                $pass = "";

                $conn = new \PDO($dsn, $root, $pass);

                return $conn;
            }catch(\PDOException $e){
                echo 'erro';
            }
        }
    }


?>