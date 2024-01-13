<?php
// update_category.php

// Include your database connection file
include '../database/connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the expense ID and selected category from the form
    $expenseID = $_POST['expense_id'];
    $selectedCategory = $_POST['category'];

    // Validate inputs if needed

    // Update the category in the database
    $updateQuery = "UPDATE expenses SET category_id = ? WHERE expense_id = ?";
    $stmt = $mysqli->prepare($updateQuery);

    // Bind parameters
    $stmt->bind_param('ii', $selectedCategory, $expenseID);

    // Execute the update query
    if ($stmt->execute()) {
        // Redirect back to the page where the form was submitted
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        echo "Error updating category: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// If the form is not submitted or there's an error, handle accordingly
// ...
?>
