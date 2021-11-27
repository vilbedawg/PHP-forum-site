<?php


if (isset($_FILES['image'])) { //jos tiedosto on ladattu
    $img_name = $_FILES['image']['name'];
    $img_type = $_FILES['image']['type'];
    $tmp_name = $_FILES['image']['tmp_name']; //Väliaikainen nimi jonka avulla voidaan siirtää tiedosto kansiossa
    $img_explode = explode('.', $img_name);
    $img_ext = end($img_explode); 

    $extensions = ['png', 'jpeg', 'jpg'];
    if (in_array($img_ext, $extensions) === true) { // onko käyttäjän lataama tiedostotyyppi jokin $extensions tyypeistä
        $types = ["image/jpeg", "image/jpg", "image/png"];
        if (in_array($img_type, $types) === true) {
            $time = time();
            $new_img_name = $time . $img_name;
            if (move_uploaded_file($tmp_name, "images/" . $new_img_name)) {
                echo "Onnistui";
                if(isset($_POST["submit"])) {
                    $name = $_POST["name"];
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    $password2 = $_POST["password2"];
                }
            }
        }
    }
}


?>