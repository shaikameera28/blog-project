<?php
session_start();

include '../config/db.php';

if(!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
}

if(isset($_POST['submit'])) {

    $title = $_POST['title'];

    $content = $_POST['content'];

    $stmt = $conn->prepare(
    "INSERT INTO posts(title, content)
     VALUES(?, ?)"
);

$stmt->bind_param("ss",
                  $title,
                  $content);

if($stmt->execute()) {

     header("Location: ../index.php");   

    } else {

        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Create Post</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center mt-5">

        <div class="col-md-8">

            <div class="card shadow">

                <div class="card-body">

                    <h2 class="mb-4">
                        Create New Post
                    </h2>

                    <form method="POST">

                        <input type="text"
                               name="title"
                               class="form-control mb-3"
                               placeholder="Enter Title"
                               required>

                        <textarea name="content"
                                  class="form-control mb-3"
                                  rows="6"
                                  placeholder="Enter Content"
                                  required></textarea>

                        <button type="submit"
                                name="submit"
                                class="btn btn-success">

                                Create Post

                        </button>

                        <a href="../index.php"
                           class="btn btn-secondary">

                           Back

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>