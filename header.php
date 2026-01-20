<?php
include 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Blog App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* New blue shade */
        .navbar {
            background-color: #1e3a8a !important; /* dark blue */
        }
        .navbar-brand,
        .navbar-nav .nav-link {
            color: #ffffff !important;
            font-weight: 500;
        }
        .navbar-nav .nav-link:hover {
            color: #facc15 !important; /* yellow hover */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">

        <a class="navbar-brand" href="index.php">
            <img src="assets/logo.png" height="35"> Blog App
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">

            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
            </ul>

            <!-- SEARCH POST -->
            <form class="d-flex me-3" method="get" action="index.php">
                <input class="form-control form-control-sm me-2"
                       type="search" name="search" placeholder="Search post">
                <button class="btn btn-warning btn-sm text-dark" type="submit">Search</button>
            </form>

            <div>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="create_post.php" class="btn btn-success btn-sm">+ New Post</a>
                    <a href="logout.php" class="btn btn-danger btn-sm ms-2">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-light btn-sm text-dark">Login</a>
                    <a href="register.php" class="btn btn-warning btn-sm ms-2 text-dark">Register</a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</nav>

<div class="container mt-4">


