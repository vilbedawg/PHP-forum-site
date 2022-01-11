<?php
// editoriin syötettävä kuva ja sen lataus kansioon

// hyväksytyt osoitteet
$accepted_origins = array("http://localhost:8080", "http://107.161.82.130", "http://localhost", "https://www.cc.puv.fi");

// kuvan latauskansio
$imageFolder = "images/";

reset($_FILES);
$temp = current($_FILES);
if(is_uploaded_file($temp['tmp_name'])){
    if(isset($_SERVER['HTTP_ORIGIN'])){
        // Samannimiset origin-pyynnöt eivät aseta originia, vaan sen täytyy olla kelvollinen
        if(in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)){
            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        }else{
            header("HTTP/1.1 403 Origin Denied");
            return;
        }
    }
  
    // filtteröidään syöte
    if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])){
        header("HTTP/1.1 400 Invalid file name.");
        return;
    }
  
    // verifoidaan tiedostopääte
    $extensions = array("gif", "jpg", "png", "jpeg");
    if(!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), $extensions)){
        header("HTTP/1.1 400 Invalid extension.");
        return;
    }

    //luodaan uusi nimi tiedostolle
    $fileExt = pathinfo($temp['name'], PATHINFO_EXTENSION);
    $withoutExt = md5(time().$temp['name']);
    $newFile = $withoutExt . ".".$fileExt;


    // siirretään tiedosto
    $filetowrite = $imageFolder . $newFile;
    move_uploaded_file($temp['tmp_name'], $filetowrite);
  
    // vastataan onnistuneeseen lataukseen JSON:illa
    echo json_encode(array('location' => $filetowrite));
} else {
    // kerrotaan editorille, että lataus epäonnistui
    header("HTTP/1.1 500 Server Error");
}

?>
