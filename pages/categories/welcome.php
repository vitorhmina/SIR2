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

// Fetch user categories
$categoriesQuery = "SELECT * FROM categories WHERE user_id = $userID";
$categoriesResult = $mysqli->query($categoriesQuery);

// Check if categories are found
if ($categoriesResult && $categoriesResult->num_rows > 0) {
    $categories = $categoriesResult->fetch_all(MYSQLI_ASSOC);
} else {
    $categories = []; // If no categories found, initialize an empty array
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
        <h1 class="m-0">Category Manager</h1>
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
        <div style="width: 95%; margin-top:10px;">
          <input type="text" id="searchInput" class="form-control" placeholder="Search..." oninput="searchCategories()">
        </div>

        <div class="attribute-bar mt-3" style="width: 95%;" >
          <strong style="margin-left: 6rem;">Category Name</strong>
        </div>

        <ul class="list-group" style="width: 95%; margin-top: 10px;">
          <?php foreach ($categories as $category): ?>
              <li class="list-group-item">
                  <img class="list-icon" src="../icons/icon10.svg" alt="Categories Icon">
                  <strong style="margin-left: 5rem;"></strong> <?php echo $category['category_name']; ?>
                  <a href="../update-category/welcome.php?category_id=<?php echo $category['category_id']; ?>">
                    <img class="update-icon" src="../icons/icon9.svg" alt="Update Icon">
                  </a>
                  <form method="post" action="../../scripts/delete_category.php">
                    <input type="hidden" name="category_id" value="<?php echo $category['category_id']; ?>">
                    <button type="submit" class="delete-icon">
                        <img src="../icons/icon8.svg" alt="Delete Icon">
                    </button>
                  </form>
              </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <a href="../add-category/welcome.php">
        <img class="add-icon" src="../icons/icon11.svg" alt="Add Icon">
      </a>
    </div>
  </div>
</body>
</html>
