<?php
session_start();

include 'config/db.php';

$limit = 5;

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

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="text-primary">My Blog</h1>
        
        <form method="GET" class="mb-4">

    <div class="input-group">

        <input type="text"
               name="search"
               class="form-control"
               placeholder="Search posts...">

        <button class="btn btn-dark"
                type="submit">
                Search
        </button>

    </div>

</form>
        <div>

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
<div class="d-flex justify-content-center mt-4">

<?php

for($i = 1; $i <= $total_pages; $i++) {

?>

    <a href="?page=<?php echo $i; ?>"
       class="btn btn-outline-primary me-2">

       <?php echo $i; ?>

    </a>

<?php
}
?>

</div>

</body>
</html>