<?php
session_start();
require_once '../../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit();
}

$message = '';

// Handle form submission
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'add_post') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $category = $_POST['category'] ?? '';
    $status = $_POST['status'] ?? '';
    
    if (!empty($title) && !empty($content)) {
        // In a real application, you would insert into database
        $message = 'Post "' . htmlspecialchars($title) . '" added successfully!';
    }
}

// Sample categories for dropdown
$categories = [
    'Facultative Reinsurance',
    'Treaty Reinsurance', 
    'Risk Engineering',
    'Financial Reports',
    'Company News'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post - Hanoi Re Admin</title>
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Add New Post</h1>
        </div>
        
        <nav class="admin-nav">
            <ul>
                <li><a href="../index.php">Dashboard</a></li>
                <li><a href="../category.php">Categories</a></li>
                <li><a href="add_post.php" class="active">Add Post</a></li>
                <li><a href="edit_post.php">Manage Posts</a></li>
                <li><a href="../user_login.php">User Management</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
        
        <div class="admin-content">
            <?php if ($message): ?>
                <div style="background: #d4edda; color: #155724; padding: 0.75rem; border-radius: 5px; margin-bottom: 1rem;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="form-admin" style="max-width: 800px;">
                <input type="hidden" name="action" value="add_post">
                
                <div class="form-group">
                    <label for="title">Post Title:</label>
                    <input type="text" id="title" name="title" required placeholder="Enter post title">
                </div>
                
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select id="category" name="category" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="excerpt">Excerpt:</label>
                    <textarea id="excerpt" name="excerpt" placeholder="Brief description of the post" style="min-height: 80px;"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" required placeholder="Write your post content here..." style="min-height: 300px;"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="featured_image">Featured Image URL:</label>
                    <input type="url" id="featured_image" name="featured_image" placeholder="https://example.com/image.jpg">
                </div>
                
                <div class="form-group">
                    <label for="tags">Tags:</label>
                    <input type="text" id="tags" name="tags" placeholder="insurance, reinsurance, risk (comma separated)">
                </div>
                
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="scheduled">Scheduled</option>
                    </select>
                </div>
                
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn-admin success">Add Post</button>
                    <button type="button" class="btn-admin" onclick="window.history.back()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Simple character counter for content
        document.getElementById('content').addEventListener('input', function() {
            const content = this.value;
            const wordCount = content.trim().split(/\s+/).length;
            
            // Create or update word counter
            let counter = document.getElementById('word-counter');
            if (!counter) {
                counter = document.createElement('small');
                counter.id = 'word-counter';
                counter.style.color = '#666';
                this.parentNode.appendChild(counter);
            }
            counter.textContent = `Words: ${wordCount}`;
        });
    </script>
</body>
</html>
