<?php
session_start();

include '../config/db.php';

if(isset($_POST['login'])) {

    $username = $_POST['username'];

    $password = $_POST['password'];

    $sql = "SELECT * FROM users
            WHERE username='$username'";

    $result = $conn->query($sql);

    if($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])) {

            $_SESSION['user'] = $username;

            echo "Login Successful!";

        } else {

            echo "Wrong Password!";
        }

    } else {

        echo "User Not Found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Login</title>
</head>
<body>

<h2>User Login</h2>

<form method="POST">

    <input type="text"
           name="username"
           placeholder="Enter Username"
           required><br><br>

    <input type="password"
           name="password"
           placeholder="Enter Password"
           required><br><br>

    <button type="submit"
            name="login">
            Login
    </button>

</form>

</body>
</html>