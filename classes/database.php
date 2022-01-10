<?php

class Dbh {
    
   
    public function connect() {
        try {
            $username = "root";
            $password = "";
             //tarkista, että osoite on oikein
            $dbh = new PDO('mysql:host=localhost;dbname=e2000693_Harkka', $username, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbh;
        } catch(PDOException $e) {
            echo "Tietokannan yhdistämisessä virhe :(" . $e->getMessage();
            die();
        }
    }
}


?>
