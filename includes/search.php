<?php
    include_once "config.php";
    $output = "";

    $searchTerm = 
    $stmt = $this->connect()->prepare("SELECT * FROM users WHERE name LIKE ?");
    $stmt->bindParam('?', $searchTerm);
    if(!$stmt->execute()){
        $stmt = null;
        header("location: login.php?error=stmtfailed");
        exit();
    }
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $users;
    

    if(mysqli_num_rows($sql) > 0){
        include "data.php";
    }else {
        $output .= " Käyttäjää ei löydy.";
    }
    echo $output;

?>