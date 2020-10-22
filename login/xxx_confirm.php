<?php
    // include "../config/db_connection.php";
    session_start();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camagru</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">CAMAGRU</div>
        </div>
    </header>

    <div class="container">
        <?php
            if(isset($_SESSION['success'])) {
                echo('<p style="color: indigo;">'.$_SESSION['success']."</p>\n");
                unset($_SESSION['success']);
            }
        ?>
        <button class="btn"><a href="../index.php" style="color: white">OK</a></button> 
        <!-- < class="btn"><a href="../index.php">OK</a></и>  -->
    </div>

</body>
</html>