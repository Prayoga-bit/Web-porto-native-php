<?php
session_start();
require_once "../config/conn.php";

// Ambil input
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? ''); // di sini password = NIM
$remember = isset($_POST['remember']);

// Validasi input kosong
if (empty($username) || empty($password)) {
    $_SESSION['error'] = "Username dan NIM wajib diisi!";
    header("Location: ../login.php");
    exit;
}

try {
    // Cek user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND nim = :nim");
    $stmt->execute(['username' => $username, 'nim' => $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Remember Me → simpan cookie 7 hari
        if ($remember) {
            setcookie("remember_user", $user['username'], time() + (7 * 24 * 60 * 60), "/");
        }

        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['error'] = "Username atau NIM salah!";
        header("Location: ../login.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Terjadi kesalahan server!";
    header("Location: ../login.php");
    exit;
}
