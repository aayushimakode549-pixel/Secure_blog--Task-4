<?php
session_start();

/* Database connection */
$conn = new mysqli("localhost", "root", "", "secure_blog_task4");
if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}

/* Helper functions */
function isLoggedIn() {
    return isset($_SESSION['user']);
}
function isAdmin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}
function e($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/* Search */
$search = isset($_GET['search']) ? $_GET['search'] : "";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg,#ccffff,#99ddff);
            font-family: 'Segoe UI', sans-serif;
            min-height:100vh;
        }
        .navbar{
            backdrop-filter: blur(12px);
            background: rgba(255,255,255,0.3) !important;
        }
        .navbar-brand{
            background: rgba(0,0,0,0.15);
            color:#000 !important;
            padding:5px 10px;
            border-radius:5px;
        }
        .nav-link{
            background: rgba(0,0,0,0.1);
            padding:5px 10px;
            border-radius:5px;
            color:#000 !important;
            margin-right:5px;
        }
        .nav-link:hover{
            background: rgba(0,0,0,0.25);
        }
        .container{
            backdrop-filter: blur(12px);
            background: rgba(255,255,255,0.85);
            padding:25px;
            border-radius:20px;
            margin-top:25px;
        }
        .post-glass{
            padding:25px;
            background: rgba(255,255,255,0.85);
            border-radius:20px;
            box-shadow:0 8px 25px rgba(0,0,0,0.25);
            margin-bottom:20px;
            position:relative;
            transition:0.3s;
        }
        .post-glass:hover{
            transform:translateY(-3px);
            box-shadow:0 15px 30px rgba(0,0,0,0.3);
        }
        .post-glass h2{
            background: linear-gradient(45deg,#42a5f5,#8e44ad);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
            font-weight:700;
        }
        .btn-glow{
            background: linear-gradient(45deg,#42a5f5,#8e44ad);
            color:#fff;
            border:none;
            border-radius:10px;
            padding:6px 15px;
            transition:0.3s;
        }
        .btn-glow:hover{
            box-shadow:0 0 15px rgba(66,165,245,0.9);
            transform:translateY(-2px);
        }
        .btn-edit{ background:#ffc107; color:#000; }
        .btn-delete{ background:#ff4d4d; color:#fff; }
        input{
            background: rgba(255,255,255,0.8);
            border:none;
            border-radius:8px;
            padding:8px;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">My Blog</a>

    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <?php if (isAdmin()): ?>
            <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Admin</a></li>
        <?php endif; ?>
      </ul>

      <form class="d-flex me-2" method="get">
        <input class="form-control me-2" type="search" name="search" placeholder="Search"
               value="<?php echo e($search); ?>">
        <button class="btn btn-outline-dark">Search</button>
      </form>

      <?php if (isLoggedIn()): ?>
        <a href="create_post.php" class="btn btn-success me-2">+ Post</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      <?php else: ?>
        <a href="login.php" class="btn btn-primary me-2">Login</a>
        <a href="register.php" class="btn btn-warning">Register</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<div class="container">
<h2 class="text-center mb-4">Welcome to My Blog</h2>

<?php
$sql = "SELECT id,title,content,user_id FROM posts";
if ($search != "") {
    $safe = $conn->real_escape_string($search);
    $sql .= " WHERE title LIKE '%$safe%' OR content LIKE '%$safe%'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0):
while ($post = $result->fetch_assoc()):
?>
<div class="post-glass">
    <h2><?php echo e($post['title']); ?></h2>
    <p><?php echo nl2br(e($post['content'])); ?></p>

    <a href="view_post.php?id=<?php echo $post['id']; ?>" class="btn btn-glow mt-2">Read More</a>

    <?php if (isLoggedIn() && (isAdmin() || $_SESSION['user']['id'] == $post['user_id'])): ?>
        <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-edit mt-2">Edit</a>
        <a href="delete_post.php?id=<?php echo $post['id']; ?>"
           class="btn btn-delete mt-2"
           onclick="return confirm('Delete this post?')">Delete</a>
    <?php endif; ?>
</div>
<?php
endwhile;
else:
    echo "<p>No posts found.</p>";
endif;
?>
</div>

</body>
</html>