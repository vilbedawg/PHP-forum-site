<?php
include_once "header.php";


if(isset($_POST['submit'])) {
    $name = $_POST["name"];
    $pwd = $_POST["password"]; 

    include "classes/database.php";
    include "classes/login-classes.php";
    include "classes/login-contr.php";
    $login = new loginContr($name, $pwd, $loginStatus, $lastLogin);

    
    $login->loginUser();
    header("location: users.php");
  
}



?>

<body>
    <div class="hero">
    <div class="wrapper-login">
        <section class="form signup">
            <header>Kirjaudu</header>
            <form action="" method="post">
                <div class="error-txt">
                <?php
                    if(!isset($_GET['error'])) {
                        echo "";
                    }
                    else{
                        $signupCheck = $_GET['error'];

                        if ($signupCheck == "emptyinput") {
                            echo "<div class='error-texti'><p>Täytä kaikki kohdat</p></div>";
                        } 
                        
                        elseif ($signupCheck == "wrongpwd") {
                            echo "<div class='error-texti'><p>Väärä salasana</p></div>";
                        }
                        elseif ($signupCheck == "usernotfound") {
                            echo "<div class='error-texti'><p>Käyttäjää ei löydy</p></div>";
                        }   
                    }
               
                ?>
                </div>
                <div class="field input">
                    <label>Käyttäjänimi</label>
                    <?php
                     if(isset($_GET['name'])) {
                         $formName = $_GET['name'];
                    
                        echo '<input type="text" name="name" id="name" placeholder="Käyttäjänimi" value="'.$formName.'">';
                    } else {
                        echo '<input type="text" name="name" id="name" placeholder="Käyttäjänimi">';
                    }
                    ?>
                </div>
                <div class="field input">
                    <label>Salasana</label>
                    <input type="password" name="password" id="Password" placeholder="Salasana" >
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Kirjaudu" id="submit">
                </div>
            </form>
            <div class="link">Rekisteröitynyt?<a href="index.php"> Rekisteröidy</a></div>
        </section>
    </div>
    </div>
    <script src="js\pass-show-hide.js"></script>
    </body>
    </html>