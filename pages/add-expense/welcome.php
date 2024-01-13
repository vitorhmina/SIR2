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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/icon-1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Create Expense</title>
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
      <!-- Sidebar -->
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

      <!-- Main Content -->
      <div class="main-content col-md-8">
          <form method="post" action="../../scripts/create_expense.php" style="width: 90%;" enctype="multipart/form-data">
              
              <div class="mb-3 main"  style="margin-top: 2rem;">
                  <label for="description" class="form-label">Description</label>
                  <input type="text" class="form-control" id="description" name="description" required>
              </div>
              <div class="mb-3">
                  <label for="amount" class="form-label">Amount</label>
                  <input type="number" class="form-control" id="amount" name="amount" required>
              </div>
              <div class="mb-3">
                  <label for="date" class="form-label">Date</label>
                  <input type="date" class="form-control" id="date" name="date" required>
              </div>
              <div class="mb-3">
                  <label for="payment_method" class="form-label">Payment Method</label>
                  <input type="text" class="form-control" id="payment_method" name="payment_method" required>
              </div>
              <div class="mb-3">
                  <label for="paid" class="form-check-label">Paid</label>
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="paid" name="paid">
                  </div>
              </div>
              <label for="attachments">Attachments:</label>
              <input type="file" name="attachments" id="attachments" multiple accept="image/*">
              <div class="text-center mt-3">
                  <button type="submit" class="btn btn-primary">Create Expense</button>
              </div>
          </form>
      </div>
    </div>
  </div>
</body>
</html>
