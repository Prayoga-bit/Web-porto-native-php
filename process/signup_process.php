<?php
session_start();
require_once "../config/conn.php";

$fullname = trim($_POST['fullname'] ?? '');
$username = trim($_POST['username'] ?? '');
$nim = trim($_POST['password'] ?? ''); // password = NIM

// Validasi input
if (empty($fullname) || empty($username) || empty($nim)) {
    $_SESSION['error'] = "Semua field wajib diisi!";
    header("Location: ../login.php");
    exit;
}

// Pastikan NIM hanya angka
if (!preg_match("/^[0-9]+$/", $nim)) {
    $_SESSION['error'] = "NIM hanya boleh angka!";
    header("Location: ../login.php");
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO users (username, nim, nama_lengkap) VALUES (:username, :nim, :fullname)");
    $stmt->execute([
        'username' => $username,
        'nim' => $nim,
        'fullname' => $fullname
    ]);

    $_SESSION['success'] = "Akun berhasil dibuat. Silakan login.";
    header("Location: ../login.php");
    exit;
} catch (PDOException $e) {
    $_SESSION['error'] = "Username atau NIM sudah terdaftar!";
    header("Location: ../login.php");
    exit;
}
