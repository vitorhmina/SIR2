<?php
// Include your database connection file
include '../database/connection.php';

// Assume that you have stored the user's ID in the session after login
session_start();
$userID = $_SESSION['user_id'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $expenseID = $_POST['expense_id'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $categoryID = isset($_POST['category_id']) ? $_POST['category_id'] : null; // Use COALESCE to handle NULL value
    $paymentMethod = $_POST['payment_method'];
    $isPaid = isset($_POST['is_paid']) ? 1 : 0;

    // Update expense in the database using prepared statement
    $updateExpenseQuery = "UPDATE expenses 
                           SET description = ?, amount = ?, date = ?, category_id = ?, 
                           payment_method = ?, paid = ?
                           WHERE expense_id = ? AND user_id = ?";

    $stmt = $mysqli->prepare($updateExpenseQuery);
    
    if ($stmt) {
        $stmt->bind_param("sssssiis", $description, $amount, $date, $categoryID, $paymentMethod, $isPaid, $expenseID, $userID);

        if ($stmt->execute()) {
            // Expense updated successfully, redirect to expenses page or display a success message
            header("Location: ../pages/expenses/welcome.php");
            exit();
        } else {
            // Handle the case where the update failed
            echo "Error: " . $stmt->error;
            exit();
        }

        $stmt->close();
    } else {
        // Handle the case where the prepared statement could not be created
        echo "Error: " . $mysqli->error;
        exit();
    }
}
?>
