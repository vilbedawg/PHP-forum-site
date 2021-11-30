<?php
session_start();
include_once "header.php";
if(!isset($_SESSION["login"])) {
    header("location: login.php");
    exit(); 
}
date_default_timezone_set('Europe/Helsinki');
?>

<body>
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <div class="details">
                <span><?php echo $_SESSION["name"] ?></span>
                <p><?php if($_SESSION["login"] == 1) {
                     echo "online"; 
                    }else {
                        echo $_SESSION["login"];
                     } ?></p>
                </div>
            </header>
            <div class="chat-box">
                <div class="chat outgoing">
                    <div class="details">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit.epudie!empore.</p>
                    </div>
                    <div class="Message sent">
                        <p><?php echo date('h:i a', time());; ?></p>
                    </div>
                    
                </div>
                <div class="chat incoming">
                    <div class="details">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit.epudie!empore.</p>
                    </div>
                    <div class="Message sent">
                        <p><?php echo date('h:i a', time());; ?></p>
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

<script src="text/javascript">
    $(document).ready(function(){
        var conn = new WebSocket('ws://localhost:8080');
        conn.onopen = function(e) {
            console.log("Connection established!");
        };

        conn.onmessage = function(e) {
            console.log(e.data);
        };

        $("#send").click(function(){
            var msg = $("#msg").val();
        });
    });
</script>

</html>