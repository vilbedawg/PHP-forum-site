<?php
session_start();
require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';
$error = '';
$user = new Users();


//profiilikuvan lataaminen
if(isset($_FILES)){
    $imageFolder = "images/profile_images/";
  
    $user->setUserID($_POST['id']);
    $i = $user->GetViewedUser();
    $oldImage = $i[0]['image'];

    //Verify extension
    $extensions = array("gif", "jpg", "png", "jpeg");
    reset($_FILES);
    $temp = current($_FILES);


    if(!is_uploaded_file($temp['tmp_name'])) {
        $error = "<div class='error-texti'><p>Valitse kuva</p></div>";
    }

    else if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])){
        $error = "<div class='error-texti'><p>Kuvan nimi sisältää ei-sallittuja kirjaimia</p></div>";
    }
  
    else if(!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), $extensions)){
        $error = "<div class='error-texti'><p>Väärä kuvan tiedostomuoto, vain jpg, jpeg, png</p></div>";
    }


    else if($temp['size'] > 1000000) {
        $error = "<div class='error-texti'><p>Kuva liian iso, max 1000mb</p></div>";
    }

    if ($error == "") {
        //nimetään tiedosto uniikilla nimellä
        $fileExt = pathinfo($temp['name'], PATHINFO_EXTENSION);
        $withoutExt = md5(time().$temp['name']);
        $newFile = $withoutExt . ".".$fileExt;

        

        $filetowrite = $imageFolder . $newFile;
        if(move_uploaded_file($temp['tmp_name'], $filetowrite)) {
            if(file_exists($oldImage)){
                if($oldImage !== "images/profile_images/default.jpg"){
                   unlink($oldImage);
                } else {
                    $error = "";
                }
            } else {
                $error = "";
            }
        }
        
    
            $stmt =  $user->connect()->prepare("UPDATE users SET image = :image WHERE user_id = :user_id");
            $stmt->bindParam(':image', $filetowrite);
            $stmt->bindParam(':user_id', $_POST['id'], PDO::PARAM_INT);
            if(!$stmt->execute())  {
                $stmt = null;
                $error = "<div class='error-texti'><p>STMT FAILED</p></div>";
                exit();
            }
        $image = '<img class="image-preview" src="'. $filetowrite .'">';
        $error = "<div class='success-texti'><p>Tallennettu</p></div>";
        $arr = array('error' => $error, 'img' => $image);
        echo json_encode($arr);
        exit();
    } else {
        $currentImg = '<img class="image-preview" src="'. $oldImage .'">';
        $arr = array('error' => $error, 'img' => $currentImg);
        echo json_encode($arr);
    }  
} 
?>
