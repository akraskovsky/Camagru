<?php
    include "../config/db_connection.php";
    session_start();

    if (isset($_POST['mail'])) {
        $stmt = $pdo->prepare('SELECT token FROM users WHERE mail LIKE ?');
        $stmt->execute(array($_POST['mail']));
        $token = $stmt->fetchColumn();
        echo ('token = '.$token);
        if ($token) {
            $message = 'Please follow the link to reset password
            http://localhost/Camagru/Camagru/login/pass_change.php?token='.$token;
            $headers = 'From: Camagru noreply@camagru.hi';
            mail($_POST['mail'], 'Camagru: password reset', $message, $headers);
            $_SESSION['success'] = "Mail with reset link is sent to your address.";
        }
        else {
            $_SESSION['error'] = "There is no user with such e-mail.";
        }
        header('location: pass_request.php');
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
            if(isset($_SESSION['success'])) {
                echo('<p style="color: indigo;">'.$_SESSION['success']."</p>\n");
                unset($_SESSION['success']);
                echo('<button class="btn"><a href="login.php" style="color: white;">OK</a></button>'); 
            }
        ?>
        <form method="post">
            <p><input type="text" name="mail" placeholder="e-mail"></p>
            <input type="submit" value="Request" class="btn">
            <a href="login.php">Cancel</a>
        </form>
    </div>

</body>
</html>