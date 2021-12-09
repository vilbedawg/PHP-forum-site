<?php
session_start();
if (!isset($_SESSION["userid"])) {
    header("location: login.php");
    exit();
}

include_once "header.php";
require 'classes/database.php';
require 'includes/autoload-classes.php';

if (isset($_POST['post'])) {
    include_once "controllers/posts-contr.php";
    $title = $_POST['subject'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $post = new PostsContr($title, $content, $category);
    $post->PostTopic();
    header("location: redirect-page.php");
}

?>

<body>
    <div class="navbar">
        <div class="current-user-parent">
            <h1>Epic Blog</h1>
        </div>
        <div class="buttons">
            <a href="users.php"><button class="back">Takaisin</button></a>
            <a href="logout.php"><button class="logout">Kirjaudu ulos</button></a>
        </div>
    </div>
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
                    if ($signupCheck == "none") {
                        echo "<div class='success-texti'><p>Kommenttisi on julkaistu</p></div>";
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
                        <input type="radio" name="category" id="select3" value="c#"></input>
                        <label>C#</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Aihe</label>
                <textarea class="form-control" name="content" id="topic" rows="7"></textarea>
                <div class="post-topic-button">
                    <input type="submit" name="post" value="Julkaise" id="post">
                </div>
            </div>
        </form>
</body>