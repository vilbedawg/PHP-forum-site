<?php

class PostedContent extends Dbh
{
    public function GetPostByCurrentRoomID($roomNum){
        $stmt = $this->connect()->prepare("SELECT * FROM posts WHERE post_id = ? ORDER BY date DESC;");
        if(!$stmt->execute(array($roomNum))){
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $allPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $allPosts;
    }

    
    public function GetAllPostsByID($user){
        $stmt = $this->connect()->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY date DESC;");
        if(!$stmt->execute(array($user))) {
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

    public function getMostLikedPosts(){
        $stmt = $this->connect()->prepare("SELECT posts.*, COUNT(rating_info.post_id) AS like_count
                                            FROM posts LEFT JOIN rating_info
                                            ON posts.post_id = rating_info.post_id AND rating_action IN ('like')
                                            GROUP BY posts.post_id
                                            ORDER BY like_count DESC;");
        if(!$stmt->execute()) {
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $allPostsNewest = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $allPostsNewest;
    }


    public function getAllPostsByCategory($category){
        $stmt = $this->connect()->prepare("SELECT * FROM posts WHERE category = ? ORDER BY date DESC;");
        if(!$stmt->execute(array($category))) {
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $allPostsNewest = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $allPostsNewest;
    }

    public function getCategoryPostsOldest($category){
        $stmt = $this->connect()->prepare("SELECT * FROM posts WHERE category = ? ORDER BY date ASC;");
        if(!$stmt->execute(array($category))) {
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $allPostsNewest = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $allPostsNewest;
    }

    public function getMostLikedPostByCategory($category){
        $stmt = $this->connect()->prepare("SELECT posts.*, COUNT(rating_info.post_id) AS like_count
                                            FROM posts LEFT JOIN rating_info
                                            ON posts.post_id = rating_info.post_id AND rating_action IN ('like')
                                            WHERE category = ?
                                            GROUP BY posts.post_id
                                            ORDER BY like_count DESC;");
                                            
        if(!$stmt->execute(array($category))) {
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

    public function getLikesPost($id){
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

    public function userLikedPost($userid, $postid){
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

    public function getLikesComment($id){
        $stmt = $this->connect()->prepare("SELECT (SELECT COUNT(*) FROM rating_info WHERE comment_id = ? AND rating_action = 'like') -
                                            (SELECT COUNT(*) FROM rating_info WHERE comment_id = ? AND rating_action = 'dislike') AS amount");
        if(!$stmt->execute(array($id, $id))) {
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $likeCount = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $likeCount;
    }

    public function userLikedComment($userid, $commentid){
        $stmt = $this->connect()->prepare("SELECT rating_action FROM rating_info WHERE user_id = :user_id AND comment_id = :comment_id");
        $stmt->bindParam(':user_id', $userid);
        $stmt->bindParam(':comment_id', $commentid);
        if(!$stmt->execute()) {
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $likeCount = $stmt->fetch(PDO::FETCH_ASSOC);

        return $likeCount['rating_action'] ?? null;
    }
    
    public function getLikesReply($id){
        $stmt = $this->connect()->prepare("SELECT (SELECT COUNT(*) FROM rating_info WHERE reply_id = ? AND rating_action = 'like') -
                                            (SELECT COUNT(*) FROM rating_info WHERE reply_id = ? AND rating_action = 'dislike') AS amount");
        if(!$stmt->execute(array($id, $id))) {
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $likeCount = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $likeCount;
    }

    public function userLikedReply($userid, $replyid){
        $stmt = $this->connect()->prepare("SELECT rating_action FROM rating_info WHERE user_id = :user_id AND reply_id = :reply_id");
        $stmt->bindParam(':user_id', $userid);
        $stmt->bindParam(':reply_id', $replyid);
        if(!$stmt->execute()) {
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $likeCount = $stmt->fetch(PDO::FETCH_ASSOC);

        return $likeCount['rating_action'] ?? null;
    }


    public function likeStatusPost($likeStatus, $likes) {
        if($likeStatus == 'like') {
            $result = "<i class='fas fa-long-arrow-alt-up' id='liked' onclick='isComment = false; isReplyID = false;' style='color: #ee6c4d;'></i>
            <p style='font-size: 18px; text-align: center;' class='like-amount'>". $likes[0]['amount']  ."</p>
            <i class='fas fa-long-arrow-alt-down' id='dislike' onclick='isComment = false; isReplyID = false;'></i>";

        } else if($likeStatus == 'dislike') {
            $result = "<i class='fas fa-long-arrow-alt-up' id='like' onclick='isComment = false; isReplyID = false;'></i>
            <p style='font-size: 18px; text-align: center;' class='like-amount'>". $likes[0]['amount']  ."</p>
            <i class='fas fa-long-arrow-alt-down' id='disliked' onclick='isComment = false; isReplyID = false;' style='color: #ee6c4d;'></i>";

        } else {
            $result = "<i class='fas fa-long-arrow-alt-up' id='like' onclick='isComment = false; isReplyID = false;'></i>
            <p style='font-size: 18px; text-align: center;' class='like-amount'>". $likes[0]['amount']  ."</p>
            <i class='fas fa-long-arrow-alt-down' id='dislike' onclick='isComment = false; isReplyID = false;'></i>";
        }

        return $result;
    }
    
    public function likeStatusComment($likeStatus, $likes) {
        if($likeStatus == 'like') {
           $result = "<button class='like' id='liked' onclick='isComment = true; isReplyID = false;' style='width: auto; color: #ee6c4d;'><i class='fa fa-thumbs-up' aria-hidden='true'></i></button>
            <p style='font-size: 14px; text-align: center;' class='like-amount'>". $likes[0]['amount']  ."</p>
            <button class='like' id='dislike' onclick='isComment = true; isReplyID = false;' 
            style='width: auto; transform: rotate(180deg);'><i class='fa fa-thumbs-up' aria-hidden='true'></i></button>";

        } else if($likeStatus == 'dislike') {
            $result = "<button class='like' id='like' onclick='isComment = true; isReplyID = false;' style='width: auto;'><i class='fa fa-thumbs-up' aria-hidden='true'></i></button>
            <p style='font-size: 14px; text-align: center;' class='like-amount'>". $likes[0]['amount']  ."</p>
            <button class='like' id='disliked' onclick='isComment = true; isReplyID = false;' 
            style='width: auto; transform: rotate(180deg); color: #ee6c4d;'><i class='fa fa-thumbs-up' aria-hidden='true'></i></button>";

        } else {
            $result = "<button class='like' id='like' onclick='isComment = true; isReplyID = false;' style='width: auto;'><i class='fa fa-thumbs-up' aria-hidden='true'></i></button>
            <p style='font-size: 14px; text-align: center;' class='like-amount'>". $likes[0]['amount']  ."</p>
            <button class='like' id='dislike' onclick='isComment = true; isReplyID = false;' 
            style='width: auto; transform: rotate(180deg);'><i class='fa fa-thumbs-up' aria-hidden='true'></i></button>";
        }
        return $result;
    }
    
    public function likeStatusReply($likeStatus, $likes) {
        if($likeStatus == 'like') {
            $result = "<button class='like' id='liked' onclick='isComment = true; isReplyID = true;' style='width: auto; color: #ee6c4d;'><i class='fa fa-thumbs-up' aria-hidden='true'></i></button>
                        <p style='font-size: 14px; text-align: center;' class='like-amount'>". $likes[0]['amount']  ."</p>
                        <button class='like' id='dislike' onclick='isComment = true; isReplyID = true;'  
                        style='width: auto; transform: rotate(180deg);'><i class='fa fa-thumbs-up' aria-hidden='true'></i></button>";
 
         } else if($likeStatus == 'dislike') {
             $result = "<button class='like' id='like' onclick='isComment = true; isReplyID = true;' style='width: auto;'><i class='fa fa-thumbs-up' aria-hidden='true'></i></button>
                        <p style='font-size: 14px; text-align: center;' class='like-amount'>". $likes[0]['amount']  ."</p>
                        <button class='like' id='disliked' onclick='isComment = true; isReplyID = true;'  
                        style='width: auto; transform: rotate(180deg); color: #ee6c4d;'><i class='fa fa-thumbs-up' aria-hidden='true'></i></button>";
 
         } else {
             $result = "<button class='like' id='like' onclick='isComment = true; isReplyID = true;' style='width: auto;'><i class='fa fa-thumbs-up' aria-hidden='true'></i></button>
                        <p style='font-size: 14px; text-align: center;' class='like-amount'>". $likes[0]['amount']  ."</p>
                        <button class='like' id='dislike' onclick='isComment = true; isReplyID = true;'  
                        style='width: auto; transform: rotate(180deg);'><i class='fa fa-thumbs-up' aria-hidden='true'></i></button>";
         }
         return $result;
    }
}



?>