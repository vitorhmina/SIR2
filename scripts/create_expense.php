<?php
// Include your database connection file
include '../database/connection.php';

// Assume that you have stored the user's ID in the session after login
session_start();
$userID = $_SESSION['user_id'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $description = $mysqli->real_escape_string($_POST['description']);
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $categoryID = !empty($_POST['category']) ? $_POST['category'] : 'NULL'; // Handle empty category
    $paymentMethod = $mysqli->real_escape_string($_POST['payment_method']);
    $paid = isset($_POST['paid']) ? 1 : 0;

    // Insert new expense into the database
    $insertExpenseQuery = "INSERT INTO expenses (user_id, description, amount, `date`, category_id, payment_method, paid) 
                       VALUES ($userID, '$description', $amount, '$date', $categoryID, '$paymentMethod', $paid)";

    if ($mysqli->query($insertExpenseQuery)) {
        // Expense added successfully, get the ID of the inserted expense
        $expenseID = $mysqli->insert_id;

        // Handle file uploads
        if (!empty($_FILES['attachments']['name'][0])) {
            $uploadDir = 'uploads/'; // Change this to your desired upload directory
            $copyDir = '../pages/images/'; // Change this to the directory where you want to save a copy

            foreach ($_FILES['attachments']['name'] as $key => $fileName) {
                $uploadFile = $uploadDir . basename($fileName);
                $copyFile = $copyDir . basename($fileName); // Create a copy file path

                if (move_uploaded_file($_FILES['attachments']['tmp_name'][$key], $uploadFile)) {
                    // Insert the file path into the attachments table
                    $insertAttachmentQuery = "INSERT INTO attachments (expense_id, file_path)
                                              VALUES ($expenseID, '$uploadFile')";

                    $insertAttachmentResult = $mysqli->query($insertAttachmentQuery);

                    if (!$insertAttachmentResult) {
                        echo "Error inserting attachment: " . $mysqli->error;
                    }

                    // Save a copy to another directory
                    copy($uploadFile, $copyFile);
                } else {
                    echo "Error uploading file: " . $_FILES['attachments']['error'][$key];
                }
            }
        }

        // Redirect to expenses page or display a success message
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
