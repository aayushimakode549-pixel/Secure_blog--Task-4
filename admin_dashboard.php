<?php
require_once 'config.php';

if(!isLoggedIn() || !isAdmin()) {
    die("Access Denied");
}

include 'header.php';

// Fetch posts
$stmt = $conn->prepare("SELECT * FROM posts ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Admin Dashboard</h2>
<a href="create_post.php" class="btn btn-success mb-3">Create New Post</a>

<table class="table table-striped table-hover table-dark">
<thead class="table-primary">
<tr>
<th>ID</th>
<th>Title</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= e($row['id']); ?></td>
<td><?= e($row['title']); ?></td>
<td>
<a href="edit_post.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
<a href="delete_post.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this post?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<?php include 'footer.php'; ?>


