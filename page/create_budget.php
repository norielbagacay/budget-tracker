<?php
session_start();
require_once 'db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        // Redirect if user is not logged in
        header("Location: login/login.php");
        exit();
    }

    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $start_date = $_POST['start_date'];
    $user_id = $_SESSION['user_id'];  // Get the user ID from the session

    // Calculate end date
    $start = new DateTime($start_date);
    if ($type == 'weekly') {
        $end = $start->modify('+6 days');
    } else {
        $end = $start->modify('last day of this month');
    }
    $end_date = $end->format('Y-m-d');

    // Insert budget into the database
    $stmt = $conn->prepare("INSERT INTO budget (user_id, type, amount, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $user_id, $type, $amount, $start_date, $end_date);
    $stmt->execute();
    $budget_id = $stmt->insert_id;
    $stmt->close();
    
    // Redirect to expenses page
    header("Location: ?pg=expenses&budget_id=" . $budget_id);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Budget Tracker</title>
    <!-- Viewport Meta Tag for Responsive Design -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 400px;
            margin: auto;
            padding: 2rem;
            background: #ffffff;
            border-radius: .5rem;
            box-shadow: 0 0 15px rgba(0,0,0,.1);
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: none;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="form-container">
        <h1 class="text-center mb-4">Create Budget</h1>
        <form method="post" action="">
            <div class="mb-3">
                <label for="type" class="form-label">Budget Type</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" id="amount" name="amount" class="form-control" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
</div>
</body>
</html>
