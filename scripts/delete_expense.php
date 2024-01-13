<?php
include '../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure that the expense ID is provided in the request
    if (!empty($_POST['expense_id'])) {
        $expenseID = $_POST['expense_id'];

        // Delete the expense from the database
        $deleteQuery = "DELETE FROM expenses WHERE expense_id = $expenseID";
        $deleteResult = $mysqli->query($deleteQuery);

        if ($deleteResult) {
            echo "Expense deleted successfully";
            header("Location: /spendwise/pages/expenses/welcome.php");

        } else {
            echo "Error deleting expense: " . $mysqli->error;
        }
    } else {
        echo "Expense ID not provided";
    }
} else {
    echo "Invalid request method";
}
?>
