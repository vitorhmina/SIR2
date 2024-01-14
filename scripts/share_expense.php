<?php
// Include your database connection file
include '../database/connection.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $sharedUser = $_POST["shared_user"];

    // Assuming you have the user_id available (replace with the actual user_id)
    $userId = $_SESSION['user_id']; // Replace this with the actual user_id

    // Assuming you have the expense_id available (replace with the actual expense_id)
    $expenseId = $_POST["expense_id"]; // Replace this with the actual expense_id

    $expenseId = $_POST["expense_id"]; // Replace this with the actual expense_id

// Check if the shared_expense already exists using a prepared statement
$checkSharedExpenseQuery = "SELECT * FROM shared_expenses WHERE user_id = ? AND expense_id = ?";
$stmt_check_shared_expense = $mysqli->prepare($checkSharedExpenseQuery);

if ($stmt_check_shared_expense) {
    // Bind parameters and execute the prepared statement
    $stmt_check_shared_expense->bind_param("ii", $sharedUser, $expenseId);
    $stmt_check_shared_expense->execute();

    // Check the result
    $checkSharedExpenseResult = $stmt_check_shared_expense->get_result();

    if ($checkSharedExpenseResult && $checkSharedExpenseResult->num_rows > 0) {
        // Shared expense already exists, handle accordingly
        echo "Expense is already shared with the selected user.";
    } else {
        // Shared expense does not exist, continue with the logic
    }

    // Close the statement for shared expense
    $stmt_check_shared_expense->close();
} else {
    // Error in preparing the statement
    echo "Error preparing shared expense check statement: " . $mysqli->error;
}


    if ($checkSharedExpenseResult && $checkSharedExpenseResult->num_rows > 0) {
        // Shared expense already exists, handle accordingly
        echo "Expense is already shared with the selected user.";
    } else {
        // Shared expense does not exist, create a new shared expense
        $insertSharedExpenseQuery = "INSERT INTO shared_expenses (user_id, expense_id) VALUES (?, ?)";
        $stmt_insert_shared_expense = $mysqli->prepare($insertSharedExpenseQuery);

        if ($stmt_insert_shared_expense) {
            // Bind parameters and execute the prepared statement
            $stmt_insert_shared_expense->bind_param("ii", $sharedUser, $expenseId);

            if ($stmt_insert_shared_expense->execute()) {
                // Shared expense created successfully
                echo "Expense shared successfully!";
            } else {
                // Error in creating shared expense
                echo "Error sharing expense: " . $stmt_insert_shared_expense->error;
            }

            // Close the statement for shared expense
            $stmt_insert_shared_expense->close();
        } else {
            // Error in preparing the statement
            echo "Error preparing shared expense statement: " . $mysqli->error;
        }
    }
}
?>
