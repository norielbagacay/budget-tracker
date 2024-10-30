<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Budget Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="card text-center">
  <div class="card-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Budget Tracker</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="?pg=home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?pg=budget">Budget</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?pg=expenses">Expenses</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?pg=savings">Savings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?pg=logout">Logout</a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
  <div class="card-body">
    <?php
      if(isset($_GET['pg'])) {
        $pg = $_GET['pg'];
        switch($pg) {
          case "home":
            include "page/home.php";
            break;
          case "budget":
            include "page/create_budget.php";
            break;
          case "expenses":
            include "page/expenses.php";
            break;
          case "savings":
            include "page/savings.php";
            break;
            case "logout":
              include "login/logout.php";
              break;
          default:
            include "page/expenses.php";						
        }
      }
    ?>
  </div>
  <div class="card-footer text-muted">
    Developer: Noriel Bagacay
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
