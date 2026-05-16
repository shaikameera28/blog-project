<?php
session_start();

include '../config/db.php';

if(isset($_POST['login'])) {

    $username = $_POST['username'];

    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");

$stmt->bind_param("s", $username);

$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows > 0) {

    $user = $result->fetch_assoc();

     if(password_verify($password, $user['password'])) {

    $_SESSION['user'] = $username;

    $_SESSION['role'] = $user['role'];

    header("Location: ../index.php");

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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center mt-5">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-body">

                    <h2 class="text-center mb-4">
                        User Login
                    </h2>

                    <form method="POST">

                        <input type="text"
                               name="username"
                               class="form-control mb-3"
                               placeholder="Enter Username"
                               required>

                        <input type="password"
                               name="password"
                               class="form-control mb-3"
                               placeholder="Enter Password"
                               required>

                        <button type="submit"
                                name="login"
                                class="btn btn-primary w-100">

                                Login

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>