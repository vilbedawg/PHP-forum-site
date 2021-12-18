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

    protected function updateTopicToDB($category, $subject, $topic, $roomNum) { 
        $time = date('Y-m-d H:i:s');
        $stmt =  $this->connect()->prepare("UPDATE posts 
            SET 
                date = :date,
                category = :category,
                title = :title,
                topic = :topic
                WHERE post_id = :post_id");
            $stmt->bindParam(':date', $time);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':title', $subject);
            $stmt->bindParam(':topic', $topic);
            $stmt->bindParam(':post_id', $roomNum);
            if(!$stmt->execute())  {
                $stmt = null;
                header("location: index.php?error=stmtfailed");
                exit();
            }
    }

    public function DeletePost() {
        $stmt = $this->connect()->prepare('DELETE FROM posts WHERE user_id = :user_id;');
        $stmt->bindParam(':user_id', $this->userid, PDO::PARAM_INT);
        if(!$stmt->execute()){
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        
    }

    
}
    

?>