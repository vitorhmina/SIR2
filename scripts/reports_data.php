<?php
include '../database/connection.php';

// Fetch expenses data for the last month
$startDate = date('Y-m-d', strtotime('-1 month'));
$endDate = date('Y-m-d');

$expensesDataQuery = "SELECT date, SUM(amount) as total_amount
                      FROM expenses
                      WHERE user_id = $userID AND date BETWEEN '$startDate' AND '$endDate'
                      GROUP BY date
                      ORDER BY date";

$expensesDataResult = $mysqli->query($expensesDataQuery);

if ($expensesDataResult && $expensesDataResult->num_rows > 0) {
    $expensesData = $expensesDataResult->fetch_all(MYSQLI_ASSOC);
} else {
    $expensesData = [];
}

echo json_encode($expensesData);
?>
