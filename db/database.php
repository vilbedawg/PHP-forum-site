<?php
    class DbConnect {
        private $host = 'localhost';
        private $dbName = 'websocket';
        private $username = "root";
        private $pass = '';

        public function connect() {
            try {
                $conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbName, $this->username, $this->pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            } catch(PDOException $e) {
                echo "Jokin meni pieleen :(" . $e->getMessage();
            }
        }
    }


?>