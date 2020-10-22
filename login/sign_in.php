<?php
    session_start();
    include "../config/db_connection.php";
    // include '../controllers/sign_in_controller.php';

    if (isset($_POST['username']) && isset($_POST['mail']) 
        && isset($_POST['pass1']) && isset($_POST['pass2'])) {
            // Check for non-empty submission
            if (strlen($_POST['username']) < 1 || strlen($_POST['mail']) < 1 
                || strlen($_POST['pass1']) < 1 || strlen($_POST['pass2']) < 1) {
                
                $_SESSION['error'] = "Please enter ALL fields";
                header('location: sign_in.php');
                return;
            }
            // Check e-mail
            if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Incorrect e-mail format. Please retype.";
                header('location: sign_in.php');
                return;
            }
            // Check for equal pass enterings
            if ($_POST['pass1'] !== $_POST['pass2']) {
                $_SESSION['error'] = "Passwords do not match";
                header('location: sign_in.php');
                return;
            }
            // Check pass quality: 6+ symbols and upper/lowercase presence
            if (strlen($_POST['pass1']) < 6 || strtoupper($_POST['pass1']) === $_POST['pass1'] 
                    || strtolower($_POST['pass1']) === $_POST['pass1']) {
                $_SESSION['error'] = "Password is too simple. It must be at least 6 symbols and have both uppercase and lowercase letters";
                header('location: sign_in.php');
                return;
            }
            // Check for existing Username in databese
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE name LIKE :nm");
            $stmt->bindParam(':nm', $_POST['username']);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                $_SESSION['error'] = "This Name already exists. Try another name.";
                header('location: sign_in.php');
                return;
            }
            // Check for existing e-mail in databese
            $stmt = $pdo->prepare("SELECT mail FROM users WHERE mail LIKE :ml");
            $stmt->bindParam(':ml', $_POST['mail']);
            $stmt->execute();
            if ($stmt->fetchColumn()) {
                $_SESSION['error'] = "User with this email already exists. Try another mail.";
                header('location: sign_in.php');
                return;
            }
            
            $stmt = $pdo->prepare('INSERT INTO users(name, mail, password, token) VALUES (:nm, :ml, :pw, :tk)');
            $stmt->bindParam(':nm', $_POST['username']);
            $stmt->bindParam(':ml', $_POST['mail']);
            $stmt->bindParam(':pw', $pwd);
            $stmt->bindParam(':tk', $token);
            $pwd = hash('whirlpool', $_POST['pass1']);
            $token = md5(time());
            $stmt->execute();

            $message = 'Please follow the link below in order to activate your account
            http://localhost/Camagru/Camagru/login/login.php?name='.$_POST['username'].'&token='.$token;
            $headers = 'From: Camagru noreply@camagru.hi';

            mail($_POST['mail'], 'Camagru: activation needed', $message, $headers);

            $_SESSION['success'] = htmlentities($_POST['username']) . ", your data is recorded.<br>
                We have sent you verification email.<br>Please follow the link from that mail 
                in order to activate your account.<br>";
            header('location: sign_in.php');
            return;
    }
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
                echo ('<div><a href="../webcam/create_img.php">Take new picture</a></div>');
            }
            else {
                echo ('<a href="login.php">LogIn</a>');
            }
        ?>
    </div>
</header>

    <div class="container">
        <h2>Create an Account</h2>
        <?php
            if(isset($_SESSION['error'])) {
                echo('<p style="color: red; margin: 0;">'.($_SESSION['error'])."</p>\n");
                unset($_SESSION['error']);
            }
            if(isset($_SESSION['success'])) {
                echo('<p style="color: indigo; margin: 0;">'.($_SESSION['success'])."</p>\n");
                unset($_SESSION['success']);
                echo('<button class="btn"><a href="../index.php" style="color: white;">OK</a></button>'); 
            }
            // else {
            //     echo('<p style="color: blue; margin: 0;">no errors in SESSION</p>');
            // }
        ?>
        <form action="sign_in.php" method="post">
            <p><input type="text" name="username" placeholder="User Name"></p>
            <p><input type="email" name="mail" placeholder="E-mail address"></p>
            <p><input type="password" name="pass1" placeholder="Password"></p>
            <p><input type="password" name="pass2" placeholder="Confirm Password"></p>
            <input type="submit" value="Register" class="btn"/>
            <a href="../index.php">Cancel</a   >
        </form>
        <p><br>Already have an Account? - <a href="login.php">Log In</a></p>
    </div>

</body>
</html>