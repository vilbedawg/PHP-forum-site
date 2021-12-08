<?php
session_start();
require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';

include_once "header.php";
// kaikki postaukset 
$objPost = new PostedContent();
$allPosts = $objPost->getAllCsharpPostsByDate();


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
    <div class="room-header python">
        <h1>C# Room</h1>
    </div>
    <div class="discussion-section">
        <?php
        if (count($allPosts) == 0) {
            echo "<div class='empty-room'><p>Täällä on tyhjää</p></div>";
        } else {
            foreach ($allPosts as $key => $userPost) {
                $mysqldate = strtotime($userPost['date']);
                $phpdate = date('Y/m/d G:i A', $mysqldate);
                echo "<div class='discussion-wrapper'>
                <div class='discussion'>
                <div class='date'>
                <p class='username'>" . $userPost['name'] . "</p>
                <p>" . $phpdate . "</p>
                </div>
                <div class='bodytext'><p>" . $userPost['content'] . "</p> </div>
                </div>
                </div>";
            }
        }
        ?>
    </div>
    <?php
    require("controllers/posts-contr.php");
    //Postauksen koodi
    if(isset($_POST['post'])) {
        include_once "classes/posts-contr.php";
        $content = $_POST['content'];
        $category = 'c#';
        $post = new PostsContr($content, $category);
        $post->PostContent();
        header("Location: room-1.php?error=none");

    }
    ?>
    <div class="create-form">
        <form class="form-post" method="POST">
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
            <div class="form-group">
            <a id="comment"></a>
                <label>Aihe</label>
                <textarea class="form-control" name="content" id="topic" placeholder="Kerro ajatuksistasi..." rows="7"></textarea>
            </div>
            <div class="post-topic-button">
                <input type="submit" name="post" value="Kommentoi" id="post">
            </div>
        </form>
</body>