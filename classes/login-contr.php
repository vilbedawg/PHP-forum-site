<?php

    class loginContr extends Login {
        private $name;
        private $pwd;
        private $loginStatus;
        private $lastLogin;
        
       
        public function __construct($name, $pwd, $loginStatus, $lastLogin) {
            $this->name = $name;
            $this->pwd = $pwd;
            $this->loginStatus = $loginStatus;
            $this->lastLogin = $lastLogin;
        }

        public function loginUser() {
            if($this->emptyInput() == false)
            {
                header("location: login.php?error=emptyinput&name=$this->name");
                exit();
            }

            $this->getUser($this->name, $this->pwd, $this->loginStatus, $this->lastLogin);
            
        }
        
        private function emptyInput() {
            $result = 0;
            if(empty($this->name) || empty($this->pwd)) {
                $result = false;
            } else {
                $result = true;
            }
            return $result;
        }
        
    }
?>