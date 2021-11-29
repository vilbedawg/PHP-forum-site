<?php
session_start();
include_once "header.php";


if(isset($_POST['submit'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $pwd = $_POST["password"];
    $pwd2 = $_POST["password2"];


    include "classes/database.php";
    include "classes/signup-classes.php";
    include "classes/signup-contr.php";
    $signup = new SignupContr($name, $pwd, $pwd2, $email, $loginStatus, $lastLogin);

    $signup->signupUser();
    header("location: users.php");
}

?>
<body>
    <div class="wrapper">
        <section class="form signup">
            <header>Chat App</header>
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
                        else if($signupCheck  == "invalidName") {
                            echo "<div class='error-texti'><p>Väärä muotoinen nimi</p></div>";
                        }
                        else if ($signupCheck == "invalidEmail"){
                            echo "<div class='error-texti'><p>Väärä muotoinen sähköposti</p></div>";
                        }
                        else if ($signupCheck == "pwdmatch"){
                            echo "<div class='error-texti'><p>Salasana ei täsmää</p></div>";
                        }
                        else if ($signupCheck == "pwdlen"){
                            echo "<div class='error-texti'><p>Salasana vähintään 4 merkkiä</p></div>";
                        }
                        else if ($signupCheck == "usernameTaken"){
                            echo "<div class='error-texti'><p>Käyttäjänimi käytössä</p></div>";
                        }
                        else if ($signupCheck == "emailTaken"){
                            echo "<div class='error-texti'><p>Sähköposti käytössä</p></div>";
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
                    <label>Sähköposti</label>
                    <?php
                    if(isset($_GET['email'])) {
                        $formEmail= $_GET['email'];
                   
                       echo '<input type="text" name="email" id="email" placeholder="Sähköposti" value="'.$formEmail.'">';
                   } else {
                       echo '<input type="text" name="email" id="email" placeholder="Sähköposti">';
                   }
                   ?>
                    
                </div>
                <div class="field input">
                    <label>Salasana</label>
                    <input type="password" name="password" id="Password" placeholder="Salasana" >
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field input">
                    <label>Salasana uudelleen</label>
                    <input type="password"  name="password2" id="PasswordVerify" placeholder="Salasana" >
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Jatka" id="submit">
                </div>
            </form>
            <div class="link">Rekisteröitynyt jo?<a href="login.php"> Kirjaudu</a></div>
        </section>
    </div>

    <script src="js\pass-show-hide.js"></script>
    </body>
    </html>