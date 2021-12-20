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
$objUser->setUserID($_GET['user']);
$userOnView = $objUser->GetViewedUser();




?>
<body>
<div class="navbar-other">
        <div class="navbar-menu">
            <div class="current-user-parent">
                <h1>Rawr <i class="fa fa-rocket" aria-hidden="true" style="transform: rotate(45deg);"></i></h1>
            </div>
            <div class="buttons">
                <?php if (isset($_POST['edit'])) {
                    echo '<button class="create">Luo uusi</button>';
                } ?>
                <a href="logout.php"><button class="logout">Kirjaudu ulos</button></a>
                <a href="users.php"><button class="create">Home</button></a>
            </div>
        </div>
    </div>
<div class="user-edit-page">

    <div class="user-managment">
        <div class="edit-page-close">
            <a href="profile.php?user=<?php echo $userOnView[0]['user_id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
        </div>
        <h1 class="edit-user-title"> <?php echo $userOnView[0]['name'] ?> </h1>
        <div class="error-txt">
                    <?php if (!isset($_GET['error'])) {
                        echo "";
                    } else {
                        $signupCheck = $_GET['error'];

                        if ($signupCheck == "fileTooLarge") {
                            echo "<div class='error-texti'><p>Kuva liian iso, max 1000mb</p></div>";
                        }
                        if ($signupCheck == "invalidFileName") {
                            echo "<div class='error-texti'><p>Kuva sisältää ei-sallittuja kirjaimia</p></div>";
                        }
                        if ($signupCheck == "invalidFileExtension") {
                            echo "<div class='error-texti'><p>Väärä kuvan tiedostomuoto, vain jpg, jpeg, png</p></div>";
                        }
                        if($signupCheck  == "invalidName") {
                            echo "<div class='error-texti'><p>Väärän muotoinen nimi</p></div>";
                        }
                        if ($signupCheck == "usernameTaken"){
                            echo "<div class='error-texti'><p>Käyttäjänimi jo käytössä</p></div>";
                        }
                        if ($signupCheck == "invalidLength"){
                            echo "<div class='error-texti'><p>Käyttäjänimen tulee sisältää 3-14 merkkiä</p></div>";
                        }
                        if ($signupCheck == "invalidEmail"){
                            echo "<div class='error-texti'><p>Väärä muotoinen sähköposti</p></div>";
                        }
                        if ($signupCheck == "emailTaken"){
                            echo "<div class='error-texti'><p>Sähköposti käytössä</p></div>";
                        }
                        if ($signupCheck == 'success') {
                            echo "<div class='success-texti'><p>Tallennettu</p></div>";
                        }
                    } ?>
                </div>
        <div class="edit-page-box1">
        <div class="user-details">
            <h1>Profiilikuva</h1>
            <img src="<?php echo  $userOnView[0]['image'] ?>" class="image-preview"></img>
            <!-- kuvan vaihto form -->
            <div class="user-form-image">
                <form method="post"  enctype="multipart/form-data" id="imagesubmit">    
                <div class="field input-image">
                    <label>Profiilikuva</label>
                    <div class="form-group">
                    <input type="file" name="img" id="image" accept=".jpg,.jpeg,.png">
                    <input type="hidden" name="oldimg" id="oldimg" value="<?php echo $userOnView[0]['image']; ?>">
                    <input type="hidden" name="id" value="<?php echo $userOnView[0]['user_id']; ?>">
                    <div class="field button-img">
                        <input type="submit" name="img" value="Vaihda" id="submitImg">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- // -->
    </div>
             

        <!-- nimen vaihto form -->
        <div class="user-form-container">
        <h1>Käyttäjätiedot</h1>
        <div class="user-form-name">
            <form  method="post" id="nameSubmit">
                <div class="field input">
                    <label>Käyttäjänimi</label>
                     <div class="form-group">
                      <input type="hidden" name="userid" id="userid" value="<?php echo $userOnView[0]['user_id']; ?>">
                      <input type="text" name="name" id="name" placeholder="Käyttäjänimi" value="<?php echo $userOnView[0]['name'] ?>">
                      <div class="field button">
                        <input type="submit" name="submitname" value="Päivitä" id="submitname">
                      </div>
                     </div>
                </div>
                </form>
                <form method="post" id="emailSubmit">
                <div class="field input">
                    <label>Sähköposti</label>
                    <div class="form-group">
                    <input type="text" name="email" id="email" placeholder="Sähköposti" value="<?php echo $userOnView[0]['email'] ?>">
                    <input type="hidden" name="userid" value="<?php echo $userOnView[0]['user_id']; ?>">
                    <div class="field button">
                    <input type="submit" name="submitemail" value="Päivitä" id="submitemail">
                    </div>
                    </div>
                </div>
            </form>
                </div>
                <!-- // -->
                <button class="logout" style="margin-right: 0; font-size: 16px;">Vaihda salasana</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#nameSubmit").on('submit', function(e) {
            e.preventDefault();
            var name = $('#name').val();
            var id = $('#id').val();
            $.ajax({
                url: "action.php",
                method: "POST",
                data: { 
                name: name,
                id: id
                },
                dataType: "text",
                success: function(message) {
                    $('.edit-user-title').html(name);
                    $('.error-txt').stop().show();
                    $('.error-txt').stop().html(message);
                    $('.error-txt').stop().delay( 3000 ).fadeOut("fast");
                },
                error: function(message) {
                    alert('jokin meni pieleen');
                }
            });
        });
        $("#emailSubmit").on('submit', function(e) {
            e.preventDefault();
            var email = $('#email').val();
            var id = $('#userid').val();
            $.ajax({
                url: "action.php",
                method: "POST",
                data: { 
                email: email,
                id: id
                },
                dataType: "text",
                success: function(message) {
                    $('.error-txt').stop().show();
                    $('.error-txt').stop().html(message);
                    $('.error-txt').stop().delay( 3000 ).fadeOut("fast");
                },
                error: function(message) {
                    alert('jokin meni pieleen');
                }
            });
        });
        $("#imagesubmit").on('submit', function(e){
        e.preventDefault();
        var data = $(".error-txt").val();
        var image = $('#image')[0].files[0];
        var oldimg = $("#oldimg").val();
        alert(image);
        $.ajax({
            url: 'action.php',
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data) {
                data = $.parseJSON(data);
                    $('.error-txt').stop().show();
                    $('.error-txt').stop().html(data.error);
                    $('.user-managment img').replaceWith(data.img);
                    $(oldimg).val(data.img);
                },
                error: function(data) {
                    alert('jokin meni pieleen');
                }
            });  
        });
    });    
</script>

</body>