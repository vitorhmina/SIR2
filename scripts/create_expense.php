<?php
// Include your database connection file
include '../database/connection.php';

// Assume that you have stored the user's ID in the session after login
session_start();
$userID = $_SESSION['user_id'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $categoryID = !empty($_POST['category']) ? $_POST['category'] : 'NULL'; // Handle empty category
    $paymentMethod = $_POST['payment_method'];
    $paid = isset($_POST['paid']) ? 1 : 0;

    // Insert new expense into the database
    $insertExpenseQuery = "INSERT INTO expenses (user_id, description, amount, `date`, category_id, payment_method, paid) 
                       VALUES ($userID, '$description', $amount, '$date', $categoryID, '$paymentMethod', $paid)";

    if ($mysqli->query($insertExpenseQuery)) {
        // Expense added successfully, redirect to expenses page or display a success message
        header("Location: ../pages/expenses/welcome.php");
        exit();
    } else {
        // Handle the case where the insertion failed
        echo "Error: " . $mysqli->error;
        exit();
    }
}


// Redirect to the main page if the form was not submitted
header("Location: ../expenses/welcome.php");
exit();
?>
