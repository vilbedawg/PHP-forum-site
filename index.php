<?php
include_once "header.php";


if(isset($_POST['submit'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $pwd = $_POST["password"];
    $pwd2 = $_POST["password2"];
    $loginStatus = "";
    $lastLogin = "";

    include "classes/database.php";
    include "classes/signup-classes.php";
    include "classes/signup-contr.php";
    $signup = new SignupContr($name, $pwd, $pwd2, $email, $loginStatus, $lastLogin);

    $signup->signupUser();
    header("location: index.php?error=none");
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
                            echo "<p>Täytä kaikki kohdat</p>";
                        }
                        else if($signupCheck  == "invalidName") {
                            echo "<p>Väärä muotoinen nimi</p>";
                        }
                        else if ($signupCheck == "invalidEmail"){
                            echo "<p>Väärä muotoinen sähköposti</p>";
                        }
                        else if ($signupCheck == "pwdmatch"){
                            echo "<p>Salasana ei täsmää</p>";
                        }
                        else if ($signupCheck == "pwdlen"){
                            echo "<p>Salasana vähintään 4 merkkiä</p>";
                        }
                        else if ($signupCheck == "usernameoremailtaken"){
                            echo "<p>Käyttäjänimi tai sähköposti käytössä</p>";
                        }
                        
                    }
               
                ?>
                </div>
                <div class="field input">
                    <label>Nimi</label>
                    <?php
                     if(isset($_GET['name'])) {
                         $formName = $_GET['name'];
                    
                        echo '<input type="text" name="name" id="name" placeholder="Etunimi" value="'.$formName.'">';
                    } else {
                        echo '<input type="text" name="name" id="name" placeholder="Etunimi">';
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
            <div class="link">Rekisteröitynyt jo?<a href="#"> Kirjaudu</a></div>
        </section>
    </div>

    <script src="js\pass-show-hide.js"></script>
    <script src="js\signupForm.js"></script>
    </body>
    </html>