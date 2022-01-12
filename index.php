<?php
//Rekisteröintisivu
require_once "./includes/header.php";

if (isset($_POST['submit'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $pwd = $_POST["password"];
    $pwd2 = $_POST["password2"];

    require_once "./classes/database.php";
    require_once './includes/autoload-classes.php';
    require_once "./controllers/signup-contr.php";
    $signup = new SignupContr($name, $pwd, $pwd2, $email);

    $signup->signupUser();
    header("location: home.php?show=Etusivu");
}

?>

<body>
    <div class="hero">
        <div class="wrapper-login">
            <section class="form signup">
                <header>Rekisteröidy</header>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="error-txt">
                        <!-- Haetaan GET parametri ja näytetään error viesti sen perusteella -->
                        <?php
                        if (!isset($_GET['error'])) {
                            echo "";
                        } else {
                            $signupCheck = $_GET['error'];

                            if ($signupCheck == "emptyinput") {
                                echo "<div class='error-texti'><p>Täytä kaikki kohdat</p></div>";
                            } else if ($signupCheck  == "invalidName") {
                                echo "<div class='error-texti'><p>Väärä muotoinen nimi</p></div>";
                            } else if ($signupCheck == "invalidEmail") {
                                echo "<div class='error-texti'><p>Väärä muotoinen sähköposti</p></div>";
                            } else if ($signupCheck == "pwdmatch") {
                                echo "<div class='error-texti'><p>Salasana ei täsmää</p></div>";
                            } else if ($signupCheck == "pwdlen") {
                                echo "<div class='error-texti'><p>Salasana vähintään 4 merkkiä</p></div>";
                            } else if ($signupCheck == "usernameTaken") {
                                echo "<div class='error-texti'><p>Käyttäjänimi käytössä</p></div>";
                            } else if ($signupCheck == "emailTaken") {
                                echo "<div class='error-texti'><p>Sähköposti käytössä</p></div>";
                            }
                        }

                        ?>
                    </div>
                    <div class="field input">
                        <label>Käyttäjänimi</label>
                        <?php
                        if (isset($_GET['name'])) {
                            $formName = $_GET['name'];

                            // haetaan GET parametri, jossa käyttäjän syöttämä data 
                            // ja asetetaan se lomakkeeseen, jotta käyttäjän ei tarvitse täyttää sitä uudelleen
                            echo '<input type="text" name="name" id="name" placeholder="Käyttäjänimi" value="' . $formName . '">';
                        } else {
                            echo '<input type="text" name="name" id="name" placeholder="Käyttäjänimi">';
                        }
                        ?>
                    </div>
                    <div class="field input">
                        <label>Sähköposti</label>
                        <?php
                        if (isset($_GET['email'])) {
                            $formEmail = $_GET['email'];

                            echo '<input type="text" name="email" id="email" placeholder="Sähköposti" value="' . $formEmail . '">';
                        } else {
                            echo '<input type="text" name="email" id="email" placeholder="Sähköposti">';
                        }
                        ?>

                    </div>
                    <div class="field input">
                        <label>Salasana</label>
                        <input type="password" name="password" id="Password" placeholder="Salasana">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="field input">
                        <label>Salasana uudelleen</label>
                        <input type="password" name="password2" id="PasswordVerify" placeholder="Salasana">
                    </div>
                    <div class="field button">
                        <input type="submit" name="submit" value="Jatka" id="submit">
                    </div>
                </form>
                <div class="link">Rekisteröitynyt jo?<a href="login.php"> Kirjaudu</a></div>
            </section>
        </div>

    </div>
    <script src="js/app.js"></script>
</body>

</html>