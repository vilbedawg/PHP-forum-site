<?php

class Login extends Dbh {

 
    protected function getUser($name, $pwd) {
        $stmt = $this->connect()->prepare('SELECT * FROM users WHERE name = ? OR email = ?;');

        if(!$stmt->execute(array($name, $pwd)))  
        {
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }  
        

        if($stmt->rowCount() == 0)
        {
            $stmt = null;
            header("location: login.php?error=usernotfound");
            exit();
        }
        $pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPwd = password_verify($pwd, $pwdHashed[0]["password"]);


        if($checkPwd == false) 
        {
            $stmt = null;
            header("location: login.php?error=wrongpwd&name=$name");
            exit();
        }

        elseif($checkPwd == true) 
        {
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE name = ? OR email = ? AND password = ?;');

            if(!$stmt->execute(array($name, $name, $pwd)))  
            {
                $stmt = null;
                header("location: login.php?error=stmtfailed");
                exit();
            }  

            if($stmt->rowCount() == 0) 
            {
                $stmt = null;
                header("location: login.php?error=usernotfound");
                exit();
            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            session_start();
            $_SESSION["userid"] = $user[0]["user_id"];
            $online = 1;

            $sql = 'UPDATE users SET login_status = :login_status WHERE user_id = :userid;';
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':login_status', $online);
            $stmt->bindParam(':userid', $_SESSION["userid"]);
    
            if(!$stmt->execute())  
            {
                $stmt = null;
                header("location: login.php?error=stmtfailed");
                exit();
            } 

            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE name = ?;');
            $stmt->bindParam('?', $name);
            if(!$stmt->execute(array($name))){
                $stmt = null;
                header("location: login.php?error=stmtfailed");
                exit();
            }
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["name"] = $user[0]["name"];
            $_SESSION["email"] = $user[0]["email"];
            $_SESSION["login"] = $user[0]["login_status"];
            $_SESSION["last_login"] = $user[0]["last_login"];
            $_SESSION["user_token"] = $user[0]["user_token"];
            $stmt = null;
        }

        
    }

}

?>