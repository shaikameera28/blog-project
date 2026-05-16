<?php
include '../config/db.php';

$id = $_GET['id'];

$stmt = $conn->prepare(
    "DELETE FROM posts WHERE id=?"
);

$stmt->bind_param("i", $id);

if($stmt->execute()) {

    header("Location: ../index.php");

} else {

    echo "Error deleting post!";
}
?>