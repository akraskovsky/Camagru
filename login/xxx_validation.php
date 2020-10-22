<?php
function validateRegInputs() {
    if (isset($_SESSION['error'])) {
        unset($_SESSION['error']);
    }
    // Check for non-empty submission
    if (strlen($_POST['username']) < 1 || strlen($_POST['mail']) < 1 
        || strlen($_POST['pass1']) < 1 || strlen($_POST['pass2']) < 1) {
        
        $_SESSION['error'] = "Please enter ALL fields";
        return;
    }
    // Check for equal pass enterings
    if ($_POST['pass1'] !== $_POST['pass2']) {
        $_SESSION['error'] = "Passwords do not match";
        return;
    }
    // Check pass quality: 6+ symbols and uppercase/lowercase presence
    if (strlen($_POST['pass1']) < 6 || strtoupper($_POST['pass1']) === $_POST['pass1'] 
            || strtolower($_POST['pass1']) === $_POST['pass1']) {
        $_SESSION['error'] = "Password is too simple. It must be at least 6 symbols and have both uppercase and lowercase letters";
        return;
    }
    // Check for existing Username in databese
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE name LIKE :nm");
    $stmt->bindParam(':nm', $_POST['username']);
    $stmt->execute();
    if ($stmt->fetchColumn() > 0) {
        $_SESSION['error'] = "This Name already exists. Try another name.";
        return;
    }
    return;
}
?>