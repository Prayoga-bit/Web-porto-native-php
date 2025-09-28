<?php
session_start();

// Include database connection
require_once 'config/conn.php';

// Check if user is logged in (adjust this based on your authentication system)
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';
$messageType = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nama_lengkap = trim($_POST['nama_lengkap']);
        $username = trim($_POST['username']);
        
        // Validate input
        if (empty($nama_lengkap) || empty($username)) {
            throw new Exception('Nama lengkap dan username tidak boleh kosong.');
        }
        
        // Check if username already exists (excluding current user)
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
        $stmt->execute([$username, $user_id]);
        if ($stmt->rowCount() > 0) {
            throw new Exception('Username sudah digunakan oleh pengguna lain.');
        }
        
        // Handle avatar upload
        $foto_name = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
            $file_type = $_FILES['foto']['type'];
            $file_size = $_FILES['foto']['size'];
            $max_size = 5 * 1024 * 1024; // 5MB
            
            if (!in_array($file_type, $allowed_types)) {
                throw new Exception('Format file tidak didukung. Gunakan JPG, JPEG, atau PNG.');
            }
            
            if ($file_size > $max_size) {
                throw new Exception('Ukuran file terlalu besar. Maksimal 5MB.');
            }
            
            // Create uploads directory if not exists
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // Generate unique filename
            $file_extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $foto_name = 'avatar_' . $user_id . '_' . time() . '.' . $file_extension;
            $upload_path = $upload_dir . $foto_name;
            
            // Get current photo to delete later
            $stmt = $pdo->prepare("SELECT foto FROM users WHERE id = ?");
            $stmt->execute([$user_id]);
            $current_user = $stmt->fetch(PDO::FETCH_ASSOC);
            $old_foto = $current_user['foto'];
            
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $upload_path)) {
                throw new Exception('Gagal mengupload file.');
            }
            
            // Delete old photo if exists and different
            if ($old_foto && $old_foto !== $foto_name && file_exists($upload_dir . $old_foto)) {
                unlink($upload_dir . $old_foto);
            }
        }
        
        // Update database
        if ($foto_name) {
            $stmt = $pdo->prepare("UPDATE users SET nama_lengkap = ?, username = ?, foto = ? WHERE id = ?");
            $stmt->execute([$nama_lengkap, $username, $foto_name, $user_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET nama_lengkap = ?, username = ? WHERE id = ?");
            $stmt->execute([$nama_lengkap, $username, $user_id]);
        }
        
        $message = 'Profil berhasil diperbarui!';
        $messageType = 'success';
        
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Get current user data
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        header('Location: login.php');
        exit;
    }
} catch (Exception $e) {
    die('Error fetching user data: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/settings.css">
</head>
<body>
    <?php include "components/header.php"; ?>
    <div class="container settings-container">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="profile-sidebar">
                    <a href="#" class="sidebar-item active">
                        <i class="fas fa-user"></i>
                        Profile
                    </a>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="profile-main">
                    <h2 class="profile-title">Profile</h2>
                    
                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($message); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <!-- Avatar Section -->
                        <div class="avatar-section">
                            <div class="mb-3">
                                <?php if ($user['foto'] && file_exists('uploads/' . $user['foto'])): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($user['foto']); ?>" 
                                         alt="Avatar" class="avatar-preview" id="avatarPreview">
                                <?php else: ?>
                                    <div class="avatar-placeholder" id="avatarPlaceholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="file-input-wrapper">
                                <input type="file" name="foto" id="foto" class="file-input" 
                                       accept="image/jpeg,image/jpg,image/png" onchange="previewAvatar(this)">
                                <label for="foto" class="file-input-label">
                                    <i class="fas fa-camera me-2"></i>
                                    Pilih Avatar
                                </label>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">Gunakan 800x800 px (PNG/JPG), Maksimal 5MB</small>
                            </div>
                        </div>
                        
                        <!-- Form Fields -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" 
                                       value="<?php echo htmlspecialchars($user['nama_lengkap']); ?>" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                    <input type="text" class="form-control" id="username" name="username" 
                                           value="<?php echo htmlspecialchars($user['username']); ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-update">
                                <i class="fas fa-save me-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="module" src="js/main.js"></script>
    <script src="js/settings.js"></script>
</body>
</html>