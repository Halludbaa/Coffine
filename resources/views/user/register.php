<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="shortcut icon" href="icon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/styleForm.css">
</head>

<body>
    <img src="img/background-login.jpeg" alt="">
    <div class="form-wrapper">
        <h1>REGISTER</h1>
        <form action="" method="post" id="regForm">
            <div class="note-wrapper">
                <span class="note-user note"></span>
                <input type="text" name="username" id="username" placeholder="Username" required>
            </div>
            <div class="note-wrapper">
                <span class="note-pass note"></span>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <div class="note-wrapper">
                <span class="note-pass note"></span>
                <input type="password" name="confirm_password" id="password" placeholder="Confirm Password" required>
            </div>
            <input type="submit" name="btn-submit" id="btn-submit" value="Register" >
        </form>
    </div>

    <script src="js/regis.js"></script>

</body>

</html>