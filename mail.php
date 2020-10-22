<?php
$message = 'Please follow the below link';

$headers = array(
    'From' => 'andrei.kraskovsky@gmail.com',
    'host' => 'ssl://smtp.gmail.com',
    'port' => '465',
    'username' => 'andrei.kraskovsky@gmail.com',
    'password' => '06022201'
);
mail('andrei.kraskovsky@gmail.com', 'Verification needed', $message, $headers);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Send Mail</h1>
</body>
</html>