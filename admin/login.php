<?php
session_start();
require_once '../config/database.php';

$error_message = '';

if ($_POST) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Simple authentication (in production, use proper password hashing)
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: index.php');
        exit();
    } else {
        $error_message = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Hanoi Re</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="hero" style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">
        <div class="login-container">
            <div class="login-header">
                <h2>Admin Login</h2>
                <p>Hanoi Re Administration Panel</p>
            </div>
            
            <?php if ($error_message): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 0.75rem; border-radius: 5px; margin-bottom: 1rem;">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn-login-form">Login</button>
            </form>
            
            <div style="text-align: center; margin-top: 1rem; font-size: 0.9rem; color: #666;">
                <p>Default credentials: admin / admin123</p>
            </div>
        </div>
    </div>
</body>
</html>
