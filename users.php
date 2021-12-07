<?php
session_start();

require 'classes/database.php';
require 'includes/autoload-classes.php';


include_once "header.php";
$objUser = new Users;
$users = $objUser->GetAllUsers();

// kaikki postaukset 
$objPost = new PostedContent();
$allPosts = $objPost->getAllPostsByDate();


if (!isset($_SESSION["userid"])) {
    header("location: login.php");
    exit();
}



require("classes/posts-contr.php");
//Postauksen koodi
if(isset($_POST['post'])) {
    
    $title = $_POST['subject'];
    $content = $_POST['content'];

    $post = new PostsContr($title, $content);
    $post->PostContent();
    header("location: users.php");

}

?>

<body>
    <div class="navbar">
        <form class="form-post" method="POST" >
            <label>Otsikko</label>
            <div class="post field">
                <input type="text" name="subject" id="subject" >
            </div>
            <label>Aihe</label>
            <div class="post-field">
                <textarea class="form-control" name="content" id="topic" rows="7" ></textarea>
            </div>
            <div class="post-topic-button">
                <input type="submit" name="post" value="Jatka" id="post">
            </div>
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
        </form>
    </div>
    <div class="home">
        <div class="wrapper">
            <section class="users">
                <header>
                    <div class="content">
                        <div class="current-user">
                            <span><?php echo $_SESSION["name"] ?></span>
                            <p><?php if ($_SESSION["login"] == 1) {
                                    echo "Online";
                                } else {
                                    echo "Offline";
                                } ?></p>
                        </div>
                    </div>
                    <a href="logout.php" class="logout">Kirjaudu ulos</a>
                </header>
                <div class="search" id="search">
                    <span class="text">Etsi käyttäjä</span>
                    <input type="text" placeholder="Anna nimi...">
                    <button><i class="fas fa-search"></i></button>
                </div>
                <div class="users-list">
                    <?php
                    foreach ($users as $key => $user) {
                        $name = $user['name'];
                        if ($user['login_status'] == 1) {
                            echo "<div class='content'>
                        <div class = 'details'>
                        <span input type='hidden' name='userid' id='userid' value" . $key . ">" . $user['name'] . "</span>
                        <div class='status-dot'><i class='fas fa-circle'></i></div>
                        </div></div><hr/>";
                            echo "<a href='chatroom.php?name=$name'>chatroom</a>";
                        } else {
                            echo "<div class='content'>
                        <div class = 'details'>
                        <span>" . $user['name'] . "</span>
                        <div class='status-dot offline'><i class='fas fa-circle'></i></div>
                        </div></div><hr/>";
                        }
                    }
                    ?>
                </div>
            </section>
        </div>
        <div class="discussion-page">
        <?php 
            foreach ($allPosts as $key => $userPost) {
                $mysqldate = strtotime($userPost['date']); 
                $phpdate = date('Y/m/d G:i A', $mysqldate);
                echo "<div class='discussion-wrapper'>
                <div class='discussion'>
                <div class='title'> " . $userPost['title'] . " </div>
                <div class='content'> " . $userPost['content'] . " </div>
                </div>
                <div class='date'>
                    <p>Aloitettu</p>
                    <p>" . $phpdate . "</p>
                </div>
            </div>";
                    
            }
        ?>
    </div>
<script src="js/users.js"></script>
<script src="js/timeout.js">


</script>
</body>

</html>