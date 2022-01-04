<?php
    class Users extends Dbh 
    {
        private $userid;
        private $name;
        private $email;
        private $pwd;
        private $status;
        private $lastLogin;
      

        // Getters ja setters

        public function getUserID() {
            return $this->userid;
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


        //Kaikki käyttäjät, poislukien itse
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
            exit();
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
            exit();
        }


        //haetaan kaikki, jotka ovat kirjautuneena sisään
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
            exit();
        }


        //haetaan käyttäjän dataa. Profiilin ja profiilin hallinnan sivulla luodaan olio ja kutsutaan tätä funktiota 
        //$_GET parametrilla.
        public function GetViewedUser() {
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE user_id = :userid;');
            $stmt->bindParam(':userid', $this->userid, PDO::PARAM_INT);
            if(!$stmt->execute()){
                $stmt = null;
                header("location: login.php?error=stmtfailed");
                exit();
            }
            if(!$user = $stmt->fetchAll(PDO::FETCH_ASSOC)){
                header("Location: home.php?show=Etusivu#user=noexist");
                exit();
            }
            return $user;
            exit();
            
        }

        // kutsutaan, kun käyttäjä luo uuden julkaisun. Ohjataan käyttäjä uusimman julkaisunsa sivulle 
        public function GetMostRecent() {
            $stmt = $this->connect()->prepare('SELECT MAX(post_id) FROM posts WHERE user_id = :userid;');
            $stmt->bindParam(':userid', $this->userid, PDO::PARAM_INT);
            if(!$stmt->execute()){
                $stmt = null;
                header("location: login.php?error=stmtfailed");
                exit();
            }
            if(!$recentPost = $stmt->fetch(PDO::FETCH_ASSOC)){
                header("Location: home.php?show=Etusivu#user=noexist");
                exit();
            }
            return $recentPost;
            exit();
        }


    }


?>