<?php
session_start();
require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';
require_once 'controllers/comment-contr.php';

include_once "header.php";
if (!isset($_SESSION["userid"])) {
    header("location: login.php");
    exit();
}



// kaikki postaukset 

$roomNum = $_GET['room'];

// Kaikki kommentit
$objPost = new PostedContent();
$allPosts = $objPost->getAllComments($roomNum);


//Postauksen koodi
if(isset($_POST['post'])) {
    $content = $_POST['content'];
    $post = new commentContr($content, $roomNum);
    $post->PostComment();
    header("Location: room-1.php?room=$roomNum&error=none");
}


$getCurrentRoom = new PostedContent();
$currentRoom = $getCurrentRoom->getAllPostsByRoomID($roomNum); 

?>

<body>
    <div class="navbar-other">
    <div class="navbar-menu">
        <div class="current-user-parent">
            <h1>Epic Blog</h1>
        </div>
        <div class="buttons">
        <a href="logout.php"><button class="logout">Kirjaudu ulos</button></a>
        <a href="users.php"><button class="create">Home</button></a>
        </div>
    </div>
        </div> 
    <div class="all-content">

    

    <div class="all-comments">
    <div class="room-header">
        <div class='date-and-users'>
            <div class='date'>
                <p class='username'><?php echo $currentRoom[0]['name']; ?></p>
                <p><?php echo $currentRoom[0]['date']; ?></p>
            </div>
        <h1 class='room-header-h1'><?php echo $currentRoom[0]['title']; ?></h1>
        <p class='room-header-p'> <?php echo $currentRoom[0]['topic']; ?> </p>
    </div>
    <div class='post-toolbar'>
        <i class='far fa-comment-alt'></i>
        <?php $roomAmount = count($allPosts);
            echo "<p>". $roomAmount ." kommenttia</p>"?>
    </div>
    </div>
                
    
   

    <div class="discussion-section">

    <div class="comment-form">
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
                <textarea class="tinymce" name="content" id="topic" placeholder="Kerro ajatuksistasi..." rows="7"></textarea>
            </div>
            <div class="post-comment">
                <input type="submit" name="post" value="Kommentoi" id="post">
            </div>
        </form>
        </div>
       
        <span class="post-hr"><hr></span>
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
    <a href="" class="scrollup">
    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="#4895ef" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 7.58l5.995 5.988-1.416 1.414-4.579-4.574-4.59 4.574-1.416-1.414 6.006-5.988z"/></svg>
    </a>
    </div>  
    </div>
    <script>
    setTimeout(function(){
        $('.success-texti').fadeOut(500, function() {
            $(this).remove();
        });
        }, 2000);
    </script>
    <script type="text/javascript" src="tinymce\jquery.tinymce.min.js"></script>
    <script type="text/javascript" src="tinymce\tinymce.min.js"></script>
    <script type="text/javascript" src="tinymce\init-tinymce.js"></script>
    <script src="js/timeout.js"></script>
    <script src="js/modal.js"></script>
</body>