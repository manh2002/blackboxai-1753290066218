<?php
session_start();
require_once '../../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit();
}

$message = '';

// Handle form submission for editing
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'edit_post') {
    $post_id = $_POST['post_id'] ?? '';
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    
    if (!empty($post_id) && !empty($title)) {
        // In a real application, you would update the database
        $message = 'Post updated successfully!';
    }
}

// Handle delete action
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'delete_post') {
    $post_id = $_POST['post_id'] ?? '';
    if (!empty($post_id)) {
        // In a real application, you would delete from database
        $message = 'Post deleted successfully!';
    }
}

// Sample posts data (in production, fetch from database)
$posts = [
    [
        'id' => 1,
        'title' => 'Understanding Facultative Reinsurance',
        'category' => 'Facultative Reinsurance',
        'status' => 'published',
        'created_at' => '2025-01-20',
        'author' => 'Admin'
    ],
    [
        'id' => 2,
        'title' => 'Treaty Reinsurance Best Practices',
        'category' => 'Treaty Reinsurance',
        'status' => 'published',
        'created_at' => '2025-01-18',
        'author' => 'Editor'
    ],
    [
        'id' => 3,
        'title' => 'Risk Engineering in Modern Insurance',
        'category' => 'Risk Engineering',
        'status' => 'draft',
        'created_at' => '2025-01-15',
        'author' => 'Admin'
    ],
    [
        'id' => 4,
        'title' => 'Q4 2024 Financial Report',
        'category' => 'Financial Reports',
        'status' => 'published',
        'created_at' => '2025-01-10',
        'author' => 'Admin'
    ],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts - Hanoi Re Admin</title>
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Manage Posts</h1>
        </div>
        
        <nav class="admin-nav">
            <ul>
                <li><a href="../index.php">Dashboard</a></li>
                <li><a href="../category.php">Categories</a></li>
                <li><a href="add_post.php">Add Post</a></li>
                <li><a href="edit_post.php" class="active">Manage Posts</a></li>
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
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h2>All Posts</h2>
                <a href="add_post.php" class="btn-admin success">Add New Post</a>
            </div>
            
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Author</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($post['title']); ?></strong>
                        </td>
                        <td><?php echo htmlspecialchars($post['category']); ?></td>
                        <td>
                            <span style="background: <?php echo $post['status'] === 'published' ? '#28a745' : ($post['status'] === 'draft' ? '#ffc107' : '#6c757d'); ?>; color: white; padding: 0.25rem 0.5rem; border-radius: 3px; font-size: 0.8rem;">
                                <?php echo ucfirst($post['status']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($post['author']); ?></td>
                        <td><?php echo htmlspecialchars($post['created_at']); ?></td>
                        <td>
                            <button class="btn-admin" onclick="editPost(<?php echo $post['id']; ?>)">Edit</button>
                            <button class="btn-admin" onclick="viewPost(<?php echo $post['id']; ?>)">View</button>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                <input type="hidden" name="action" value="delete_post">
                                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                <button type="submit" class="btn-admin danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div style="margin-top: 2rem; text-align: center;">
                <button class="btn-admin">Previous</button>
                <span style="margin: 0 1rem;">Page 1 of 3</span>
                <button class="btn-admin">Next</button>
            </div>
        </div>
    </div>
    
    <!-- Edit Post Modal (simplified) -->
    <div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 2rem; border-radius: 8px; width: 90%; max-width: 600px;">
            <h3>Edit Post</h3>
            <form method="POST">
                <input type="hidden" name="action" value="edit_post">
                <input type="hidden" name="post_id" id="editPostId">
                
                <div class="form-group">
                    <label for="editTitle">Title:</label>
                    <input type="text" id="editTitle" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="editContent">Content:</label>
                    <textarea id="editContent" name="content" style="min-height: 200px;"></textarea>
                </div>
                
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="button" class="btn-admin" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn-admin success">Update Post</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function editPost(postId) {
            // In a real application, you would fetch post data via AJAX
            document.getElementById('editPostId').value = postId;
            document.getElementById('editTitle').value = 'Sample Post Title';
            document.getElementById('editContent').value = 'Sample post content...';
            document.getElementById('editModal').style.display = 'block';
        }
        
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
        
        function viewPost(postId) {
            // In a real application, you would redirect to post view
            alert('View post functionality - Post ID: ' + postId);
        }
        
        // Close modal when clicking outside
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>
</body>
</html>
