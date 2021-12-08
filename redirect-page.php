<?php
session_start();
include_once "header.php";

?>

<body>
    <div class="success">
        <h1>Julkaisu onnistui</h1>
        <h3>Sinut ohjataan takaisin</h3>
        <a href="users.php" class="redirect">Takaisin</a>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = 'users.php';
        }, 1000); // 1 sekuntia
    </script>
</body>

</html>