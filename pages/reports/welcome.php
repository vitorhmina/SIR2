<?php
// Include your database connection file
include '../../database/connection.php';

// Assume that you have stored the user's ID in the session after login
session_start();
$userID = $_SESSION['user_id'];

// Fetch expenses data for the last month
$startDate = date('Y-m-d', strtotime('-1 month'));
$endDate = date('Y-m-d');

$expensesDataQuery = "SELECT date, SUM(amount) as total_amount
                      FROM expenses
                      WHERE user_id = $userID AND date BETWEEN '$startDate' AND '$endDate'
                      GROUP BY date
                      ORDER BY date DESC";

$expensesDataResult = $mysqli->query($expensesDataQuery);

if ($expensesDataResult && $expensesDataResult->num_rows > 0) {
    $expensesData = $expensesDataResult->fetch_all(MYSQLI_ASSOC);
} else {
    $expensesData = [];
}

// Fetch expenses data for the last year
$startDate = date('Y-m-d', strtotime('-1 year'));
$endDate = date('Y-m-d');

$monthlySummaryQuery = "SELECT DATE_FORMAT(date, '%Y-%m') AS month, SUM(amount) AS total_amount
                        FROM expenses
                        WHERE user_id = $userID AND date BETWEEN '$startDate' AND '$endDate'
                        GROUP BY month
                        ORDER BY month DESC";

$monthlySummaryResult = $mysqli->query($monthlySummaryQuery);

if ($monthlySummaryResult && $monthlySummaryResult->num_rows > 0) {
    $monthlySummary = $monthlySummaryResult->fetch_all(MYSQLI_ASSOC);
} else {
    $monthlySummary = [];
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
    <style>
        .bar-graph-container {
            display: flex;
            margin-top: 2rem;
            width: 100%;
        }

        .bar-container, .monthly-summary {
            display: flex;
            flex-direction: column;
        }

        .bar-and-date, .bar-and-month {
        display: flex;
        align-items: flex-end;
        margin-top: 1rem;
        white-space: nowrap;
        }

        .bar, .bar-summary {
            background-color: #007BFF;
            margin-right: 5px;
            height: 20px;
            transition: height 0.5s ease;
        }

        .bar:hover, .bar-summary:hover {
            height: 30px;
        }

        .bar-date, .summary-month {
            text-align: left;
            margin-left: 5px;
        }
    </style>
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

        <div class="reports-container">
            <div class="bar-graph-container">
                <div style="margin-left: 30%;margin-top:2rem;">
                    <h2>Expenses per Day</h2>
                    <div class="bar-container">
                        <?php foreach ($expensesData as $entry): ?>
                            <div class="bar-and-date">
                                <div class="bar" style="width: <?php echo $entry['total_amount'] * 0.5; ?>px;"></div>
                                <div class="bar-date"><?php echo $entry['date']; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="monthly-summary" style="margin-left:50%;margin-top:2rem;">
                    <h2>Monthly Summary</h2>
                    <?php foreach ($monthlySummary as $summary): ?>
                        <div class="bar-and-month">
                            <div class="bar-summary" style="width: <?php echo $summary['total_amount'] *  0.5; ?>px;"></div>
                            <div class="summary-month"><?php echo $summary['month']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

