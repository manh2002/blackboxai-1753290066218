<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Hanoi Re</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Hanoi Re - Admin Dashboard</h1>
        </div>
        
        <nav class="admin-nav">
            <ul>
                <li><a href="index.php" class="active">Dashboard</a></li>
                <li><a href="category.php">Categories</a></li>
                <li><a href="pages/add_post.php">Add Post</a></li>
                <li><a href="pages/edit_post.php">Manage Posts</a></li>
                <li><a href="user_login.php">User Management</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        
        <div class="admin-content">
            <h2>Dashboard Overview</h2>
            
            <div class="admin-stats">
                <div class="stat-card">
                    <h3>25</h3>
                    <p>Total Posts</p>
                </div>
                <div class="stat-card">
                    <h3>8</h3>
                    <p>Categories</p>
                </div>
                <div class="stat-card">
                    <h3>156</h3>
                    <p>Page Views</p>
                </div>
                <div class="stat-card">
                    <h3>3</h3>
                    <p>Admin Users</p>
                </div>
            </div>
            
            <h3>Recent Activity</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Action</th>
                        <th>User</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2025-01-23</td>
                        <td>Post Created</td>
                        <td>Admin</td>
                        <td>New insurance policy article</td>
                    </tr>
                    <tr>
                        <td>2025-01-22</td>
                        <td>Category Added</td>
                        <td>Admin</td>
                        <td>Risk Management category</td>
                    </tr>
                    <tr>
                        <td>2025-01-21</td>
                        <td>User Login</td>
                        <td>Admin</td>
                        <td>Dashboard access</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
