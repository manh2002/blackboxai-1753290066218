<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$message = '';

// Handle form submission for adding new user
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'add') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? '';
    
    if (!empty($username) && !empty($email)) {
        // In a real application, you would insert into database with proper password hashing
        $message = 'User "' . htmlspecialchars($username) . '" added successfully!';
    }
}

// Sample users data (in production, fetch from database)
$users = [
    ['id' => 1, 'username' => 'admin', 'email' => 'admin@hanoire.com', 'role' => 'Administrator', 'last_login' => '2025-01-23 10:30:00'],
    ['id' => 2, 'username' => 'editor', 'email' => 'editor@hanoire.com', 'role' => 'Editor', 'last_login' => '2025-01-22 14:15:00'],
    ['id' => 3, 'username' => 'viewer', 'email' => 'viewer@hanoire.com', 'role' => 'Viewer', 'last_login' => '2025-01-21 09:45:00'],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Hanoi Re Admin</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>User Management</h1>
        </div>
        
        <nav class="admin-nav">
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="category.php">Categories</a></li>
                <li><a href="pages/add_post.php">Add Post</a></li>
                <li><a href="pages/edit_post.php">Manage Posts</a></li>
                <li><a href="user_login.php" class="active">User Management</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        
        <div class="admin-content">
            <?php if ($message): ?>
                <div style="background: #d4edda; color: #155724; padding: 0.75rem; border-radius: 5px; margin-bottom: 1rem;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
                <div>
                    <h2>Add New User</h2>
                    <form method="POST" class="form-admin">
                        <input type="hidden" name="action" value="add">
                        
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select id="role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="Administrator">Administrator</option>
                                <option value="Editor">Editor</option>
                                <option value="Viewer">Viewer</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn-admin success">Add User</button>
                    </form>
                </div>
                
                <div>
                    <h2>Existing Users</h2>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Last Login</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <span style="background: #4285f4; color: white; padding: 0.25rem 0.5rem; border-radius: 3px; font-size: 0.8rem;">
                                        <?php echo htmlspecialchars($user['role']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($user['last_login']); ?></td>
                                <td>
                                    <button class="btn-admin">Edit</button>
                                    <?php if ($user['username'] !== 'admin'): ?>
                                        <button class="btn-admin danger">Delete</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
