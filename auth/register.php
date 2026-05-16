<?php
include '../config/db.php';

if(isset($_POST['register'])) {

    $username = $_POST['username'];

    $password = $_POST['password'];

    $error = "";

    if(empty($username) || empty($password)) {

        $error = "All fields are required!";
    }

    elseif(strlen($password) < 6) {

        $error = "Password must be at least 6 characters!";
    }

    else {

        $hashed_password = password_hash($password,
                                         PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users(username, password)
             VALUES(?, ?)"
        );

        $stmt->bind_param("ss",
                          $username,
                          $hashed_password);

        if($stmt->execute()) {

            header("Location: login.php");

        } else {

            echo "Registration Failed!";
        }
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

                    <?php

                    if(!empty($error)) {

                     echo "<div class='alert alert-danger'>
                            $error
                           </div>";
                    }
                    ?>
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
                               minlength="6"
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