<?php
include '../config/db.php';

if(isset($_POST['register'])) {

    $username = $_POST['username'];

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password)
            VALUES ('$username', '$password')";

    if($conn->query($sql) === TRUE) {
       header("Location: login.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Register</title>

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
                        User Registration
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
                                name="register"
                                class="btn btn-success w-100">

                                Register

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>