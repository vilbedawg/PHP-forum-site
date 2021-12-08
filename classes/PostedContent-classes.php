<?php

class PostedContent extends Dbh
{
    
    public function getAllPythonPostsByDate(){
        $category = ["Python"];
        $stmt = $this->connect()->prepare("SELECT * FROM posts WHERE category = ? ORDER BY date ASC;");
        if(!$stmt->execute($category)){
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $allPythonPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $allPythonPosts;
    }

    public function getAllPHPPostsByDate(){
        $category = ["PHP"];
        $stmt = $this->connect()->prepare("SELECT * FROM posts WHERE category = ? ORDER BY date ASC;");
        if(!$stmt->execute($category)){
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $allPythonPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $allPythonPosts;
    }

    public function getAllCsharpPostsByDate(){
        $category = ["c#"];
        $stmt = $this->connect()->prepare("SELECT * FROM posts WHERE category = ? ORDER BY date ASC;");
        if(!$stmt->execute($category)){
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        $allPythonPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $allPythonPosts;
    }

}

?>