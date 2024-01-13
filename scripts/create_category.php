<?php
// Include your database connection file
include '../database/connection.php';

// Assume that you have stored the user's ID in the session after login
session_start();
$userID = $_SESSION['user_id'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $categoryName = $_POST['category_name'];
    $color = $_POST['color'];

    // Validate and sanitize input
    $categoryName = mysqli_real_escape_string($mysqli, $categoryName);
    $color = mysqli_real_escape_string($mysqli, $color);

    // Insert new category into the database
    $insertCategoryQuery = "INSERT INTO categories (user_id, category_name, color) 
                            VALUES ($userID, '$categoryName', '$color')";

    if ($mysqli->query($insertCategoryQuery)) {
        // Category added successfully, redirect to categories page or display a success message
        header("Location: ../pages/categories/welcome.php");
        exit();
    } else {
        // Handle the case where the insertion failed
        echo "Error: " . $mysqli->error;
        exit();
    }
}

// Redirect to the main page if the form was not submitted
header("Location: ../categories/welcome.php");
exit();
?>
