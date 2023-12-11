<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Expense Manager</title>
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
        <button class="btn btn-light">
          <img src="../icons/icon5.svg" alt="Logout Icon">
        </button>
      </div>
    </header>

    <div class="main-content">
      <nav class="nav flex-column min-vh-100">
        <a class="nav-link" href="#">
          <img src="../icons/icon1.svg" alt="Dashboard Icon"> Dashboard
        </a>
        <a class="nav-link" href="#">
          <img src="../icons/icon2.svg" alt="Expenses Icon"> Expenses
        </a>
        <a class="nav-link" href="#">
          <img src="../icons/icon3.svg" alt="Reports Icon"> Reports
        </a>
        <a class="nav-link" href="#">
          <img src="../icons/icon4.svg" alt="User Settings Icon"> User Settings
        </a>
      </nav>

      <main class="mt-3">
        <div class="row">
          <div class="col-md-3 mb-4">
            <div class="card">
              <div class="card-body">
                <h2 class="card-title">Total Expenses</h2>
                <p class="card-text">$1,234.56</p>
              </div>
            </div>
          </div>

          <div class="col-md-3 mb-4">
            <div class="card">
              <div class="card-body">
                <h2 class="card-title">Today's Expenses</h2>
                <p class="card-text">$123.45</p>
              </div>
            </div>
          </div>

          <div class="col-md-3 mb-4">
            <div class="card">
              <div class="card-body">
                <h2 class="card-title">This Week's Expenses</h2>
                <p class="card-text">$678.90</p>
              </div>
            </div>
          </div>

          <div class="col-md-6 mb-4">
            <div class="card">
              <div class="card-body">
                <h2 class="card-title">This Month's Expenses</h2>
                <p class="card-text">$789.01</p>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
