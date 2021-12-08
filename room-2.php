
<?php
session_start();
require 'classes/database.php';
require 'includes/autoload-classes.php';

include_once "header.php";
// kaikki postaukset 
$objPost = new PostedContent();
$allPosts = $objPost->getAllPHPPostsByDate();


?>

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
           <button class="create"><a href="create.php">Luo uusi</a></button>
           <button class="create"><a href="users.php">Takaisin</a></button>
            <button class="logout"><a href="logout.php">Kirjaudu ulos</a></button>
        </div>
    </div>
    <div class="room-header PHP">
        <h1>PHP Room</h1>    
    </div>          
    <div class="discussion-section">
<?php
if(count($allPosts) == 0) {
    echo "<div class='empty-room'><p>Täällä on tyhjää</p></div>";
} else {
foreach ($allPosts as $key => $userPost) {
    $mysqldate = strtotime($userPost['date']);
    $phpdate = date('Y/m/d G:i A', $mysqldate);
    echo "<div class='discussion-wrapper'>
    <div class='discussion'>
    <div class='date'>
        <p class='username'>". $userPost['name'] ."</p>
        <p>". $phpdate ."</p>
    </div>
    <div class='bodytext'><p>" . $userPost['content'] . "</p> </div>
    </div>
</div>";
}}
?>
</div>
