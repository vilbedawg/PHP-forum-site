<?php

class Login extends Dbh {

 
    protected function getUser($name, $pwd) {
        $stmt = $this->connect()->prepare('SELECT * FROM users WHERE name = :name;');
        $stmt->bindParam(':name', $name);
        if(!$stmt->execute())  
        {
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }  
        
        if($stmt->rowCount() < 1)
        {
            $stmt = null;
            header("location: login.php?error=usernotfound");
            exit();
        }

        //salasanan tarkistus
        $pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPwd = password_verify($pwd, $pwdHashed[0]["password"]);


        if($checkPwd == false) 
        {
            $stmt = null;
            header("location: login.php?error=wrongpwd&name=$name");
            exit();
        }


        else if($checkPwd == true) 
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

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

           
            session_start();
            $_SESSION["userid"] = $user["user_id"];
            $banned = 3;
            $online = 1;

            if($user['login_status'] == $banned) {
                $stmt = null;
                header("location: login.php?error=banned");
                exit();
            }

            

            //päivitetään login status
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
            if(!$stmt->execute(array($name))){
                $stmt = null;
                header("location: login.php?error=stmtfailed");
                exit();
            }
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION["name"] = $user["name"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["login"] = $user["login_status"];
            $_SESSION["last_login"] = $user["last_login"];
            $_SESSION["image"] = $user["image"];
            $stmt = null;
        }

        
    }

}

?>