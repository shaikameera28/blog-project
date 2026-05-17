<?php
session_start();

include 'config/db.php';

$limit = 4;

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$start = ($page - 1) * $limit;

if(isset($_GET['search'])) {

    $search = $_GET['search'];

    $sql = "SELECT * FROM posts
            WHERE title LIKE '%$search%'
            OR content LIKE '%$search%'
            ORDER BY created_at DESC
            LIMIT $start, $limit";

    $count_sql = "SELECT COUNT(*) AS total
                  FROM posts
                  WHERE title LIKE '%$search%'
                  OR content LIKE '%$search%'";

} else {

    $sql = "SELECT * FROM posts
            ORDER BY created_at DESC
            LIMIT $start, $limit";

    $count_sql = "SELECT COUNT(*) AS total
                  FROM posts";
}

$result = $conn->query($sql);

$count_result = $conn->query($count_sql);

$total_posts = $count_result->fetch_assoc()['total'];

$total_pages = ceil($total_posts / $limit);

?>

<!DOCTYPE html>
<html>
<head>

    <title>Blog Project</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
<style>

.card {

    transition: 0.3s;
}

.card:hover {

    transform: scale(1.02);

    box-shadow: 0px 4px 15px rgba(0,0,0,0.2);
}

</style>
</head>

<body class="bg-light">

<div class="container mt-5">
    <h1 class="text-primary mb-4 fw-bold">

    My Blog

</h1>

    <div class="d-flex align-items-center gap-2 mb-4">

    <form method="GET" class="d-flex">

        <input type="text"
               name="search"
               class="form-control me-2"
               placeholder="Search blogs..."
               style="width: 400px;">

        <button class="btn btn-primary"
                type="submit">

            Search

        </button>

    </form>

    <a href="posts/create.php"
       class="btn btn-success">

       Create Post

    </a>

    <a href="auth/logout.php"
       class="btn btn-danger"
       onclick="return confirm('Are you sure you want to logout?')">

       Logout

    </a>

</div>



    <?php

    if($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {

    ?>

        <div class="card mb-4 shadow-sm">

            <div class="card-body">

                <h3 class="card-title">
                    <?php echo $row['title']; ?>
                </h3>

                <p class="card-text">
                    <?php echo $row['content']; ?>
                </p>

                <small class="text-muted">
                    <?php echo $row['created_at']; ?>
                </small>

                <br><br>

                <a href="posts/edit.php?id=<?php echo $row['id']; ?>"
                   class="btn btn-primary btn-sm">
                   Edit
                </a>

                <?php if(isset($_SESSION['role']) &&
          $_SESSION['role'] == 'admin') { ?>

                <a href="posts/delete.php?id=<?php echo $row['id']; ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Are you sure you want to delete this post?')">

                   Delete

                </a>

                <?php } ?>

            </div>

        </div>

    <?php

        }

    } else {

        echo "<div class='alert alert-warning'>
                No Posts Found!
              </div>";
    }

    ?>
<nav>

    <ul class="pagination justify-content-center">

        <?php for($i = 1; $i <= $total_pages; $i++) { ?>

            <li class="page-item">

                <a class="page-link"
                   href="?page=<?php echo $i; ?>">

                   <?php echo $i; ?>

                </a>

            </li>

        <?php } ?>

    </ul>

</nav>

<footer class="bg-dark text-white text-center p-3 mt-5">

    Blog Project © 2026 | Developed by Ameera

</footer>
</body>
</html>