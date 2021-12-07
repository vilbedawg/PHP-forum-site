<?php

class PostedContent extends Dbh
{
    private $post_id;
    private $email;
    private $user_id;
    private $date;
    private $title;
    private $content;

    
    public function getAllPostsByDate(){
        $stmt = $this->connect()->prepare('SELECT * FROM posts ORDER BY date desc');
        if(!$stmt->execute()){
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $allPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $allPosts;
    }
    
}

?>