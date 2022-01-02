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
<body>
  <!--Modal section-->
  <div class="bg-modal">
        <div class="modal-content">
            <div class="modal-close"><i class="fas fa-times"></i>
            </div>
            <div class="modal-side-bar">
            <div class="profile-status">
                <h1>Kategoriat</h1>
            </div>
            <div class="modal-categories">
                <div class="category-item">Yleinen</div>
                <div class="category-item">Politiikka</div>
                <div class="category-item">Valokuvaus</div>
                <div class="category-item">Videot</div>
                <div class="category-item">Tarinat</div>
                <div class="category-item">Taide</div>
                <div class="category-item">Pelit</div>
                <div class="category-item">Elokuvat</div>
                <div class="category-item">Musiikki</div>
                <div class="category-item">Urheilu</div>
                <div class="category-item">Harrastukset</div>
                <div class="category-item" style="color: red;">NSFW</div>
            </div>
            </div>

            <?php
            if (isset($_POST['post'])) {
                include_once "controllers/posts-contr.php";
                $title = $_POST['subject'];
                $topic = $_POST['topic'];
                $category = $_POST['category'];
                
                $post = new PostsContr($title, $topic, $category);
                $i = $post->PostTopic();
                $objUser->setUserID($_SESSION['userid']);
                $mostRecent = $objUser->GetMostRecent();
                header('Location: view.php?room= '. $mostRecent[0]['MAX(post_id)'] .' ');
            }

            ?>
            
            <div class="create-form">
                <form class="form-post" method="POST">
                <div class="error-text">
                    <?php
                    if (!isset($_GET['error'])) {
                        echo "";
                    } else {
                        $signupCheck = $_GET['error'];
                        if ($signupCheck == "emptyinput") {
                            echo "<div class='error-texti'><p>Täytä kaikki kohdat</p></div>";
                        }
                        if ($signupCheck == "invalidTitle") {
                            echo "<div class='error-texti'><p>Otsikko sisältää ei sallittuja kirjaimia</p></div>";
                        }
                        if ($signupCheck == "invalidLength") {
                            echo "<div class='error-texti'><p>Otsikon täytyy olla 3-50 merkkiä</p></div>";
                        }
                        if ($signupCheck == "invalidCategory") {
                            echo "<div class='error-texti'><p>Valitse jokin kategoria listalta</p></div>";
                        }
                    }
                    ?>
                </div>
                <div class="form-group-box">
                    <div class="form-group-upper">
                        <label>Otsikko</label>
                    <?php if(isset($_GET['title'])) {
                         $formName = $_GET['title'];
                        
                        echo '<input type="text" name="subject" id="subject" value="'.$formName.'">';
                        } else {
                            echo '<input type="text" name="subject" id="subject"></input>';
                        } ?>
                        </div>
                        <div class="form-group-upper" style="margin-bottom: 0;">
                        <label>Valitse kategoria</label>
                        <input type="text" name="category" id="category"> 
                    </div>
                    <div id="categorylist"></div>
                    </div>
                    <div class="form-group">
                        <label>Aihe</label>
                        <?php if(isset($_GET['topic'])) {
                         $formContent = $_GET['topic'];
                        echo '<textarea class="tinymce" name="topic" id="topic" rows="7">'. $formContent .'</textarea>';
                        } else {
                            echo '<textarea class="tinymce" name="topic" id="topic" rows="7"></textarea>';
                        } ?>
                        
                        <div class="post-topic-button">
                            <input type="submit" name="post" value="Julkaise" id="post">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Modal section loppuu-->
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
                    echo '<a href="logout.php"><button class="logout">Kirjaudu ulos</button></a>';
                }else {
                    echo '<a href="login.php"><button class="logout">Kirjaudu sisään</button></a>';
                }
                ?>
            </div>
            
        </div>
<div class="user-edit-page">

    <div class="user-managment">
        <div class="edit-page-close">
            <a href="profile.php?user=<?php echo $userOnView[0]['user_id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
        </div>
        <h1 class="edit-user-title"> <?php echo $userOnView[0]['name'] ?> </h1>
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

    });    
</script>
<script type="text/javascript" src="tinymce\jquery.tinymce.min.js"></script>
<script type="text/javascript" src="tinymce\tinymce.min.js"></script>
<script type="text/javascript" src="tinymce\init-tinymce.js"></script>
<script src="js/app.js"></script>
</body>