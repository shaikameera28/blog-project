<?php
include '../config/db.php';

$id = $_GET['id'];

$sql = "SELECT * FROM posts WHERE id=$id";

$result = $conn->query($sql);

$post = $result->fetch_assoc();

if(isset($_POST['update'])) {

    $title = $_POST['title'];

    $content = $_POST['content'];

    $update_sql = "UPDATE posts
                   SET title='$title',
                       content='$content'
                   WHERE id=$id";

    if($conn->query($update_sql) === TRUE) {

        header("Location: ../index.php");

    } else {

        echo "Error updating post!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>

</head>
<body>

<h2>Edit Post</h2>

<form method="POST">

    <input type="text"
           name="title"
           value="<?php echo $post['title']; ?>"
           required><br><br>

    <textarea name="content"
              required><?php echo $post['content']; ?></textarea><br><br>

    <button type="submit"
            name="update">
            Update Post
    </button>

</form>
</body>
</html>