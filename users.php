<?php
session_start();

require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';


include_once "header.php";
$objUser = new Users;
$users = $objUser->GetAllUsers();



if (!isset($_SESSION["userid"])) {
    header("location: login.php");
    exit();
}

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
                        <input type="radio" name="category" id="select3" value="C#"></input>
                        <label>C#</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Aihe</label>
                <textarea class="form-control" name="topic" id="topic" rows="7"></textarea>
                <div class="post-topic-button">
                    <input type="submit" name="post" value="Julkaise" id="post">
                </div>
            </div>
        </form>
        </div>
    </div>
    </div>

    <!--Modal section loppuu-->

    <div class="home-filler">
        </div>
    <div class="navbar">
    <div class="navbar-menu">
        <div class="current-user-parent">
            <h1>Epic Blog</h1>
        </div>
        <div class="buttons">
        <a href="logout.php"><button class="logout">Kirjaudu ulos</button></a>
        </div>
    </div>
    <div class="search-toolbar">
            <div class="search">
                <button><i class="fas fa-search"></i></button>
                <input type="text" placeholder="Etsi julkaisu...">
            </div>
            <button class="create">Luo uusi</button>
        </div>
        </div>
    <div class="home">
        <div class="discussion-page">
    
            <?php
                $postObj = new PostedContent;
                $posts = $postObj->getAllPostsByNewest();

               

                foreach($posts as $post) {
                    $mysqldate = strtotime($post['date']);
                    $phpdate = date('Y/m/d G:i A', $mysqldate);

                    echo "<a href='room-1.php?room=". $post['post_id'] ."'style='color: black; display: block;'><div class='room-container'>
                        <div class='room " . $post['category'] .  "'>
                                <div class='date-and-users'>
                                    <div class='date-users'>
                                        <p class='username-users'>" . $post['name'] . "</p>
                                        <p>" . $phpdate . "</p>
                                    </div>
                                    <h1 class='user-post'>". $post['title'] ."</h1>
                                    </div> 
                                    <div class='bodytext-users'><p>". $post['topic'] ."</p></div>
                                <div class='hashtag'>
                                ". $post['category'] ." </div>
                                </div>
                            </div></a>";
                    }
            ?>
        </div>
        <script src="js/timeout.js"></script>
        <script src="js/users.js"></script>
        <script src="js/modal.js"></script>
        <script src="js/navbar.js"></script>
</body>

</html>