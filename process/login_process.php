<?php
session_start();
require_once __DIR__ . '/../config/conn.php';

$_SESSION['error'] = [];
$_SESSION['form_mode'] = 'login'; // default login mode

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($username)) {
    $_SESSION['error']['username'] = "Username wajib diisi.";
}
if (empty($password)) {
    $_SESSION['error']['password'] = "NIM wajib diisi.";
}

if (!empty($_SESSION['error'])) {
    header("Location: ../login.php");
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND nim = :nim LIMIT 1");
    $stmt->execute(['username' => $username, 'nim' => $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        if (isset($_POST['remember'])) {
            setcookie("username", $username, time() + 86400 * 30, "/");
            setcookie("password", $password, time() + 86400 * 30, "/");
        } else {
            setcookie("username", "", time() - 3600, "/");
            setcookie("password", "", time() - 3600, "/");
        }

        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['error']['general'] = "Username atau NIM salah.";
        header("Location: ../login.php");
        exit;
    }

} catch (PDOException $e) {
    $_SESSION['error']['general'] = "DB Error: " . $e->getMessage();
    header("Location: ../login.php");
    exit;
}
