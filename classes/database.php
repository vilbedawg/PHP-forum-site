<?php

class Dbh {
    
   
    public function connect() {
        try {         
            $dbh = new PDO("mysql:host=mysql.cc.puv.fi;dbname=e2000693_harkka",
                    "e2000693", "h44awtyd3Fvx");
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbh;
        } catch(PDOException $e) {
            echo "Tietokannan yhdistämisessä virhe :(" . $e->getMessage();
            die();
        }
    }
}


?>
