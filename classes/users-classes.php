<?php
    class Users extends Dbh 
    {
        private $userid;
        private $name;
        private $email;
        private $pwd;
        private $status;
        private $lastLogin;
      

        public function getUserID() {
            return $this->UserID;
        }
    
        public function setUserID($userid) {
            $this->userid = $userid;
        }

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
            return $this->status;
        }
    
        public function setloginStatus($status) {
            $this->status = $status;
        }

        public function getlastLogin() {
            return $this->lastLogin;
        }
    
        public function setlastLogin($lastLogin) {
            $this->lastLogin = $lastLogin;
        }


        public function GetAllUsersButMe() {
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE user_id != :user_id;');
            $stmt->bindParam(':user_id', $this->userid, PDO::PARAM_INT);
            if(!$stmt->execute()){
                $stmt = null;
                header("location: login.php?error=stmtfailed");
                exit();
            }
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
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


        public function GetAllOnliners() {
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE login_status = :login_status;');
            $stmt->bindParam(':login_status', $this->status);
            if(!$stmt->execute()){
                $stmt = null;
                header("location: login.php?error=stmtfailed");
                exit();
            }
            $onliners = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $onliners;
        }


        public function GetViewedUser() {
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE user_id = :userid;');
            $stmt->bindParam(':userid', $this->userid, PDO::PARAM_INT);
            if(!$stmt->execute()){
                $stmt = null;
                header("location: login.php?error=stmtfailed");
                exit();
            }
            if(!$user = $stmt->fetchAll(PDO::FETCH_ASSOC)){
                header("location: profile.php?user=deleted");
            }
            return $user;
            
        }

        public function DeleteUser() {
            $stmt = $this->connect()->prepare('DELETE FROM users WHERE user_id = :user_id;');
            $stmt->bindParam(':user_id', $this->userid, PDO::PARAM_INT);
            if(!$stmt->execute()){
                $stmt = null;
                header("location: login.php?error=stmtfailed");
                exit();
            }
            
        }

    


    }


?>