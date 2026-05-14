<?php
session_start();

include 'config/db.php';

$sql = "SELECT * FROM posts ORDER BY created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
   
    <title>All Posts</title>
</head>
<body>

<h2>All Blog Posts</h2>

<a href="posts/create.php">Create New Post</a>

<hr>

<?php

if($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {

        echo "<h3>" . $row['title'] . "</h3>";

        echo "<p>" . $row['content'] . "</p>";

        echo "<small>" . $row['created_at'] . "</small>";

        echo "<br><br>";

        echo "<a href='posts/edit.php?id=".$row['id']."'>Edit</a>";

        echo "<br><br>";

        echo "<a href='posts/delete.php?id=".$row['id']."'>Delete</a>";

        echo "<hr>";
    }

} else {

    echo "No Posts Found!";
}
?>

</body>
</html>