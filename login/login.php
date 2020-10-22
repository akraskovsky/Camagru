<?php
    include "../config/db_connection.php";
    session_start();

    // Came from activation mail
    if (isset($_GET['name']) && isset($_GET['token'])) {
        $check_token = $pdo->prepare('SELECT id FROM users WHERE name LIKE ? AND token LIKE ?');
        $check_token->execute(array($_GET['name'], $_GET['token']));
        $id = $check_token->fetchColumn();
        if ($id) {
            $upd = $pdo->prepare('UPDATE users SET activated = 1 WHERE id = ?');
            $upd->execute(array($id));
            $_SESSION['success'] = "Congratulations! Your account is activated. You may enter now.";
        }
        else {
            $_SESSION['error'] = "Activation error! Please call admin.";
        }
        header('location: login.php');
        return;

    }

    // LOGIN form filled
    if (isset($_POST['username']) && isset($_POST['pass'])) {
        if (strlen($_POST['username']) < 1 || strlen($_POST['pass']) < 1) {
            $_SESSION['error'] = "Please enter both User Name and Password";
            header('location: login.php');
            return;
        }
        $stmt = $pdo->prepare('SELECT id FROM users WHERE name LIKE ? AND password LIKE ?');
        $stmt->execute(array($_POST['username'], hash('whirlpool', $_POST['pass'])));
        if ($id = $stmt->fetchColumn()) {
            $stmt = $pdo->prepare('SELECT activated FROM users WHERE id LIKE ?');
            $stmt->execute(array($id));
            if ($is_activated = $stmt->fetchColumn()) {
                $_SESSION['name'] = $_POST['username'];
                header('location: ../index.php');
                return;
            }
            else {
                $_SESSION['error'] = "Your account is not activated.<br>Please check email from Camagru and follow the link from this mail.";
                header('location: login.php');
                return;
            }
        }
        else {
            $_SESSION['error'] = "Incorrect Name or Password";
            header('location: login.php');
            return;
        }
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
        <?php
            if(isset($_SESSION['success'])) {
                echo('<h2 style="color: indigo;">'.$_SESSION['success']."</h2>\n");
                unset($_SESSION['success']);
            }
            else {
                echo ('<h2>Enter your Account</h2>');
                if(isset($_SESSION['error'])) {
                    echo('<p style="color: red;">'.$_SESSION['error']."</p>\n");
                    unset($_SESSION['error']);
                }
            }
        ?>
        <form method="post">
            <p><input type="text" name="username" placeholder="User Name"></p>
            <p><input type="password" name="pass" placeholder="Password"></p>
            <input type="submit" value="Enter" class="btn">
            <a href="../index.php">Cancel</a   >
        </form>
        <p style="margin: 0;"><br>Forgot password? - <a href="pass_request.php">Request password reset</a></p>
        <p style="margin: 0;"><br>Don't have Account? - <a href="sign_in.php">Register</a></p>
    </div>

</body>
</html>