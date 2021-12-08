<?php
class post extends Dbh
{
    protected function PostToDB($content, $category) { 
        $stmt =  $this->connect()->prepare('INSERT INTO posts (name, email, user_id, date, category, content)
        VALUES (?, ?, ?, ?, ?, ?);');

        
        if(!$stmt->execute(array($_SESSION['name'], $_SESSION['email'], $_SESSION['userid'], date('Y-m-d H:i:s'), $category, $content )))  {
            $stmt = null;
            header("location: index.php?error=stmtfailed");
            exit();
        }
    } 
}
    

?>