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

// Fetch expenses and their categories for the user
$expensesQuery = "SELECT expenses.*, categories.category_name 
                  FROM expenses 
                  LEFT JOIN categories ON expenses.category_id = categories.category_id
                  WHERE expenses.user_id = $userID";

$expensesResult = $mysqli->query($expensesQuery);

// Check if expenses are found
if ($expensesResult && $expensesResult->num_rows > 0) {
    $expenses = $expensesResult->fetch_all(MYSQLI_ASSOC);
} else {
    $expenses = []; // If no expenses found, initialize an empty array
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

      <div class="main-content col-md-8">
        <div style="width: 95%; margin-top:10px;">
          <input type="text" id="searchInput" class="form-control" placeholder="Search..." oninput="searchExpenses()">
        </div>

        <div class="attribute-bar mt-3" style="width: 95%;" >
          <strong style="margin-left: 6rem;">Description</strong>
          <strong style="margin-left: 9rem;">Amount</strong>
          <strong style="margin-left: 5rem;">Date</strong>
          <strong style="margin-left: 6rem;">Category</strong>
          <strong style="margin-left: 4rem;">Payment Method</strong>
          <strong style="margin-left: 3rem;">Paid</strong>
        </div>

        
        <ul class="list-group" style="width: 95%; margin-top: 10px;">
          <?php foreach ($expenses as $expense): ?>
              <li class="list-group-item">
                  <a href="../expense-details/welcome.php?expense_id=<?php echo $expense['expense_id']; ?>">
                  <img class="list-icon" src="../icons/icon2.svg" alt="Expenses Icon">
                  </a>
                  <strong class="description"><?php echo $expense['description']; ?></strong> 
                  <strong class="amount"><?php echo $expense['amount']; ?>$</strong> 
                  <strong class="date"><?php echo $expense['date']; ?></strong> 
                  <form method="post" action="../../scripts/set_expense_category.php">
                    <input type="hidden" name="expense_id" value="<?php echo $expense['expense_id']; ?>">
                    <div class="category-select">
                      <select class="form-select" name="category" onchange="this.form.submit()">
                          <option value="">Select a category</option>
                          <?php
                          $categoriesQuery = "SELECT * FROM categories";
                          $categoriesResult = $mysqli->query($categoriesQuery);

                          if ($categoriesResult && $categoriesResult->num_rows > 0) {
                              while ($category = $categoriesResult->fetch_assoc()) {
                                  $selected = ($category['category_id'] == $expense['category_id']) ? 'selected' : '';
                                  echo "<option value=\"{$category['category_id']}\" {$selected}>{$category['category_name']}</option>";
                              }
                          }
                          ?>
                      </select>
                    </div>
                  </form>
                  <strong class="method"><?php echo $expense['payment_method']; ?></strong> 
                  <strong class="paid"><?php echo $expense['paid'] ? 'Yes' : 'No'; ?></strong>
                  <a href="../share-expense/welcome.php?expense_id=<?php echo $expense['expense_id']; ?>">
                    <img class="share-icon" src="../icons/icon12.svg" alt="Share Icon">
                  </a>
                  <a href="../update-expense/welcome.php?expense_id=<?php echo $expense['expense_id']; ?>">
                    <img class="update-icon" src="../icons/icon9.svg" alt="Update Icon">
                  </a>
                  <form method="post" action="../../scripts/delete_expense.php">
                    <input type="hidden" name="expense_id" value="<?php echo $expense['expense_id']; ?>">
                    <button type="submit" class="delete-icon">
                        <img src="../icons/icon8.svg" alt="Delete Icon">
                    </button>
                  </form>
                </li>
          <?php endforeach; ?>
      </ul>
      </div>
      <a href="../add-expense/welcome.php">
        <img class="add-icon" src="../icons/icon11.svg" alt="Add Icon">
      </a>
    </div>
  </div>

  
</body>
<script>
  function searchExpenses() {
    // Get the input value from the search bar
    var searchInput = document.getElementById('searchInput').value.toLowerCase();

    // Get all list items (expenses) in the ul element
    var expensesList = document.querySelectorAll('.list-group-item');

    // Loop through each list item and check if it matches the search criteria
    expensesList.forEach(function(expense) {
        var description = expense.querySelector('.description').innerText.toLowerCase();
        var method = expense.querySelector('.method').innerText.toLowerCase();

        // Check if the description contains the search input and method matches
        if (description.includes(searchInput) || method.includes(searchInput)) {
            expense.style.display = ''; // Display the item
        } else {
            expense.style.display = 'none'; // Hide the item
        }
    });
}

</script>

</html>
