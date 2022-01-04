<?php
session_start();

require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';
require_once "includes/header.php";

$objUser = new Users;
$objUser->setUserID($_GET['user']);
$userOnView = $objUser->GetViewedUser();
if (!isset($_SESSION["userid"])) {
    header("location: profile.php?user=". $userOnView[0]['user_id'] ."");
    exit();
}

if($_SESSION["userid"] !== $userOnView[0]['user_id']) {
    header("location: profile.php?user=". $userOnView[0]['user_id'] ."");
    exit();
}


?>
<body style="background-color: #324960;">
    <div class="search-toolbar">
        <div class="dropdown">
            <button onclick="myFunction()" class="dropbtn"><div class="drop-icons"><i class="fa fa-home" aria-hidden="true" style="margin-right: 5px;"></i> Koti</div> <i class="fas fa-angle-down"></i></button>
            <div id="myDropdown" class="dropdown-content">
                <a href="home.php?show=Etusivu">Etusivu</a>
                <?php if(isset($_SESSION['userid'])) { 
                    echo '<a href="profile.php?user='. $_SESSION['userid'] .'">Profiili</a>';
                    echo '<a href="manage.php?user='. $_SESSION['userid'] .'">Muokkaa profiilia</a>';
                    echo '<button class="create dropdown" style="width: 100%; border-radius: 0;">Luo uusi</button>';
                     } ?>
            </div>
            </div>
            <div class="search">
                <input type="text" id="post-search" placeholder="Etsi julkaisu...">
                <div class="post-category-list"></div>
            </div>
            <div class="buttons">
            <?php if(isset($_SESSION['userid'])) {
                    echo '<a href="logout.php"><button class="logout"><i class="fas fa-sign-out-alt"></i></button></a>';
                }else {
                    echo '<a href="login.php"><button class="logout"><i class="fa fa-sign-in" aria-hidden="true"></i></button></a>';
                }
                ?>
            </div>
        </div>
 <div class="user-edit-page">
    <div class="user-managment">
    <div class="delete-account" id="<?php echo $_SESSION['userid']; ?>">
        <p>Poista tilini</p>
    </div>
        <div class="edit-page-close">
            <a href="profile.php?user=<?php echo $userOnView[0]['user_id']; ?>" style="color: #333; font-size: 18px;"><i class="fa fa-times" aria-hidden="true"></i> Sulje</a>
        </div>
        <div class="error-txt" style="display: none;"></div>
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
        <h1><?php echo $userOnView[0]['name'] ?> Käyttäjätiedot</h1>
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
            <form method="post" id="passwordChange" style="display:none; padding-top: 10px;">
                <div class="field input">
                    <label>Uusi salasana</label>
                    <div class="form-group" style="padding-bottom: 15px; position: relative;">
                    <i class="fas fa-eye"></i>
                    <input type="password" name="password" id="Password" style="border-radius: 5px;">
                    </div>
                    <label>Uusi salasana uudelleen</label>
                    <div class="form-group">
                    <input type="password" name="passwordRepeat" id="PasswordVerify" >
                    <input type="hidden" name="userid" value="<?php echo $userOnView[0]['user_id']; ?>">
                    <div class="field button">
                    <input type="submit" name="submitPassword" value="Päivitä" id="submitPassword">
                    </div>
                    </div>
                </div>
            </form>
                </div>
                <!-- // -->
            <button class="logout" id="pwdEdit" style="margin-right: 0; font-size: 16px;">Vaihda salasana</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var id = $('#userid').val();
        $("#nameSubmit").on('submit', function(e) {
            e.preventDefault();
            var name = $('#name').val();
            $.ajax({
                url: "search.php",
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
            $.ajax({
                url: "search.php",
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
        var image = $('#image')[0].files[0];
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
                    $('.error-txt').stop().delay( 1000 ).fadeOut("fast");
                    $('.user-managment img').replaceWith(data.img);
                    $("#oldimg").val(data.img);
                },
                error: function(data) {
                    alert('jokin meni pieleen');
                }
                
            });  
            $("#imagesubmit")[0].reset();
        });

        $('#pwdEdit').on('click', function(e) {
            var pwdForm = $('#passwordChange');
            $(e.target).toggleClass('pwdFormShow');
            if ($(this).hasClass('pwdFormShow')){
                $(this).text('Sulje');
                $(pwdForm).show();
            } else {
                $(this).text('Vaihda Salasana');
                $(pwdForm).hide();
                $(pwdForm)[0].reset();
            }
        });


        $("#passwordChange").on('submit', function(e){
            e.preventDefault();
            var pass = $('#Password').val();
            var pass2 = $('#PasswordVerify').val();
            if(pass === pass2) {
                $.ajax({
                    url: 'search.php',
                    type: 'POST',
                    data: {
                        password: pass,
                        id: id
                    },
                    dataType: "text",
                    error: function() {
                        alert("Jokin meni vikaan");
                    },
                    success: function(data) {
                        $('.error-txt').stop().show();
                        $('.error-txt').stop().html(data);
                        $('.error-txt').stop().delay( 3000 ).fadeOut("fast");
                        $("#passwordChange")[0].reset();
                    }
                });
            } else {
                $('.error-txt').stop().show();
                $('.error-txt').stop().html('<div class="error-texti"><p>Salasana ei täsmää</p></div>');
                $('.error-txt').stop().delay( 3000 ).fadeOut("fast");
                $('#Password, #PasswordVerify').css({'border-color' : 'red'});
            } 
         });

        $(document).on('click', '.delete-account', function() {
            var id = $(this).attr("id");
            if(confirm(' Haluatko varmasti poistaa tilisi ?'))
            {
                $.ajax({
                url: 'search.php',
                type: 'GET',
                data: {id: id},
                error: function() {
                    alert('Jokin meni vikaan');
                },
                success: function(data) {
                        alert("Tilisi poistettiin onnistuneesti.");  
                        window.location = 'login.php';
                    }
                });
            }
            });
    });   
</script>
<script type="text/javascript" src="tinymce\jquery.tinymce.min.js"></script>
<script type="text/javascript" src="tinymce\tinymce.min.js"></script>
<script type="text/javascript" src="tinymce\init-tinymce.js"></script>
<script src="js/app.js"></script>
</body>