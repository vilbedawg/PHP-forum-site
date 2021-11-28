<?php

    class SignupContr extends Signup {
        private $name;
        private $email;
        private $pwd;
        private $pwd2;
        private $loginStatus;
        private $lastLogin;
        
       
        public function __construct($name, $pwd, $pwd2, $email, $loginStatus, $lastLogin) {
            $this->name = $name;
            $this->email = $email;
            $this->pwd = $pwd;
            $this->pwd2 = $pwd2;
            $this->loginStatus = $loginStatus;
            $this->lastLogin = $lastLogin;
        }

        public function signupUser() {
            if($this->emptyInput() == false)
            {
                header("location: index.php?error=emptyinput&name=$this->name&email=$this->email");
                exit();
            }
            if($this->invalidName() == false)
            {
                header("location: index.php?error=invalidName");
                exit();
            }
            if($this->invalidEmail() == false)
            {
                header("location: index.php?error=invalidEmail");
                exit();
            }
            if($this->pwdMatch() == false)
            {
                header("location: index.php?error=pwdmatch");
                exit();
            }
            if($this->pwdLength() == false)
            {
                header("location: index.php?error=pwdlen");
                exit();
            }
            if($this->checkTaken() == false)
            {
                header("location: index.php?error=usernameoremailtaken");
                exit();
            }
            
            $this->setUser($this->name, $this->email, $this->pwd, $this->loginStatus, $this->lastLogin);
            
        }
        
        private function emptyInput() {
            $result = 0;
            if(empty($this->name) || empty($this->email) || empty($this->pwd) || empty($this->pwd2)) {
                $result = false;
            } else {
                $result = true;
            }
            return $result;
        }

        private function invalidName() {
            $result = 0;
            if(!preg_match("/^[a-zA-Z0-9]*$/", $this->name))
            {
                $result = false;
            } else {
                $result = true;
            }
            return $result;
        }

        private function invalidEmail() {
            $result = 0;
            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
            {
                $result = false;
            } else {
                $result = true;
            }
            return $result;
        }

        private function pwdLength() {
            $result = 0;
            if(strlen($this->pwd) > 4 )
            {
                $result = false;
            } else {
                $result = true;
            }
            return $result;
        }
        private function pwdMatch() {
            $result = 0;
            if($this->pwd !== $this->pwd2)
            {
                $result = false;
            } else {
                $result = true;
            }
            return $result;
        }

        private function checkTaken() {
            $result = 0;
            if(!$this->checkUser($this->name, $this->email))
            {
                $result = false;
            } else {
                $result = true;
            }
            return $result;
        }
        
    }
?>