<?php
    include "../config/db_connection.php";
    session_start();

    if (!isset($_SESSION['token'])) {
        if (isset($_GET['token']) && strlen($_GET['token'] > 0)) {
            $stmt = $pdo->prepare('SELECT token FROM users WHERE token LIKE ?');
            $stmt->execute(array($_GET['token']));
            if (!($token = $stmt->fetchColumn())) {
                // There is no user with such token
                $_SESSION['error'] = "Password reset error. Please contact admin.";
                header('location: login.php');
                return;
            }
            // correct token founded in DB
            $_SESSION['token'] = $token;
        }
        else {
            // There is no GET with token in url.
            $_SESSION['error'] = "Password reset error. Please contact admin.";
            header('location: login.php');
            return;
        }
    }

    if (isset($_POST['pass1']) && isset($_POST['pass2'])) {
        // Check empty or non-equal password submissions
        if (strlen($_POST['pass1']) < 1 || ($_POST['pass1'] !== $_POST['pass2'])) {
            $_SESSION['error'] = "Please repete same new password twice";
            header('location: pass_change.php');
            return;
        }
        // Check pass quality: 6+ symbols and upper/lowercase presence
        if (strlen($_POST['pass1']) < 6 || strtoupper($_POST['pass1']) === $_POST['pass1'] 
                || strtolower($_POST['pass1']) === $_POST['pass1']) {
            $_SESSION['error'] = "Password is too simple. It must be at least 6 symbols and have both uppercase and lowercase letters";
            header('location: pass_change.php');
            return;
        }

        $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE token LIKE ?');
        $stmt->execute(array(hash('whirlpool', $_POST['pass1']), $_GET['token']));
        $_SESSION['success'] = 'Password changed. You can login.';
        header('location: login.php');
        return;
    }
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
        <h2>Password reset</h2>
        <?php
            if(isset($_SESSION['error'])) {
                echo('<p style="color: red;">'.$_SESSION['error']."</p>\n");
                unset($_SESSION['error']);
            }
            // if(isset($_SESSION['success'])) {
            //     echo('<p style="color: indigo;">'.$_SESSION['success']."</p>\n");
            //     unset($_SESSION['success']);
            //     echo('<button class="btn"><a href="login.php" style="color: white;">OK</a></button>'); 
            // }
        ?>
        <form method="post">
            <p><input type="password" name="pass1" placeholder="New password"></p>
            <p><input type="password" name="pass2" placeholder="Repete new password"></p>
            <input type="submit" value="Set" class="btn">
            <a href="login.php">Cancel</a>
        </form>
    </div>

</body>
</html>