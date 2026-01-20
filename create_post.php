<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$error = "";

if (isset($_POST['create'])) {   // ✅ SAME NAME
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user']['id'];

    if ($title == "" || $content == "") {
        $error = "All fields are required";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("ssi", $title, $content, $user_id);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Post not created";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#d2b48c;">

<div class="container mt-5">
    <div class="card p-4">
        <h3 class="text-center">Create Post</h3>

        <?php if ($error != ""): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="title" class="form-control mb-3"
                   placeholder="Post Title" required>

            <textarea name="content" class="form-control mb-3"
                      placeholder="Post Content" rows="5" required></textarea>

            <!-- ✅ NAME FIXED -->
            <button type="submit" name="create"
                    class="btn btn-dark w-100">
                Create Post
            </button>
        </form>
    </div>
</div>

</body>
</html>
