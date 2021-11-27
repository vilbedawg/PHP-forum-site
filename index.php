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
    echo"success";
}

?>
<body>
    <div class="wrapper">
        <section class="form signup">
            <header>Chat App</header>
            <form action="" method="post">
                <div class="error-txt">
                    <?php
                    echo "$result";
                    ?>
                </div>
                <div class="field input">
                    <label>Nimi</label>
                    <input type="text" name="name" id="name" placeholder="Etunimi" >
                </div>
                <div class="field input">
                    <label>Sähköposti</label>
                    <input type="text" name="email" id="email" placeholder="Sähköposti" >
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

    <script src="./src/js/pass-show-hide.js"></script>
    <script src="./src/js/signup.js"></script>
    </body>
    </html>