<?php
session_start();
if (!isset($_SESSION["userid"])) {
    header("location: login.php");
    exit();
}

include_once "header.php";
require 'classes/database.php';
require 'includes/autoload-classes.php';
require("classes/posts-contr.php");

//Postauksen koodi
if(isset($_POST['post'])) {
    $title = $_POST['subject'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $post = new PostsContr($title, $content, $category);
    $post->PostContent();
    header("location: redirect-page.php");
}
?>

<body>
<div class="navbar">
        <div class="current-user-parent">
            <div class="current-user">
                <span><?php echo $_SESSION["name"] ?></span>
                <p><?php if ($_SESSION["login"] == 1) {
                        echo "Online";
                    } else {
                        echo "Offline";
                    } ?></p>
            </div>
        </div>
        <div class="buttons">
            <button class="create"><a href="users.php">Takaisin</a></button>
            <button class="logout"><a href="logout.php">Kirjaudu ulos</a></button>
        </div>
    </div>
    <div class="create-form">
        <form class="form-post" method="POST">
            <?php
                    if(!isset($_GET['error'])) {
                        echo "";
                    }
                    else{
                        $signupCheck = $_GET['error'];

                        if ($signupCheck == "emptyinput") {
                            echo "<div class='error-texti'><p>Täytä kaikki kohdat</p></div>";
                        }
                    }
               
                ?>
            <div class="form-group-upper">
            <label>Otsikko</label>
            <input type="text" name="subject" id="subject">
            </div>
            <div class="form-group-middle">
            <label>Kategoria</label>
            <div class="radio-buttons">
                <div class="radio1">
                    <input type="radio" name="category" id="select1" value="Python">
                    <label>Python</label>
                </div>
                <div class="radio2">
                    <input type="radio" name="category" id="select2" value="PHP">
                    <label>PHP</label>
                </div>
                <div class="radio3">
                    <input type="radio" name="category" id="select3" value="c#">
                    <label>C#</label>
                </div>
            </div>
            </div>
            <div class="form-group">
            <label>Aihe</label>
            <textarea class="form-control" name="content" id="topic" rows="7"></textarea>
            </div>
            <div class="post-topic-button">
                <input type="submit" name="post" value="Julkaise" id="post">
            </div>
        </form>
    </div>
    <script>
    </script>
</body>

</html>