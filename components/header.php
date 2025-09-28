<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/conn.php';

$username = $_SESSION['username'] ?? 'Guest';
$nama_lengkap = $_SESSION['nama_lengkap'] ?? '';
$photo = null;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT username, nama_lengkap, foto FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $username = $user['username'];
        $nama_lengkap = $user['nama_lengkap'];
        $photo = $user['foto'];
    }
}
?>

<!-- Start of header -->
<nav class="navbar navbar-expand-lg fixed-top shadow-sm">
  <div class="container d-flex justify-content-between align-items-center">

    <!-- Toggler untuk mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Nav Links + Profile -->
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <!-- Brand -->
      <a class="navbar-brand" href="index.php">Yoojimin</a>

      <!-- Nav Links -->
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#whatIDo">What I Do</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
      </ul>

      <!-- Profile -->
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
            <!-- Foto user atau icon default -->
            <?php if ($photo): ?>
              <img src="uploads/<?php echo htmlspecialchars($photo); ?>" alt="profile"
                  class="rounded-circle"
                  style="width: 45px; height: 45px; object-fit: cover; margin-right: 8px;">
            <?php else: ?>
              <i class="fa-solid fa-user me-2"></i>
            <?php endif; ?>
            Hello, <?php echo htmlspecialchars($username); ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item d-flex align-items-center" href="settings.php">
                <i class="fa-solid fa-gear me-2"></i> Settings
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
              </a>
            </li>
          </ul>
        </li>
      </ul>

    </div>
  </div>
</nav>
<!-- End of Header -->