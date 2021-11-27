<?php
include_once "header.php";
?>
<body>
    <?php
        if(isset($_POST['register'])) {
            require("db/users.php");
            $objUser = new users;
            $objUser->setFname($_POST['fname']);
            $objUser->setLname($_POST['lname']);
            $objUser->setEmail($_POST['email']);
            $objUser->setEmail($_POST['password']);
            $objUser->setImg($_POST['img']);
            $objUser->setLoginStatus(1);
            $objUser->setLastLogin(date('d.m.Y H:i'));
            if($objUser->save()) {
                echo "Tallennettu";
            } else {
                echo "failed";
            }
        }
       
    ?>



    <div class="wrapper">
        <section class="form signup">
            <header>Chat App</header>
            <form action="#" enctype="multipart/form-data" autocomplete="off" method="POST">
                <div class="error-txt"></div>
                <div class="name-details">
                    <div class="field input">
                        <label>Etunimi</label>
                        <input type="text" name="fname" placeholder="Etunimi" required>
                    </div>
                    <div class="field input">
                        <label>Sukunimi</label>
                        <input type="text" name="lname" placeholder="Sukunimi" required>
                    </div>
                </div>
                <div class="field input">
                    <label>Sähköposti</label>
                    <input type="text" name="email" placeholder="Sähköposti" required>
                </div>
                <div class="field input">
                    <label>Salasana</label>
                    <input type="password" name="password" id="Password" placeholder="Salasana" required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field input">
                    <label>Salasana uudelleen</label>
                    <input type="password"  name="password2" id="PasswordVerify" placeholder="Salasana" required>
                </div>
                <div class="field image">
                    <label>Kuva</label>
                    <input type="file" name="image" required>
                </div>
                <div class="field button">
                    <input type="submit" name="submit" id="register" value="Jatka">
                </div>
            </form>
            <div class="link">Rekisteröitynyt jo?<a href="#"> Kirjaudu</a></div>
        </section>
    </div>
    </body>
    </html>