<?php 
    session_start();
    $username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Expense Manager</title>
</head>
<body>

<div class="container">
  <header>
    <div class="logo">
    <img src="../icons/icon7.svg" alt="Bell Icon">
      <h1>Expense Manager</h1>
    </div>
    <div class="user-actions">
      <button>
        <img src="../icons/icon6.svg" alt="Bell Icon">
      </button>
      <button>
        <img src="../icons/icon5.svg" alt="Logout Icon">
      </button>
      <span></span>
    </div>
  </header>
  <div class="main-content">
    <nav>
      <ul>
        <li><a href="#"><img src="../icons/icon1.svg" alt="Dashboard Icon">Dashboard</a></li>
        <li><a href="#"><img src="../icons/icon2.svg" alt="Expenses Icon">Expenses</a></li>
        <li><a href="#"><img src="../icons/icon3.svg" alt="Reports Icon">Reports</a></li>
        <li><a href="#"><img src="../icons/icon4.svg" alt="User Settings Icon">User Settings</a></li>
      </ul>
    </nav>
    <main>
        <div class="grid-container row">
            <div>
            <h2>Total Expenses</h2>
            <p>$1,234.56</p>
            </div>
            <div>
            <h2>Today's Expenses</h2>
            <p>$123.45</p>
            </div>
            <div>
            <h2>This Week's Expenses</h2>
            <p>$678.90</p>
            </div>
            <div>
            <h2>This Month's Expenses</h2>
            <p>$789.01</p>
            </div>
        </div>
    </main>
  </div>
</div>

</body>
</html>
