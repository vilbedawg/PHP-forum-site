<?php

class Signup extends Dbh {

    protected function setUser($name, $email, $pwd) {
        $defaultImg = 'images/profile_images/default.jpg';

        $stmt = $this->connect()->prepare('INSERT INTO users (name, email, password, login_status, last_login, image) 
        VALUES (?, ?, ?, ?, ?, ?);');

        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
        date_default_timezone_set('Europe/Helsinki');

        if(!$stmt->execute(array($name, $email, $hashedPwd, 1, date('Y-m-d h:i:s'), $defaultImg)))  {
            $stmt = null;
            header("location: index.php?error=stmtfailed");
            exit();
        } 
  
        $stmt = $this->connect()->prepare('SELECT * FROM users WHERE name = ?;');
        $stmt->bindParam('?', $name);

        if(!$stmt->execute(array($name))) {
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        //asetetaan session muuttujat
        session_start();
        $_SESSION["userid"] = $user["user_id"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["login"] = $user["login_status"];
        $_SESSION["last_login"] = $user["last_login"];
        $_SESSION["image"] = $user["image"];
        $stmt = null;
    }


    public function checkUser($name) {
        $stmt = $this->connect()->prepare('SELECT name FROM users WHERE name = ?;');

        if(!$stmt->execute(array($name)))  {
            $stmt = null;
            header("location: index.php?error=stmtfailed");
            exit();
        }     

        $resultCheck = 0;
        if($stmt->rowCount() > 0) {
            $resultCheck = false;
        }else {
            $resultCheck = true;
        }
        return $resultCheck;
    }

    public function checkEmail($email) {
        $stmt = $this->connect()->prepare('SELECT email FROM users WHERE email = ?;');

        if(!$stmt->execute(array($email)))  {
            $stmt = null;
            header("location: index.php?error=stmtfailed");
            exit();
        }     

        $resultCheck = 0;
        if($stmt->rowCount() > 0) {
            $resultCheck = false;
        }else {
            $resultCheck = true;
        }
        return $resultCheck;
    }
}

?>