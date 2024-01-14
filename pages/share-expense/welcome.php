<?php
// Include your database connection file
include '../../database/connection.php';

// Assume that you have stored the user's ID and expense ID in the session after login
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

// Fetching expense_id based on some criteria (you may modify this based on your logic)
$expenseQuery = "SELECT expense_id, description FROM expenses WHERE user_id = $userID LIMIT 1";
$expenseResult = $mysqli->query($expenseQuery);

if ($expenseResult && $expenseResult->num_rows > 0) {
    $expenseData = $expenseResult->fetch_assoc();
    $expenseID = $expenseData['expense_id'];
} else {
    // Handle the case where no expenses are found
    echo "No expenses found!";
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
            <form method="post" action="../../scripts/share_expense.php" style="width: 90%;">
                <input type="hidden" name="expense_id" value="<?php echo $expenseID; ?>">
                <div class="mb-3">
                    <label for="shared_user" class="form-label">Share with User</label>
                    <select class="form-select" id="shared_user" name="shared_user">
                        <?php
                        // Fetch users to whom the expense can be shared
                        $usersQuery = "SELECT * FROM users WHERE id != $userID";
                        $usersResult = $mysqli->query($usersQuery);

                        if ($usersResult && $usersResult->num_rows > 0) {
                            while ($user = $usersResult->fetch_assoc()) {
                                echo "<option value=\"{$user['id']}\">{$user['username']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Share Expense</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
