<?php
class Logout extends Dbh 
{
    public function updateLogoutStatus() {
        date_default_timezone_set('Europe/Helsinki');
        $offline = 0;
        $lastLogin = date('Y-m-d h:i:s');
        $sql = 'UPDATE users SET login_status = :login_status, last_login = :last_login WHERE user_id = :userid;';
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':login_status', $offline);
        $stmt->bindParam(':last_login', $lastLogin);
        $stmt->bindParam(':userid', $_SESSION["userid"]);

        if(!$stmt->execute())  
        {
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        } 
    }
}


?>
