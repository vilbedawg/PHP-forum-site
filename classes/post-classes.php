<?php
class post extends Dbh
{
    protected function PostTopicToDB($category, $subject, $topic) { 
        $stmt =  $this->connect()->prepare("INSERT INTO posts (name, email, user_id, date, category, title, topic)
        VALUES (?, ?, ?, ?, ?, ?, ?);");

        if(!$stmt->execute(array($_SESSION['name'], $_SESSION['email'], $_SESSION['userid'], date('Y-m-d H:i:s'), $category, $subject, $topic )))  {
            $stmt = null;
            header("location: index.php?error=stmtfailed");
            exit();
        }

        
    }
    

    
    protected function PostCommentToDB($content, $roomNum) { 
        $stmt =  $this->connect()->prepare('INSERT INTO comments (post_id, user_id, name, date, content)
        VALUES (?, ?, ?, ?, ?);');
        
        if(!$stmt->execute(array($roomNum, $_SESSION['userid'], $_SESSION['name'], date('Y-m-d H:i:s'), $content)))  {
            $stmt = null;
            header("location: index.php?error=stmtfailed");
            exit();
        }
    } 
}
    

?>