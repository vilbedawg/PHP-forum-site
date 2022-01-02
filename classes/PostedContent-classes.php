<?php

class PostedContent extends Dbh
{
    public function GetPostByCurrentRoomID($roomNum){
        $roomarray = str_split($roomNum, 100);
        $stmt = $this->connect()->prepare("SELECT * FROM posts WHERE post_id = ? ORDER BY date DESC;");
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
        $stmt = $this->connect()->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY date DESC;");
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

    public function getCategoryPostsOldest($category){
        $category = str_split($category, 100);
        $stmt = $this->connect()->prepare("SELECT * FROM posts WHERE category = ? ORDER BY date ASC;");
        if(!$stmt->execute($category)) {
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $allPostsNewest = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $allPostsNewest;
    }


    public function getAllComments($roomNum){
        $stmt = $this->connect()->prepare("SELECT 
                                            (SELECT COUNT(*) FROM comments WHERE post_id = ?) 
                                            + 
                                            (SELECT COUNT(*) FROM replies WHERE post_id = ?)
                                            as comment_amount
                                            ");
        if(!$stmt->execute(array($roomNum, $roomNum))){
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $allComments = $stmt->fetch(PDO::FETCH_ASSOC);
        return $allComments;
    }

    public function getLikes($id){
        $stmt = $this->connect()->prepare("SELECT (SELECT COUNT(*) FROM rating_info WHERE post_id = ? AND rating_action = 'like') -
                                            (SELECT COUNT(*) FROM rating_info WHERE post_id = ? AND rating_action = 'dislike') AS amount");
        if(!$stmt->execute(array($id, $id))) {
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $likeCount = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $likeCount;
    }

    public function userLiked($userid, $postid){
        $stmt = $this->connect()->prepare("SELECT rating_action FROM rating_info WHERE user_id = :user_id AND post_id = :post_id");
        $stmt->bindParam(':user_id', $userid);
        $stmt->bindParam(':post_id', $postid);
        if(!$stmt->execute()) {
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $likeCount = $stmt->fetch(PDO::FETCH_ASSOC);

        return $likeCount['rating_action'] ?? null;
    }
}



?>