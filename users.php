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
<div class="home-filler">
        </div>
    <div class="navbar">
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
            <a href="create.php"><button class="create">Luo uusi</button></a>
        </div>
    <div class="home">
        <div class="discussion-page">
    
            <?php
                $postObj = new PostedContent;
                $posts = $postObj->getAllPostsByNewest();

               

                foreach($posts as $post) {
                    $mysqldate = strtotime($post['date']);
                    $phpdate = date('Y/m/d G:i A', $mysqldate);

                    echo "<div class='room-container'>
                        <div class='room " . $post['category'] .  "'>
                                <div class='date-and-users'>
                                    <div class='date-users'>
                                        <p class='username-users'>" . $post['name'] . "</p>
                                        <p>" . $phpdate . "</p>
                                    </div>
                                    <h1 class='user-post'>". $post['title'] ."</h1>
                                    </div> 
                                    <div class='bodytext-users'><p>". $post['content'] ."</p></div>
                                <div class='hashtag'>
                                ". $post['category'] ." </div>
                                </div>
                            </div>";
                    }
            ?>
        </div>
        <script src="js/timeout.js"></script>
        <script>
        
            $('.room').on('click', () => {
                location.href = 'room-1.php?room="<?php $post['category'] ?>"'; 
            });


        </script>
        <script src="js/users.js"></script>
</body>

</html>