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

        public function GetAllUsers() {
            $stmt = $this->connect()->prepare('SELECT * FROM users');
            if(!$stmt->execute()){
                $stmt = null;
                header("location: login.php?error=stmtfailed");
                exit();
            }
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        }


        public function GetAllUsersExceptMe() {
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

        public function GetAllOnliners() {
            $online = 1;
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE login_status = :login_status;');
            $stmt->bindParam(':login_status', $online);
            if(!$stmt->execute()){
                $stmt = null;
                header("location: login.php?error=stmtfailed");
                exit();
            }
            $onliners = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $onliners;
            
        }


        public function GetViewedUser() {
            $currentUser = $_GET['user'];
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE user_id = :userid;');
            $stmt->bindParam(':userid', $currentUser);
            if(!$stmt->execute()){
                $stmt = null;
                header("location: login.php?error=stmtfailed");
                exit();
            }
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $user;
            
        }


    


    }


?>