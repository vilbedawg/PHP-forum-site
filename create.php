<?php
session_start();
include_once "header.php";
require 'classes/database.php';
require 'includes/autoload-classes.php';
require("classes/posts-contr.php");

//Postauksen koodi
if(isset($_POST['post'])) {
    $title = $_POST['subject'];
    $content = $_POST['content'];

    $post = new PostsContr($title, $content);
    $post->PostContent();
    header("location: redirect-page.php");
}
?>

<body>
    <div class="create-form">
        <form class="form-post" method="POST">
        <div class="error-text">
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
        </div>
            <div class="form-group-upper">
            <label>Otsikko</label>
            <input type="text" name="subject" id="subject">
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