<?php
session_start();
date_default_timezone_set('Europe/Helsinki');
include_once "header.php";
include "classes/database.php";
include "classes/users-classes.php";
if(!isset($_SESSION["login"])) {
    header("location: login.php");
    exit(); 
}
?>

<body>
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <div class="details">
                <span><?php echo $_SESSION["name"] ?></span>
                <p><?php if($_SESSION["login"] == 1) {
                     echo "Online"; 
                    }else {
                        echo "Offline";
                     } ?></p>
                </div>
            </header>
            <div class="chat-box">
                <div class="chat outgoing">
                    <div class="details">
                    </div>
                    <div class="Message sent">
                    </div>
                </div>
                <div class="chat incoming">
                    <div class="details">
                    </div>
                    <div class="Message sent">   
                    </div>
                </div>
            </div>
            <form action="#" class="typing-area">
                <input type="text"  id="send" placeholder="Kirjoita viesti...">
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>
</body>

</html>