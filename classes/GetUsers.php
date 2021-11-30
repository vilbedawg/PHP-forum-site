<?php
    class Users extends Dbh 
    {
      

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