<?php
    class Users extends Dbh 
    {
        private $name;
        private $email;
        private $pwd;
        private $loginStatus;
        private $lastLogin;
      

        public function getName() {
            return $this->name;
        }
    
        public function setName($name) {
            $this->name = $name;
        }
    
        public function getEmail() {
            return $this->email;
        }
    
        public function setEmail($email) {
            $this->email = $email;
        }

        public function getPwd() {
            return $this->pwd;
        }
    
        public function setPwd($pwd) {
            $this->pwd = $pwd;
        }

        public function getloginStatus() {
            return $this->loginStatus;
        }
    
        public function setloginStatus($loginStatus) {
            $this->loginsStatus = $loginStatus;
        }

        public function getlastLogin() {
            return $this->lastLogin;
        }
    
        public function setlastLogin($lastLogin) {
            $this->lastLogin = $lastLogin;
        }


        public function GetAllUsers() {
            $stmt = $this->connect()->prepare('SELECT * FROM users;');
            if(!$stmt->execute()){
                $stmt = null;
                header("location: login.php?error=stmtfailed");
                exit();
            }
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        }

    }


?>