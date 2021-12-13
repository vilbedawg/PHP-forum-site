<?php

class PostedContent extends Dbh
{
    public function getAllPostsByRoomID($roomNum){
        $roomarray = str_split($roomNum, 100);
        $stmt = $this->connect()->prepare("SELECT * FROM posts WHERE post_id = ? ORDER BY date ASC;");
        if(!$stmt->execute($roomarray)){
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $allPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $allPosts;
    }


    public function getAllPostsByOldest(){
        $stmt = $this->connect()->prepare("SELECT * FROM posts ORDER BY date ASC;");
        if(!$stmt->execute()) {
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $allPostsOldest = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $allPostsOldest;
    }

    public function getAllPostsByNewest(){
        $stmt = $this->connect()->prepare("SELECT * FROM posts ORDER BY date DESC;");
        if(!$stmt->execute()) {
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $allPostsNewest = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $allPostsNewest;
    }

    public function getAllComments($roomNum){
        $roomNum = str_split($roomNum, 100);
        $stmt = $this->connect()->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY date ASC;");
        if(!$stmt->execute($roomNum)){
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $allComments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $allComments;
    }

}



?>