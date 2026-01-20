<?php
require_once 'config.php';

// login check
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

// id check
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];

// fetch post
$stmt = $conn->prepare("SELECT * FROM posts WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
    die("Post not found");
}

// access check (admin OR owner)
if (!isAdmin() && $_SESSION['user']['id'] != $post['user_id']) {
    die("Access Denied");
}

$error = "";

// ✅ UPDATE LOGIC
if (isset($_POST['update'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if ($title == "" || $content == "") {
        $error = "All fields are required";
    } else {
        $stmt = $conn->prepare(
            "UPDATE posts SET title=?, content=? WHERE id=?"
        );
        $stmt->bind_param("ssi", $title, $content, $id);

        if ($stmt->execute()) {
            header("Location: view_post.php?id=".$id);
            exit;
        } else {
            $error = "Post not updated";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#d2b48c;">

<div class="container mt-5">
    <div class="card p-4">
        <h3 class="text-center">Edit Post</h3>

        <?php if ($error != ""): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="title"
                   class="form-control mb-3"
                   value="<?php echo e($post['title']); ?>" required>

            <textarea name="content"
                      class="form-control mb-3"
                      rows="5" required><?php echo e($post['content']); ?></textarea>

            <!-- ✅ NAME MUST BE update -->
            <button type="submit" name="update"
                    class="btn btn-dark w-100">
                Update Post
            </button>
        </form>
    </div>
</div>

</body>
</html>










