<?php

    class users {
        private $id;
        private $fname;
        private $lname;
        private $email;
        private $password;
        private $img;
        private $loginStatus;
        private $lastLogin;
        private $dbConn;

        //GETTER JA SETTER FUNKTIOT

        function setId($id) { $this->id = $id; }
        function getId() { return $this->id; }

        function setFname($fname) { $this->fname = ucfirst($fname); }
        function getFname(){ return $this->fname; }

        function setLname($lname) { $this->lname = ucfirst($lname); }
        function getLname(){ return $this->lname; }

        function setEmail($email){ $this->email = $email; }
        function getEmail(){ return $this->email; }

        function setPassword($password){ $this->password = $password; }
        function getPassword(){ return $this->password; }
        
        function setImg($img) { $this->img = $img; }
        function getImg() { return $this->img; }

        function setLoginStatus($loginStatus){ $this->loginStatus = $loginStatus; }
        function getLoginStatus(){ return $this->loginStatus; }

        function setLastLogin($lastLogin){ $this->lastLogin = $lastLogin; }
        function getLastLogin(){ return $this->lastLogin; }


        public function __construct() {
            require_once("database.php");
            $db = new DbConnect();
            $this->dbConn = $db->connect();
        }
        public function save() { 
           
            $sql = "INSERT INTO `users` (`fname`, `lname`, `email`, `password` `img` `login_status`, 
            `last_login`) VALUES (null, :name, :email, :password, :img, :loginStatus, :lastLogin)";
            $stmt = $this->dbConn->prepare($sql);
            $stmt->bindParam(":fname", $this->fname);
            $stmt->bindParam(":lname", $this->lname);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":img", $this->img);
            $stmt->bindParam(":loginStatus", $this->loginStatus);
            $stmt->bindParam(":lastLogin", $this->lastLogin);
            try {
                if($stmt->execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $e) {
                echo $e ->getMessage();
            }
        }

    }
    

?>