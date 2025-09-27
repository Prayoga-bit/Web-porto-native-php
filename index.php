<?php
session_start();
require_once "config/conn.php";

if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_user'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $_COOKIE['remember_user']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
    }
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tugas Bootstrap</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  </head>
  <body>
    <?php include "components/header.php"; ?>

    <main>
      <?php include "components/hero.php"; ?>
      <?php include "components/what-i-do.php"; ?>
    </main>

    <?php include "components/footer.php"; ?>

    <script type="module" src="js/main.js"></script>
  </body>
</html>
