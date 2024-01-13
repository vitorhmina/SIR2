<?php
// Include your database connection file
include '../../database/connection.php';

// Assume that you have stored the user's ID in the session after login
session_start();
$userID = $_SESSION['user_id'];

// Check if category ID is provided in the URL
if (isset($_GET['category_id'])) {
    $categoryID = $_GET['category_id'];

    // Fetch category data based on the category ID
    $categoryQuery = "SELECT * FROM categories WHERE category_id = $categoryID AND user_id = $userID";
    $categoryResult = $mysqli->query($categoryQuery);

    if ($categoryResult && $categoryResult->num_rows > 0) {
        $categoryData = $categoryResult->fetch_assoc();
    } else {
        // Handle the case where the category data is not found
        echo "Category not found!";
        exit();
    }
} else {
    // Redirect to the main page if category ID is not provided
    header("Location: ../categories/welcome.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $categoryName = $_POST['category_name'];
    $color = $_POST['color'];

    // Update category in the database
    $updateCategoryQuery = "UPDATE categories 
                            SET category_name = '$categoryName', color = '$color'
                            WHERE category_id = $categoryID AND user_id = $userID";

    if ($mysqli->query($updateCategoryQuery)) {
        // Category updated successfully, redirect to categories page or display a success message
        header("Location: ../categories/welcome.php");
        exit();
    } else {
        // Handle the case where the update failed
        echo "Error: " . $mysqli->error;
        exit();
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
    <title>Update Category</title>
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

      <div class="main-content col-md-8">
        <form method="post" action="" style="width: 90%;">
            <input type="hidden" name="category_id" value="<?php echo $categoryData['category_id']; ?>">
            
            <div class="mb-3 main"  style="margin-top: 2rem;">
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $categoryData['category_name']; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="color" class="form-label">Color</label>
                <input type="color" class="form-control" id="color" name="color" value="<?php echo $categoryData['color']; ?>" style="width: 90%;" required>
            </div>
            
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update Category</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
