<?php
session_start();
print_r($_SESSION);
include_once "header.php";
?>

<body>
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <a href="#" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="./src/img/ninja.png" alt="">
                <div class="details">
                <span><?php echo $_SESSION["name"] ?></span>
                <p><?php if($_SESSION["login"] == 1) {
                     echo "online"; }else {
                        echo "offline";
                     } ?></p>
                </div>
            </header>
            <div class="chat-box">
                <div class="chat outgoing">
                    <div class="details">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit.epudie!empore.</p>
                    </div>
                </div>
                <div class="chat incoming">
                    <div class="details">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit.epudie!empore.</p>
                    </div>
                </div>
            </div>
            <form action="#" class="typing-area">
                <input type="text" placeholder="Kirjoita viesti...">
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>

</body>

</html>