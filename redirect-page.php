<?php
session_start();
include_once "header.php";
if (!isset($_SESSION["userid"])) {
    header("location: login.php");
    exit();
}
?>

<body>
    <div class="success">
    <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        <a href="users.php" class="redirect">Takaisin</a>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = 'users.php';
        }, 1000); // 1 sekuntia
    </script>
</body>

</html>