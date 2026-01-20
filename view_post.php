<?php
include 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM posts WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

include 'header.php';
?>

<div class="card p-4">
    <h2><?php echo $post['title']; ?></h2>
    <p><?php echo nl2br($post['content']); ?></p>
    <a href="index.php" class="btn btn-secondary mt-3">Back</a>
</div>

<?php include 'footer.php'; ?>


