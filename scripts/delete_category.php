<?php
include '../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure that the Category ID is provided in the request
    if (!empty($_POST['category_id'])) {
        $categoryID = $_POST['category_id'];

        // Update expenses to clear the category
        $updateExpensesQuery = "UPDATE expenses SET category_id = NULL WHERE category_id = $categoryID";
        $updateExpensesResult = $mysqli->query($updateExpensesQuery);

        if ($updateExpensesResult !== false) {
            // Now delete the category
            $deleteCategoryQuery = "DELETE FROM categories WHERE category_id = $categoryID";
            $deleteCategoryResult = $mysqli->query($deleteCategoryQuery);

            if ($deleteCategoryResult) {
                echo "Category deleted successfully";
                header("Location: /spendwise/pages/categories/welcome.php");
                exit();
            } else {
                echo "Error deleting category: " . $mysqli->error;
            }
        } else {
            echo "Error updating expenses: " . $mysqli->error;
        }
    } else {
        echo "Category ID not provided";
    }
} else {
    echo "Invalid request method";
}
?>
