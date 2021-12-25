<?php

class PostedContent extends Dbh
{
    public function GetPostByCurrentRoomID($roomNum){
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

    
    public function GetAllPostsByID($user){
        $user = str_split($user, 100);
        $stmt = $this->connect()->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY date ASC;");
        if(!$stmt->execute($user)) {
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $allPostsOldest = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $allPostsOldest;
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


    public function getAllPostsByCategory($category){
        $category = str_split($category, 100);
        $stmt = $this->connect()->prepare("SELECT * FROM posts WHERE category = ? ORDER BY date DESC;");
        if(!$stmt->execute($category)) {
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