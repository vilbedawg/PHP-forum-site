<?php
include_once "header.php";
?>
<body>
    <div class="wrapper">
        <section class="form signup">
            <header>Chat App</header>
            <form action="./includes/signup.php" method="post">
                <div class="error-txt"></div>
                <div class="field input">
                    <label>Nimi</label>
                    <input type="text" name="name" placeholder="Etunimi" required>
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
                    <input type="submit" name="submit" value="Jatka">
                </div>
            </form>
            <div class="link">Rekisteröitynyt jo?<a href="#"> Kirjaudu</a></div>
        </section>
    </div>
    </body>
    </html>