<?php
// Include your database connection file
include '../../database/connection.php';

// Assume that you have stored the user's ID in the session after login
session_start();
$userID = $_SESSION['user_id'];

// Fetch user data based on the user ID
$sql = "SELECT * FROM users WHERE id = $userID";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    // Handle the case where the user data is not found
    echo "User not found!";
    exit();
}

// Fetch the expense details based on the expense ID (passed through URL or form)
if (!empty($_GET['expense_id'])) {
    $expenseID = $_GET['expense_id'];
    $expenseDetailsQuery = "SELECT expenses.*, categories.category_name 
                            FROM expenses 
                            LEFT JOIN categories ON expenses.category_id = categories.category_id
                            WHERE expenses.user_id = $userID AND expenses.expense_id = $expenseID";

    $expenseDetailsResult = $mysqli->query($expenseDetailsQuery);

    if ($expenseDetailsResult && $expenseDetailsResult->num_rows > 0) {
        $expenseDetails = $expenseDetailsResult->fetch_assoc();
    } else {
        echo "Expense not found!";
        exit();
    }

    // Fetch attachments for the expense
    $attachmentsQuery = "SELECT * FROM attachments WHERE expense_id = $expenseID";
    $attachmentsResult = $mysqli->query($attachmentsQuery);

    if ($attachmentsResult && $attachmentsResult->num_rows > 0) {
        $attachments = $attachmentsResult->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/icon-1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>SpendWise</title>
</head>
<body>

  <div class="container-fluid">
    <header class="d-flex justify-content-between align-items-center py-3">
      <div class="logo d-flex align-items-center">
        <img src="../icons/icon7.svg" alt="Bell Icon" class="me-2">
        <h1 class="m-0">Expense Manager</h1>
      </div>
      <div class="user-actions">
        <button class="btn btn-light">
          <img src="../icons/icon6.svg" alt="Bell Icon">
        </button>
        <button class="btn btn-light" onclick="window.location.href='../../auth/logout.php'">
            <img src="../icons/icon5.svg" alt="Logout Icon">
        </button>
      </div>
    </header>

    <div class="d-flex">
      <nav class="nav flex-column" style="width: 13%;">
        <a class="nav-link active" href="../dashboard/welcome.php">
          <img src="../icons/icon1.svg" alt="Dashboard Icon"> Dashboard
        </a>
        <a class="nav-link" href="../expenses/welcome.php">
          <img src="../icons/icon2.svg" alt="Expenses Icon"> Expenses
        </a>
        <a class="nav-link" href="../categories/welcome.php">
          <img src="../icons/icon10.svg" alt="Categories Icon"> Categories
        </a>
        <a class="nav-link" href="../reports/welcome.php">
          <img src="../icons/icon3.svg" alt="Reports Icon"> Reports
        </a>
        <a class="nav-link" href="../user-settings/welcome.php">
          <img src="../icons/icon4.svg" alt="User Settings Icon"> User Settings
        </a>
      </nav>

      <div class="main-content col-md-8">
        <?php if (!empty($attachments)): ?>
          <div class="mb-3">
              <ul>
                  <?php foreach ($attachments as $attachment): ?>
                      <?php
                      $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                      $fileExtension = pathinfo($attachment['file_path'], PATHINFO_EXTENSION);
                      if (in_array(strtolower($fileExtension), $imageExtensions)):
                      ?>
                          <ul>
                              <img class="mt-3" src="../<?php echo $attachment['file_path']; ?>" alt="Attachment <?php echo $attachment['attachment_id']; ?>" style="max-width: 80%; height: 90%;">
                      </ul>
                      <?php endif; ?>
                  <?php endforeach; ?>
              </ul>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>
