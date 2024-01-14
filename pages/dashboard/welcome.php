<?php
// Include your database connection file
include '../../database/connection.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or handle accordingly
    header("Location: ../../auth/login.php");
    exit();
}

// Get the user ID from the session
$userID = $_SESSION['user_id'];

// Function to get the total expenses value
function getTotalExpenses($mysqli, $userID) {
    $sql = "SELECT SUM(amount) AS total FROM expenses WHERE user_id = $userID";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    return 0; // Return 0 if no expenses or an error occurred
}

// Function to get today's expenses value
function getTodayExpenses($mysqli, $userID) {
  $today = date('Y-m-d');
  $sql = "SELECT SUM(amount) AS total FROM expenses WHERE user_id = $userID AND DATE(date) = '$today'";
  $result = $mysqli->query($sql);

  if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row['total'];
  }

  return 0; // Return 0 if no expenses or an error occurred
}

// Function to get this week's expenses value
function getThisWeekExpenses($mysqli, $userID) {
  $startOfWeek = date('Y-m-d', strtotime('monday this week'));
  $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
  $sql = "SELECT SUM(amount) AS total FROM expenses WHERE user_id = $userID AND DATE(date) BETWEEN '$startOfWeek' AND '$endOfWeek'";
  $result = $mysqli->query($sql);

  if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row['total'];
  }

  return 0; // Return 0 if no expenses or an error occurred
}

// Function to get this month's expenses value
function getThisMonthExpenses($mysqli, $userID) {
  $startOfMonth = date('Y-m-01');
  $endOfMonth = date('Y-m-t');
  $sql = "SELECT SUM(amount) AS total FROM expenses WHERE user_id = $userID AND DATE(date) BETWEEN '$startOfMonth' AND '$endOfMonth'";
  $result = $mysqli->query($sql);

  if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row['total'];
  }

  return 0; // Return 0 if no expenses or an error occurred
}

// Function to get the total unpaid expenses value
function getTotalUnpaidExpenses($mysqli, $userID) {
  $sql = "SELECT SUM(amount) AS total FROM expenses WHERE user_id = $userID AND paid = 0";
  $result = $mysqli->query($sql);

  if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row['total'];
  }

  return 0; // Return 0 if no unpaid expenses or an error occurred
}

// Call the functions with the user ID
$totalExpenses = getTotalExpenses($mysqli, $userID);
$todayExpenses = getTodayExpenses($mysqli, $userID);
$thisWeekExpenses = getThisWeekExpenses($mysqli, $userID);
$thisMonthExpenses = getThisMonthExpenses($mysqli, $userID);
$totalUnpaidExpenses = getTotalUnpaidExpenses($mysqli, $userID);
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

      <main class="main-content col-md-8">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Daily Expenses</h2>
                        <p class="card-text">$<?php echo number_format($todayExpenses, 2); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Weekly Expenses</h2>
                        <p class="card-text">$<?php echo number_format($thisWeekExpenses, 2); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Monthly Expenses</h2>
                        <p class="card-text">$<?php echo number_format($thisMonthExpenses, 2); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Total Expenses</h2>
                        <p class="card-text">$<?php echo number_format($totalExpenses, 2); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </div>
  </div>
</body>
</html>
