<?php
    // include "../config/db_connection.php";
    // session_start();
    echo('<p style="color: blue; margin: 0;">entered controller</p>');


    var_dump($_POST);
    var_dump($_SESSION);

    if (isset($_POST['username']) && isset($_POST['mail']) 
        && isset($_POST['pass1']) && isset($_POST['pass2'])) {
            echo('<p style="color: blue; margin: 0;">form submittd</p>');
            // Check for non-empty submission
            if (strlen($_POST['username']) < 1 || strlen($_POST['mail']) < 1 
                || strlen($_POST['pass1']) < 1 || strlen($_POST['pass2']) < 1) {
                
                $_SESSION['error'] = "Please enter ALL fields";
                echo('<p style="color: red; margin: 0;">Please enter ALL fields</p>');
                // header('location: sign_in.php');
                // return;
            }
            // Check for equal pass enterings
            elseif ($_POST['pass1'] !== $_POST['pass2']) {
                $_SESSION['error'] = "Passwords do not match";
                // header('location: sign_in.php');
                // return;
            }
            // Check fpr pass quality: 6+ symbols and upper/lowercase presence
            elseif (strlen($_POST['pass1']) < 6 || strtoupper($_POST['pass1']) === $_POST['pass1'] 
                    || strtolower($_POST['pass1']) === $_POST['pass1']) {
                $_SESSION['error'] = "Password is too simple. It must be at least 6 symbols and have both uppercase and lowercase letters";
                // header('location: sign_in.php');
                // return;
            }
            // Check for existing Username in databese
            else {
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE name LIKE :nm");
                $stmt->bindParam(':nm', $_POST['username']);
                $stmt->execute();
                if ($stmt->fetchColumn() > 0) {
                    $_SESSION['error'] = "This Name already exists. Try another name.";
                    // header('location: sign_in.php');
                    // return;
                }
                else {
                    $stmt = $pdo->prepare('INSERT INTO users(name, mail, password, token) VALUES (:nm, :ml, :pw, :tk)');
                    $stmt->bindParam(':nm', $_POST['username']);
                    $stmt->bindParam(':ml', $_POST['mail']);
                    $stmt->bindParam(':pw', $pwd);
                    $stmt->bindParam(':tk', $token);
                    $pwd = hash('whirlpool', $_POST['pass1']);
                    $token = md5(time());
                    $stmt->execute();

                    $message = 'Please follow the link below in order to confirm your account
                    http://localhost/Camagru/Camagru/index.php?name='.$_POST['username'].'&token='.$token;
                    $headers = 'From: Camagru noreply@camagru.hi';

                    mail($_POST['username'], 'Camagru: verification needed', $message, $headers);

                    $_SESSION['success'] = htmlentities($_POST['username']) . ", your data is recorded.<br>
                        We have sent you verification email.<br>Please follow the link from that mail 
                        in order to activate your account.";
                }
            }
            header('location: sign_in.php');
            return;
    }
