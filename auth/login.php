<?php
include '../database/connection.php';

function authenticateUser($mysqli, $username, $password) {
    $username = mysqli_real_escape_string($mysqli, $username);
    $password = mysqli_real_escape_string($mysqli, $password);

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct
            return $user;
        }
    }

    return null; // Authentication failed
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $user = authenticateUser($mysqli, $username, $password);

    if ($user !== null) {
        // Authentication successful, store user information in session
        session_start();
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];

        // Redirect to the dashboard or any other page after successful login
        header("Location: /spendwise/pages/dashboard/welcome.php");
        exit();
    } else {
        // Authentication failed, display an error message
        $error_message = 'Invalid username or password. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>    
    <link rel="icon" href="../pages/landing-page/assets/images/icon-1.png" type="image/x-icon">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <style>
        @import url(../pages/images/clash-display.css);

        /* Your existing styles go here */
        body {
            font-family: 'Clash Display', sans-serif;
            background: url('../pages/images/hero-1.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            height: auto;
            width: auto;
            
            align-items: center;
            justify-content: center;
        }

        .form-container {
            text-align: center;
        }

        .form-title {
            margin-top: 7rem;
            font-size: 35px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 25px;
            color: white;
            text-align: left;
            display: block;
            margin-bottom: 5px;
        }

        .btn-primary {
            margin-top: 2rem;
            background-color: #453a30;
            border-color: #453a30;
            width: 9rem;
            height: 3rem;
            font-size: 20px;
        }

        .btn-primary:hover {
            background-color: #D5CCC3;
            border-color: #D5CCC3;
        }

        .btn-register {
            margin-left: 1rem;
        }

        .error-message {
            color: white;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 form-container">
                <h2 class="form-title">Spendwise</h2>
                <form method="post" action="./login.php">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="./register.php" class="btn btn-primary btn-register">Register</a>
                </form>
                <?php
                if (isset($error_message)) {
                    echo '<div class="error-message">' . $error_message . '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
