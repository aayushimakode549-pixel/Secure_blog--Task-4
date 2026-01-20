<?php
require_once "config.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];

/* Fetch post owner */
$stmt = $conn->prepare("SELECT user_id, title FROM posts WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
    die("Post not found");
}

/* Access check: only admin or post owner */
if ($_SESSION['user']['role'] != 'admin' && $_SESSION['user']['id'] != $post['user_id']) {
    die("Access Denied");
}

/* Delete post */
$stmt = $conn->prepare("DELETE FROM posts WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
exit;
?>