<?php
// Include your database connection file
include '../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission

    // Get the expense ID from the form
    $expenseID = $_POST['expense_id'];

    // Get other form data
    $description = $mysqli->real_escape_string($_POST['description']);
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $categoryID = $_POST['category'];
    $paymentMethod = $mysqli->real_escape_string($_POST['payment_method']);
    $paid = isset($_POST['paid']) ? 1 : 0; // Check if paid checkbox is checked

    // Update the expense in the database
    $updateQuery = "UPDATE expenses 
                    SET 
                        description = '$description',
                        amount = $amount,
                        date = '$date',
                        category_id = $categoryID,
                        payment_method = '$paymentMethod',
                        paid = $paid
                    WHERE expense_id = $expenseID";

    $updateResult = $mysqli->query($updateQuery);

    if ($updateResult) {
        echo "Expense updated successfully!";

        // Redirect back to the same page
        header("Location: /spendwise/pages/expenses/welcome.php");
    } else {
        echo "Error updating expense: " . $mysqli->error;
    }
} else {
    // If the form is not submitted via POST, redirect or handle accordingly
    echo "Invalid request method!";
}
?>
