<?php
include '../database/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Other validations and checks...

    // Get expense_id and category from the form
    $expenseID = $_POST['expense_id'];
    $selectedCategory = $_POST['category'];

    // Check if the selected category is an empty string and handle it accordingly
    if ($selectedCategory === "") {
        $categoryID = null; // Set category_id to NULL
    } else {
        $categoryID = $selectedCategory;
    }

    // Your SQL query to update the category
    $updateQuery = "UPDATE expenses SET category_id = ? WHERE expense_id = ?";

    // Prepare the statement
    $stmt = $mysqli->prepare($updateQuery);

    // Bind parameters
    $stmt->bind_param("ii", $categoryID, $expenseID);

    // Execute the statement
    if ($stmt->execute()) {
        // Success
        echo "Category updated successfully!";

        header("Location: {$_SERVER['HTTP_REFERER']}");

    } else {
        // Error
        echo "Error updating category: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();

    // Close the database connection
    $mysqli->close();
} else {
    // Handle the case where the form was not submitted
    echo "Invalid request!";
}
?>
