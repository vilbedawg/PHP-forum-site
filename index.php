<?php
include_once "header.php";

if(isset($_POST['submit'])) {
    require("db/users.php");
    $objUser = new users;
    $objUser->setEmail($_POST['email']);
    $objUser->setName($_POST['name']);
    $objUser->setpwd($_POST['password']);
    $objUser->setLoginStatus(1);
    $objUser->setLastLogin(date('Y-m-d h:i:s'));
    if($objUser->save()) {
        echo "Saved...";
    }else{
        echo"Failed...";
    }
}

?>
<body>
    <div class="wrapper">
        <section class="form signup">
            <header>Chat App</header>
            <form action="" method="post">
                <div class="error-txt"></div>
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
    </body>
    </html>