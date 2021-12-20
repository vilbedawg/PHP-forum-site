<?php

    class SignupContr extends Signup {
        private $name;
        private $email;
        private $pwd;
        private $pwd2;
        
       
        public function __construct($name, $pwd, $pwd2, $email) {
            $this->name = $name;
            $this->email = $email;
            $this->pwd = $pwd;
            $this->pwd2 = $pwd2;
        }

        public function signupUser() {
            if($this->emptyInput() == false)
            {
                header("location: index.php?error=emptyinput&name=$this->name&email=$this->email");
                exit();
            }
            if($this->invalidName() == false)
            {
                header("location: index.php?error=invalidName&name=$this->name&email=$this->email");
                exit();
            }
            if($this->invalidEmail() == false)
            {
                header("location: index.php?error=invalidEmail&name=$this->name&email=$this->email");
                exit();
            }
            if($this->pwdMatch() == false)
            {
                header("location: index.php?error=pwdmatch&name=$this->name&email=$this->email");
                exit();
            }
            if($this->pwdLength() == false)
            {
                header("location: index.php?error=pwdlen&name=$this->name&email=$this->email");
                exit();
            }
            if($this->checkNameTaken() == false)
            {
                header("location: index.php?error=usernameTaken&name=$this->name&email=$this->email");
                exit();
            }

            if($this->checkEmailTaken() == false)
            {
                header("location: index.php?error=emailTaken&name=$this->name&email=$this->email");
                exit();
            }

            $this->setUser($this->name, $this->email, $this->pwd); 
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
            if(!preg_match('/(?!^$)([^\s]){5,}$/', $this->name))
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
            if(strlen($this->pwd) < 4 )
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

        private function checkNameTaken() {
            $result = 0;
            if(!$this->checkUser($this->name))
            {
                $result = false;
            } else {
                $result = true;
            }
            return $result;
        }

        private function checkEmailTaken() {
            $result = 0;
            if(!$this->checkEmail($this->email))
            {
                $result = false;
            } else {
                $result = true;
            }
            return $result;
        }
        
    }
?>