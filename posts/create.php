<?php
session_start();

include '../config/db.php';

if(!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
}

if(isset($_POST['submit'])) {

    $title = $_POST['title'];

    $content = $_POST['content'];

    $sql = "INSERT INTO posts (title, content)
            VALUES ('$title', '$content')";

    if($conn->query($sql) === TRUE) {

        echo "Post Created Successfully!";

    } else {

        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>

</head>
<body>

<h2>Create New Post</h2>

<form method="POST">

    <input type="text"
           name="title"
           placeholder="Enter Title"
           required><br><br>

    <textarea name="content"
              placeholder="Enter Content"
              required></textarea><br><br>

    <button type="submit"
            name="submit">
            Create Post
    </button>

</form>

</body>
</html>