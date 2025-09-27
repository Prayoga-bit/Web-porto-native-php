<?php
session_start();

// Ambil error dari session (kalau ada)
$nameErr = $_SESSION['nameErr'] ?? '';
$usernameErr = $_SESSION['usernameErr'] ?? '';
$passwordErr = $_SESSION['passwordErr'] ?? '';
$successMsg = $_SESSION['success'] ?? '';

unset($_SESSION['nameErr'], $_SESSION['usernameErr'], $_SESSION['passwordErr'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <base href="/">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
    <div class="main-container container d-flex justify-content-center column-gap-3 align-items-center ">
        <div id="formWrapper" class="form-container d-flex flex-column justify-content-center row-gap-3 px-5">
            <h3 class="web-title">Yoojimin</h3>
            <h2 class="title">Welcome to <br> My Portfolio Website</h2>
            <p class="description">Portfolio website of Prayoga Agus Setiawan in major of <br> information system with nim 2304140072</p>

            <form id="authForm" class="d-flex flex-column row-gap-3" action="process/login_process.php" method="post">
                <input id="nameField" style="display: none;" class="input-field" type="text" name="fullname" placeholder="Full Name">
                <span id="nameErr" style="display: none;" class="error"><?php echo htmlspecialchars("$nameErr");?></span>

                <input class="input-field" type="text" name="username" placeholder="Username">
                <span class="error"><?php echo htmlspecialchars("$usernameErr");?></span>

                 <div class="password-wrapper" style="position: relative;">
                    <input id="passwordField" class="input-field" type="password" name="password" placeholder="NIM">
                    <i class="fa-solid fa-eye" id="togglePassword"
                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                </div>
                <span class="error"><?php echo htmlspecialchars("$passwordErr");?></span>

                <div class="remember" id="rememberField">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>

                <button id="formButton" class="button-form" type="submit">Login</button>
            </form>

            <p class="mt-5 text-center" id="formText" class="form-text">
                Doesn't have an account? 
                <a href="#" onclick="toggleForm('signup', event)">Sign up</a>
            </p>

        </div>

        <div class="slider-wrapper">
            <div class="slider">
                <img src="img/karina aespa.jpg" alt="Karina Aespa">
                <img src="img/karina.jpg" alt="Karina Aespa">
            </div>

            <div class="slider-control d-flex justify-content-evenly">
                <div class="circle"></div>
                <div class="slider-title">
                    My Kisah
                </div>
                <div class="button-control d-flex column-gap-2 justify-content-center align-items-center position-absolute">
                    <i class="fa-solid fa-arrow-left back-navigation"></i>
                    <i class="fa-solid fa-arrow-right next-navigation"></i>
                </div>

                <div class="slider-description">
                    See me and my kisah by clicking on the <br> navigation button
                </div>

                <div class="slider-index">

                </div>
            </div>
        </div>
    </div>

    <script type="module" src="js/main.js"></script>
    <script src="js/login.js"></script>
</body>
</html>