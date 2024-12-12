<?php

use Hallax\Clone\Services\Hellper;

//  include __DIR__ . '/../components/header.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styleForm.css">
</head>

<body>
    <img src="img/background-login.jpeg" alt="">
    <div class="form-wrapper">
        <h1>LOGIN</h1>
        <form action="/login" method="post" id="loginForm">
            <input type="text" name="username" id="username" placeholder="Username" required>
            <input type="password" name="password" id="password" placeholder="Password" required>

            <div class="action-wrapper">
                <input type="checkbox" name="remindme" id="cookies">
                <label for="cookies">Remind Me Later?</label> <br>
                <span>Have <a href="/register">account?</a></span>
            </div>

            <input type="submit" name="btn-submit" id="btn-submit" value="Submit">
        </form>

        <span class="note" id="note"><?= @$_SESSION['status'] ?></span>
    </div>

    <!-- <script src="js/app.js"></script> -->
    <script src="js/login.js"></script>
</body>

</html>