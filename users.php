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
            <button class="logout"><a href="logout.php">Kirjaudu ulos</a></button>
        </div>
    </div>
    <div class="home">
        <div class="wrapper">
            <section class="users">

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
            <div class="room python">
            <h1>Python Room</h1>
            </div>
            <div class="room PHP">
            <h1>PHP Room</h1>
            </div>
            <div class="room C">
            <h1>C# Room</h1>
            </div>
        </div>
        <script src="js/timeout.js"></script>
        <script>
            $('.room.python').on('click', () => {
                location.href = 'room-1.php'
            });

            $('.room.PHP').on('click', () => {
                location.href = 'room-2.php'
            });

            $('.room.C').on('click', () => {
                location.href = 'room-3.php'
            });

            
        </script>
</body>

</html>