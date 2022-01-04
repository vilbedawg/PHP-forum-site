<?php

    // login olio
    class loginContr extends Login {
        private $name;
        private $pwd;
        
       
        public function __construct($name, $pwd) {
            $this->name = $name;
            $this->pwd = $pwd;
        }

        public function loginUser() {
            if($this->emptyInput() == false)
            {
                header("location: login.php?error=emptyinput&name=$this->name");
                exit();
            }
            $this->getUser($this->name, $this->pwd);
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