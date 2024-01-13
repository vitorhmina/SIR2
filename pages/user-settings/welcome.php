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

      <!-- Main Content -->
      <div class="main-content col-md-8">
          <form method="post" action="../../scripts/update_user.php" style="width: 90%;">
              <div class="mb-3 main">
                  <label for="username" class="form-label">New Username</label>
                  <input type="text" class="form-control" id="username" name="username" value="<?php echo $userData['username']; ?>" required>
              </div>
              <div class="mb-3">
                  <label for="name" class="form-label">New Name</label>
                  <input type="text" class="form-control" id="name" name="name" value="<?php echo $userData['full_name']; ?>" required>
              </div>
              <div class="mb-3">
                  <label for="email" class="form-label">New Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="<?php echo $userData['email']; ?>" required>
              </div>
              <div class="mb-3">
                  <label for="password" class="form-label">New Password</label>
                  <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="text-center">
                  <button type="submit" class="btn btn-primary">Update</button>
              </div>
          </form>
      </div>


    </div>
  </div>
</body>
</html>
