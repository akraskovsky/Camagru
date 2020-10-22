<?php
    include "config/db_connection.php";
    session_start();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camagru</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="logo">CAMAGRU</div>
        <div class="username">
            <?php 
                if (isset($_SESSION['name'])) {
                    echo ('<div><a href="login/edit_account.php"><img src="pics/avatar-white.png" height=24></a></div>');
                    echo ('<div><a href="login/edit_account.php">' . htmlentities($_SESSION['name']) . '</a></div>');
                    echo ('<div id="newpic_btn"><a href="webcam/create_img.php">Take new picture</a></div>');
                }
                else {
                    echo ('<a href="login/login.php">LogIn</a>');
                }
            ?>
        </div>
    </header>
</body>
</html>