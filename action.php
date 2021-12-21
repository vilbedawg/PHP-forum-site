<?php
session_start();
require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';
$error = '';
$user = new Users();

//Käyttäjän poistaminen
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $db = $user->connect();
    $stmt = $db->prepare('DELETE FROM users WHERE user_id = :id;');
    $stmt->execute(array(':id' => $id));
    exit();
} 


if(isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    $stmt = $user->connect()->prepare('DELETE FROM posts WHERE post_id = :id;');
    $stmt->execute(array(':id' => $id));
    exit();
}




//käyttäjänimen päivitys
if(isset($_POST['name'])) { 
    $checkName = new Signup();
    
    if(!$checkName->checkUser($_POST['name'])) {
        $error = "<div class='error-texti'><p>Käyttäjänimi jo käytössä</p></div>";
    }

    //ainakin yksi non-whitespace kirjain
    else if(!preg_match('/^[-a-zA-Z0-9-()]+(\s+[-a-zA-Z0-9-()]+)*$/', $_POST['name'])) {
        $error = "<div class='error-texti'><p>Väärän muotoinen nimi</p></div>";
    }

    //3-14 merkkiä
    else if(strlen($_POST['name']) <= 2 || (strlen($_POST['name'])) >= 15) {
        $error = "<div class='error-texti'><p>Käyttäjänimen tulee sisältää 3-14 merkkiä</p></div>";
    }

    if($error == ""){
        //jos error = false
        $stmt =  $user->connect()->prepare("UPDATE users SET name = :name WHERE user_id = :user_id");
            $stmt->bindParam(':name', $_POST['name']);
            $stmt->bindParam(':user_id', $_POST['id'], PDO::PARAM_INT);
            if(!$stmt->execute())  {
                $stmt = null;
                $error = "<div class='error-texti'><p>STMT FAILED</p></div>";
                exit();
            } 
        $error = "<div class='success-texti'><p>Tallennettu</p></div>";
        echo $error;

    } else{
        //Jos error == true
        echo $error;
    }
    exit();  
}



if(isset($_POST['email'])){
    $email = $_POST['email'];
    $user = new Signup();
    if(!$user->checkEmail($email)) {
        $error = "<div class='error-texti'><p>Sähköposti käytössä</p></div>";
    }

    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "<div class='error-texti'><p>Väärän muotoinen sähköposti</p></div>";
    }

    if($error == "") {
        $stmt =  $user->connect()->prepare("UPDATE users SET email = :email WHERE user_id = :user_id");
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->bindParam(':user_id', $_POST['id'], PDO::PARAM_INT);
            if(!$stmt->execute())  {
                $stmt = null;
                $error = "<div class='error-texti'><p>STMT FAILED</p></div>";
                exit();
            }
        $error = "<div class='success-texti'><p>Tallennettu</p></div>";
        echo $error;
    } else {
        //Jos error == true
        echo $error;
    }
    exit();
}


//profiilikuvan lataaminen
if(is_array($_FILES)){
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
