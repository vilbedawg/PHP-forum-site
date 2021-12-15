<?php
session_start();
if (!isset($_SESSION["userid"])) {
    header("location: login.php");
    exit();
}
require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';
require 'includes/user-info.php';
include_once "header.php";

$objUser = new Users;
$users = $objUser->GetAllUsers();
$onliners = $objUser->GetAllOnliners();

?>

<body>
    <!--Modal section-->
    <div class="bg-modal">
        <div class="modal-content">
            <div class="modal-close"><i class="fas fa-times"></i>
            </div>

            <?php
            if (isset($_POST['post'])) {
                include_once "controllers/posts-contr.php";
                $title = $_POST['subject'];
                $topic = $_POST['topic'];
                $category = $_POST['category'];
                $post = new PostsContr($title, $topic, $category);
                $post->PostTopic();
                header("location: redirect-page.php");
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
                        }
                        ?>
                    </div>
                    <div class="form-group-upper">
                        <label>Otsikko</label>
                        <input type="text" name="subject" id="subject"></input>
                    </div>
                    <div class="form-group-middle">
                        <label>Kategoria</label>
                        <div class="radio-buttons">
                            <div class="radio1">
                                <input type="radio" name="category" id="select1" value="Python"></input>
                                <label>Python</label>
                            </div>
                            <div class="radio2">
                                <input type="radio" name="category" id="select2" value="PHP"></input>
                                <label>PHP</label>
                            </div>
                            <div class="radio3">
                                <input type="radio" name="category" id="select3" value="C#"></input>
                                <label>C#</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Aihe</label>
                        <textarea class="tinymce" name="topic" id="topic" rows="7"></textarea>
                        <div class="post-topic-button">
                            <input type="submit" name="post" value="Julkaise" id="post">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Modal section loppuu-->

    <div class="navbar-other">
        <div class="navbar-menu">
            <div class="current-user-parent">
                <h1>Rawr</h1>
            </div>
            <div class="buttons">
                <a href="logout.php"><button class="logout">Kirjaudu ulos</button></a>
            </div>
        </div>
    </div>



    <div class="home-other">
        
    <div class="user-managment">
    <img src='<?php echo $_SESSION['image'] ?>'></img>
    <div class='user-form'>
        <form action="" method="post" enctype="multipart/form-data">
        <div class="error-txt">
                <?php
                    if(!isset($_GET['error'])) {
                        echo "";
                    }
                    else{
                        $signupCheck = $_GET['error'];

                        if ($signupCheck == "emptyinput") {
                            echo "<div class='error-texti'><p>Täytä kaikki kohdat</p></div>";
                        }
                        else if($signupCheck  == "invalidName") {
                            echo "<div class='error-texti'><p>Väärä muotoinen nimi</p></div>";
                        }
                        else if ($signupCheck == "invalidEmail"){
                            echo "<div class='error-texti'><p>Väärä muotoinen sähköposti</p></div>";
                        }
                        else if ($signupCheck == "pwdmatch"){
                            echo "<div class='error-texti'><p>Salasana ei täsmää</p></div>";
                        }
                        else if ($signupCheck == "pwdlen"){
                            echo "<div class='error-texti'><p>Salasana vähintään 4 merkkiä</p></div>";
                        }
                        else if ($signupCheck == "usernameTaken"){
                            echo "<div class='error-texti'><p>Käyttäjänimi käytössä</p></div>";
                        }
                        else if ($signupCheck == "emailTaken"){
                            echo "<div class='error-texti'><p>Sähköposti käytössä</p></div>";
                        }
                        
                    }
               
                ?>
                </div>
                <div class="field input">
                    <label>Käyttäjänimi</label>
                    <?php
                     if(isset($_GET['name'])) {
                         $formName = $_GET['name'];
                        echo '<input type="text" name="name" id="name" placeholder="Käyttäjänimi" value="'.$formName.'">';
                    } else {
                        echo '<input type="text" name="name" id="name" placeholder="Käyttäjänimi">';
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
                <div class="field input-image">
                <label>Profiilikuva</label>
                    <input type="file"  name="image" id="image" accept=".jpg,.jpeg,.png">
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Päivitä" id="submit">
                </div>           
        </form>
    </div>
    </div>


        <div class="profile">
            <div class="profile-status">
                <h1>Käyttäjätiedot</h1>
            </div>
            <div class="about">
                <div class="member-amount">
                    <p class="amount"><?php echo count($users); ?></p>
                    <p>Jäsentä</p>
                </div>
                <div class="members-online">
                    <p class="amount"><?php echo count($onliners); ?></p>
                    <p>paikalla</p>
                </div>
            </div>
            <hr>
            <div class="users-link"><button class="create">Luo uusi</button></div>
            <hr>
            <p><?php echo $_SESSION['name'] ?></p>
            <a href="users.php"><button class="create">Home</button></a>
        </div>
    </div>  
    <div class="all-user-info"></div>


    <a href="" class="scrollup">
        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="#4895ef" viewBox="0 0 24 24">
            <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 7.58l5.995 5.988-1.416 1.414-4.579-4.574-4.59 4.574-1.416-1.414 6.006-5.988z" />
        </svg>
    </a>
    <script src="js/pass-show-hide.js"></script>
    <script src="js/timeout.js"></script>
    <script src="js/modal.js"></script>
    <script type="text/javascript" src="tinymce\jquery.tinymce.min.js"></script>
    <script type="text/javascript" src="tinymce\tinymce.min.js"></script>
    <script type="text/javascript" src="tinymce\init-tinymce.js"></script>
</body>
</html>