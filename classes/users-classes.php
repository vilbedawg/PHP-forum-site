<?php
    class Users extends Dbh 
    {
        private $name;
        private $email;
        private $pwd;
        private $loginStatus;
        private $lastLogin;
        private $user_token;
        private $user_connection_id;
      

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

        public function setUserToken($user_token) {
            $this->user_token = $user_token;
        }

        public function getUserToken() {
            return $this->user_token;
        }

        public function setUserConnectionId($user_connection_id) {
            $this->user_connection_id = $user_connection_id;
        }

        public function getUserConnectionId() {
            return $this->user_connection_id;
        }



        public function GetAllUsers() {
            $session = $_SESSION['userid'];
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE user_id != :userid;');
            $stmt->bindParam(':userid', $session);
            if(!$stmt->execute()){
                $stmt = null;
                header("location: login.php?error=stmtfailed");
                exit();
            }
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
            
        }

        public function update_user_connection_id()
        {
            $query = "UPDATE users SET user_connection_id = :user_connection_id WHERE user_token = :user_token";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':user_connection_id', $this->user_connection_id);

            $stmt->bindParam(':user_token', $this->user_token);

            $stmt->execute();
        }

    }


?>