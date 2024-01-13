<?php
// Include your database connection file
include '../database/connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assume that you have stored the user's ID in the session after login
    session_start();
    $userID = $_SESSION['user_id'];

    // Fetch user data based on the user ID
    $sql = "SELECT * FROM users WHERE id = $userID";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        $userData = $result->fetch_assoc();
    } else {
        // Handle the case where the user data is not found
        echo "User not found!";
        exit();
    }

    // Get the new values from the form
    $newUsername = $_POST['username'];
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];
    $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Update the user information in the database
    $updateSql = "UPDATE users SET 
                  username = '$newUsername', 
                  full_name = '$newName', 
                  email = '$newEmail', 
                  password = '$newPassword' 
                  WHERE id = $userID";

    if ($mysqli->query($updateSql)) {
        echo "User information updated successfully!";

        // Redirect back to the same page
        header("Location: {$_SERVER['HTTP_REFERER']}");
    } else {
        echo "Error updating user information: " . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
}
?>
