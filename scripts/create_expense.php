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

        // Check if an image file was uploaded
        if (!empty($_FILES['expense_image']['name'])) {
            // Specify the directory where you want to save the images
            $uploadDirectory = '../images/';
            
            // Generate a unique name for the image file
            $imageName = $expenseID . '_' . basename($_FILES['expense_image']['name']);
            
            // Construct the complete file path
            $filePath = $uploadDirectory . $imageName;

            // Move the uploaded file to the destination folder
            if (move_uploaded_file($_FILES['expense_image']['tmp_name'], $filePath)) {
                // Insert a record in the attachments table
                $insertAttachmentQuery = "INSERT INTO attachments (expense_id, file_path) VALUES ($expenseID, '$filePath')";
                
                if (!$mysqli->query($insertAttachmentQuery)) {
                    // Handle the case where the insertion of attachment failed
                    echo "Error inserting attachment: " . $mysqli->error;
                }
            } else {
                // Handle the case where file upload failed
                echo "Error uploading file.";
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
