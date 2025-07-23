<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$message = '';

// Handle form submission for adding new category
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'add') {
    $category_name = $_POST['category_name'] ?? '';
    $category_description = $_POST['category_description'] ?? '';
    
    if (!empty($category_name)) {
        // In a real application, you would insert into database
        $message = 'Category "' . htmlspecialchars($category_name) . '" added successfully!';
    }
}

// Sample categories data (in production, fetch from database)
$categories = [
    ['id' => 1, 'name' => 'Facultative Reinsurance', 'description' => 'Individual risk coverage', 'posts' => 5],
    ['id' => 2, 'name' => 'Treaty Reinsurance', 'description' => 'Portfolio coverage', 'posts' => 8],
    ['id' => 3, 'name' => 'Risk Engineering', 'description' => 'Risk assessment services', 'posts' => 3],
    ['id' => 4, 'name' => 'Financial Reports', 'description' => 'Company financial information', 'posts' => 12],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management - Hanoi Re Admin</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Category Management</h1>
        </div>
        
        <nav class="admin-nav">
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="category.php" class="active">Categories</a></li>
                <li><a href="pages/add_post.php">Add Post</a></li>
                <li><a href="pages/edit_post.php">Manage Posts</a></li>
                <li><a href="user_login.php">User Management</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        
        <div class="admin-content">
            <?php if ($message): ?>
                <div style="background: #d4edda; color: #155724; padding: 0.75rem; border-radius: 5px; margin-bottom: 1rem;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div>
                    <h2>Add New Category</h2>
                    <form method="POST" class="form-admin">
                        <input type="hidden" name="action" value="add">
                        
                        <div class="form-group">
                            <label for="category_name">Category Name:</label>
                            <input type="text" id="category_name" name="category_name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="category_description">Description:</label>
                            <textarea id="category_description" name="category_description"></textarea>
                        </div>
                        
                        <button type="submit" class="btn-admin success">Add Category</button>
                    </form>
                </div>
                
                <div>
                    <h2>Existing Categories</h2>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Posts</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($category['name']); ?></strong><br>
                                    <small style="color: #666;"><?php echo htmlspecialchars($category['description']); ?></small>
                                </td>
                                <td><?php echo $category['posts']; ?></td>
                                <td>
                                    <button class="btn-admin">Edit</button>
                                    <button class="btn-admin danger">Delete</button>
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
