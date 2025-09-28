<?php
session_start();

// jika sudah login langsung redirect ke index
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

$errors = $_SESSION['error'] ?? [];
$success = $_SESSION['success'] ?? '';
$mode = $_SESSION['form_mode'] ?? 'login';

// reset agar pindah form nggak bawa error lama
unset($_SESSION['error'], $_SESSION['success']);
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

            <form id="authForm" class="d-flex flex-column row-gap-3" 
                action="process/<?= $mode === 'signup' ? 'signup_process.php' : 'login_process.php' ?>" method="post">

                <!-- Fullname hanya di signup -->
                <input id="nameField" style="<?= $mode === 'signup' ? '' : 'display:none;' ?>" 
                    class="input-field" type="text" name="fullname" placeholder="Full Name"
                    value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>">
                <?php if ($mode === 'signup' && isset($errors['fullname'])): ?>
                    <span class="error"><?= htmlspecialchars($errors['fullname']) ?></span>
                <?php endif; ?>

                <!-- Username -->
                <input class="input-field" type="text" name="username" placeholder="Username"
                    value="<?= htmlspecialchars($_COOKIE['username'] ?? ($_POST['username'] ?? '')) ?>">
                <?php if (isset($errors['username'])): ?>
                    <span class="error"><?= htmlspecialchars($errors['username']) ?></span>
                <?php endif; ?>

                <!-- Password -->
                <div class="password-wrapper" style="position: relative;">
                    <input id="passwordField" class="input-field" type="password" name="password" placeholder="NIM"
                        value="<?= htmlspecialchars($_COOKIE['password'] ?? ($_POST['password'] ?? '')) ?>">
                    <i class="fa-solid fa-eye" id="togglePassword"
                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                </div>
                <?php if (isset($errors['password'])): ?>
                    <span class="error"><?= htmlspecialchars($errors['password']) ?></span>
                <?php endif; ?>

                <!-- Remember me hanya di login -->
                <div class="remember" id="rememberField" style="<?= $mode === 'login' ? '' : 'display:none;' ?>">
                    <input type="checkbox" id="remember" name="remember" <?= isset($_COOKIE['username']) ? 'checked' : '' ?>>
                    <label for="remember">Remember me</label>
                </div>

                <!-- General error / success -->
                <?php if (isset($errors['general'])): ?>
                    <span class="error"><?= htmlspecialchars($errors['general']) ?></span>
                <?php endif; ?>
                <?php if ($success): ?>
                    <span class="success"><?= htmlspecialchars($success) ?></span>
                <?php endif; ?>

                <button id="formButton" class="button-form" type="submit">
                    <?= $mode === 'signup' ? 'Sign Up' : 'Login' ?>
                </button>
            </form>

            <p class="mt-5 text-center"  id="formText">
                <?php if ($mode === 'signup'): ?>
                    Already have an account? <a href="#" onclick="toggleForm('login', event)">Login</a>
                <?php else: ?>
                    Doesn't have an account? <a href="#" onclick="toggleForm('signup', event)">Sign up</a>
                <?php endif; ?>
            </p>

        </div>

        <div class="slider-wrapper">
            <div class="slider">
                <img src="img/karina-prada.jpg" alt="Karina Aespa">
                <img src="img/mykisah-karina.jpeg" alt="Karina Aespa">
                <img src="img/karina-cakep.jpg" alt="Karina Aespa">
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