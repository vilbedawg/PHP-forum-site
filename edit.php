<?php
session_start();
if (!isset($_SESSION["userid"])) {
    header("location: login.php");
    exit();
}
require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';
include_once "includes/header.php";
$objUser = new Users;
$userOnView = $objUser->GetViewedUser();


?>
<div class="user-edit-page">
    <div class="user-managment">
        <div class="edit-page-close">
            <a href="profile.php?user=<?php echo $userOnView[0]['user_id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
        </div>
        <img src="<?php echo  $userOnView[0]['image'] ?>"></img>
        <div class="user-details">
            <h1> <?php echo $userOnView[0]['name'] ?> </h1>
        </div>
        <div class="user-form">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="error-txt">
                    <?php if (!isset($_GET['error'])) {
                        echo "";
                    } else {
                        $signupCheck = $_GET['error'];

                        if ($signupCheck == "emptyinput") {
                            echo "<div class='error-texti'><p>Täytä kaikki kohdat</p></div>";
                        } else if ($signupCheck  == "invalidName") {
                            echo "<div class='error-texti'><p>Väärän muotoinen nimi</p></div>";
                        } else if ($signupCheck == "pwdmatch") {
                            echo "<div class='error-texti'><p>Salasana ei täsmää</p></div>";
                        } else if ($signupCheck == "pwdlen") {
                            echo "<div class='error-texti'><p>Salasana vähintään 4 merkkiä</p></div>";
                        } else if ($signupCheck == "usernameTaken") {
                            echo "<div class='error-texti'><p>Käyttäjänimi käytössä</p></div>";
                        }
                    } ?>
                </div>
                <div class="field input">
                    <label>Käyttäjänimi</label>
                    <?php if (isset($_GET['name'])) {
                        $formName = $_GET['name'];
                        echo '<input type="text" name="name" id="name" placeholder="Käyttäjänimi" value="' . $formName . '">';
                    } else {
                        echo '<input type="text" name="name" id="name" placeholder="Käyttäjänimi">';
                    } ?>
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
                <div class="field input-image">
                    <label>Profiilikuva</label>
                    <input type="file" name="image" id="image" accept=".jpg,.jpeg,.png">
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Päivitä" id="submit">
                </div>
        </div>
        </form>
    </div>
</div>