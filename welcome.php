<?php
require_once('connect.php');
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container text-center">
        <h1>Welcome back user: <?php echo $_SESSION['user']['id']; ?></h1>
        <a href="logout.php">Log out</a>.    
    </div>
</body>
</html>