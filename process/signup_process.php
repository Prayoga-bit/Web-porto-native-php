<?php
session_start();
require_once __DIR__ . '/../config/conn.php';

$_SESSION['error'] = [];
$_SESSION['form_mode'] = 'signup'; // tetap di signup kalau ada error

$fullname = trim($_POST['fullname'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($fullname)) {
    $_SESSION['error']['fullname'] = "Nama lengkap wajib diisi.";
}
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
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);

    if ($stmt->fetch()) {
        $_SESSION['error']['username'] = "Username sudah terdaftar.";
        header("Location: ../login.php");
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO users (username, nim, nama_lengkap) 
                           VALUES (:username, :nim, :nama_lengkap)");
    $stmt->execute([
        'username' => $username,
        'nim' => $password,
        'nama_lengkap' => $fullname
    ]);

    // setelah sukses, balik ke login mode
    $_SESSION['success'] = "Akun berhasil dibuat. Silakan login.";
    $_SESSION['form_mode'] = 'login';
    header("Location: ../login.php");
    exit;

} catch (PDOException $e) {
    $_SESSION['error']['general'] = "DB Error: " . $e->getMessage();
    header("Location: ../login.php");
    exit;
}
