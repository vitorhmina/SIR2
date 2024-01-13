<?php
                    include '../database/connection.php';

                    function verification($mysqli, $username, $email) {
                        $username = mysqli_real_escape_string($mysqli, $username);
                        $email = mysqli_real_escape_string($mysqli, $email);

                        $sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
                        $result = $mysqli->query($sql);

                        return $result->num_rows > 0;
                    }

                    function register($mysqli, $username, $password, $name, $email) {
                        $username = mysqli_real_escape_string($mysqli, $username);
                        $email = mysqli_real_escape_string($mysqli, $email);

                        if (verification($mysqli, $username, $email)) {
                            $error = array();

                            if (verification($mysqli, $username, '')) {
                                $error[] = 'username';
                            }

                            if (verification($mysqli, '', $email)) {
                                $error[] = 'email';
                            }

                            return $error;
                        }

                        $password = mysqli_real_escape_string($mysqli, $password);
                        $name = mysqli_real_escape_string($mysqli, $name);

                        // Hash da senha
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                        $sql = "INSERT INTO users (username, password, full_name, email) VALUES ('$username', '$hashedPassword', '$name', '$email')";
                        $result = $mysqli->query($sql);

                        return $result; // Retorna true se o registro foi bem-sucedido
                    }

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $username = $_POST["username"];
                        $password = $_POST["password"];
                        $name = $_POST["name"];
                        $email = $_POST["email"];

                        $result = register($mysqli, $username, $password, $name, $email);

                        if (is_array($result)) {
                            // Erro no registro, indicar quais campos já estão em uso
                            if (in_array('username', $result) && in_array('email', $result)) {
                                echo '<p style="color: white; font-weight: bold;" class="error">Erro no registro. O username e o email já estão em uso. Tente novamente.</p>';
                            } elseif (in_array('username', $result)) {
                                echo '<p style="color: white; font-weight: bold;" class="error">Erro no registro. O username já está em uso. Tente novamente.</p>';
                            } elseif (in_array('email', $result)) {
                                echo '<p style="color: white; font-weight: bold;" class="error">Erro no registro. O email já está em uso. Tente novamente.</p>';
                            }
                        } else {
                            // Registo bem-sucedido, redireciona para a home page
                            echo '<script>window.location.replace("/spendwise/auth/login.php");</script>';
                            exit();
                        }
                    }
                    ?>
 
 <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Register</title>    
    <link href="style.css" rel="stylesheet" type="text/css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <style>
        @import url(../pages/images/clash-display.css);

        body {
            font-family: 'Clash Display', sans-serif;
            background: url('../pages/images/hero-1.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            height: auto;
            width: auto;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            text-align: center;
        }

        .form-title {
            margin-top: 5rem;
            font-size: 35px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
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
        display: block;
        margin: auto;
        }   


        .btn-primary:hover {
            background-color: #D5CCC3;
            border-color: #D5CCC3;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
            <h2 class="form-title">Spendwise</h2>
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

