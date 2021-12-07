<?php
class post extends Dbh
{
    protected function PostToDB($subject, $content) {
        $stmt =  $this->connect()->prepare('INSERT INTO posts (email, user_id, date, title, content)
        VALUES (?, ?, ?, ?, ?);');

        
        if(!$stmt->execute(array($_SESSION['email'], $_SESSION['userid'], date('Y-m-d H:i:s'), $subject, $content )))  {
            $stmt = null;
            header("location: index.php?error=stmtfailed");
            exit();
        }
    } 
}
    

?>