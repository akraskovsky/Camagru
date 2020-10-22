<?php
    include "../config/db_connection.php";
    session_start();

    if (!isset($_SESSION['name'])) {
        header('location: ../index.php');
        return;
    }
    $stmt = $pdo->prepare('SELECT mail, password, notify FROM users WHERE name LIKE ?');
    $stmt->execute(array($_SESSION['name']));
    $person = $stmt->fetch();
    
    
        // $stmt = $pdo->prepare('SELECT token FROM users WHERE mail LIKE ?');
        // $stmt->execute(array($_POST['mail']));
        // $token = $stmt->fetchColumn();
        // echo ('token = '.$token);

        // header('location: pass_request.php');
        // return;
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
    <div class="logo">CAMAGRU</div>
    <div class="username">
        <?php 
            if (isset($_SESSION['name'])) {
                echo ('<div><a href="edit_account.php"><img src="../pics/avatar-white.png" height=24></a></div>');
                echo ('<div><a href="edit_account.php">' . $_SESSION['name'] . '</a></div>');
            }
            else {
                echo ('<a href="login.php">LogIn</a>');
            }
        ?>
    </div>
</header>

    <div class="container">
        <h2>Edit Account</h2>
        <?php
            if(isset($_SESSION['error'])) {
                echo('<p style="color: red;">'.$_SESSION['error']."</p>\n");
                unset($_SESSION['error']);
            }
            if(isset($_SESSION['success'])) {
                echo('<p style="color: indigo;">'.$_SESSION['success']."</p>\n");
                unset($_SESSION['success']);
            }
        ?>
        <form method="post">
            <p></p><input type="text" name="username" value="<?=$_SESSION['name']?>">
            <input type="submit" value="Update" class="btn"></p>
            </form>

            <form method="post">
            <p><input type="email" name="mail" placeholder="E-mail address">
            <input type="submit" value="Update" class="btn"></p>
            </form>

            <form method="post">
            <p><input type="checkbox" checked name="notify" value="1">Email notifications
            <input type="submit" value="Update" class="btn"></p>
            </form>

            <hr size=3>
            <p>Change password</p>
            <p><input type="password" name="pass" placeholder="Current password"></p>
            <p><input type="password" name="pass1" placeholder="New Password"></p>
            <p><input type="password" name="pass2" placeholder="Confirm new Password">
            <input type="submit" value="Update" class="btn"></p>
            </form>

            <hr size=3>
            <p><button class="btn"><a href="logout.php" style="color: white;">Log Out</a></button></p> 

            <a href="../index.php">Cancel</a>
    </div>

</body>
</html>