<?php
session_start();
require_once 'db/database.php';

if (!isset($_SESSION['user_id'])) {
    // Redirect if user is not logged in
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle form submission for adding an expense
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_expense'])) {
    $budget_id = $_POST['budget_id'];
    $category = $_POST['category'];
    $expense = $_POST['expense'];
    $date = $_POST['date'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO expenses (user_id, budget_id, category, expense, date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $user_id, $budget_id, $category, $expense, $date);
    $stmt->execute();
    $stmt->close();
    
    // Redirect to avoid resubmission on refresh
    header("Location: ?pg=expenses&budget_id=" . $budget_id);
    exit();
}

// Handle form submission for adding savings
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_savings'])) {
    $budget_id = $_POST['budget_id'];
    $category = $_POST['savings_category'];
    $amount = $_POST['savings_amount'];
    $date = $_POST['savings_date'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO savings (user_id, budget_id, category, amount, date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $user_id, $budget_id, $category, $amount, $date);
    $stmt->execute();
    $stmt->close();

    // Update the budget amount
    $stmt = $conn->prepare("UPDATE budget SET amount = amount - ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("dii", $amount, $budget_id, $user_id);
    $stmt->execute();
    $stmt->close();
    
    // Redirect to avoid resubmission on refresh
    header("Location: ?pg=expenses&budget_id=" . $budget_id);
    exit();
}

// Handle budget selection
$selected_budget_id = isset($_GET['budget_id']) ? $_GET['budget_id'] : 0;

// Fetch all budgets for the dropdown
$stmt = $conn->prepare("SELECT id, type, start_date FROM budget WHERE user_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$budgets = [];
while ($row = $result->fetch_assoc()) {
    $row['start_date'] = (new DateTime($row['start_date']))->format('F j, Y'); 
    $budgets[] = $row;
}
$stmt->close();

// Fetch budget details if a budget is selected
if ($selected_budget_id > 0) {
    $stmt = $conn->prepare("SELECT type, amount, start_date, end_date FROM budget WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $selected_budget_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($type, $amount, $start_date, $end_date);
    $stmt->fetch();
    $stmt->close();

    // Convert start_date and end_date to more readable format
    $start_date = (new DateTime($start_date))->format('F j, Y');
    $end_date = (new DateTime($end_date))->format('F j, Y');

    // Fetch total expenses
    $stmt = $conn->prepare("SELECT SUM(expense) FROM expenses WHERE budget_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $selected_budget_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($total_expenses);
    $stmt->fetch();
    $stmt->close();

    // Calculate remaining budget
    $remaining_budget = $amount - $total_expenses;

    // Fetch current expenses
    $stmt = $conn->prepare("SELECT id, category, expense AS amount, date FROM expenses WHERE budget_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $selected_budget_id, $user_id);
    $stmt->execute();
    $expenses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Fetch current savings
    $stmt = $conn->prepare("SELECT id, category, amount, date FROM savings WHERE budget_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $selected_budget_id, $user_id);
    $stmt->execute();
    $savings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    // Default values if no budget is selected
    $type = $amount = $start_date = $end_date = $remaining_budget = 0;
    $expenses = [];
    $savings = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Expenses and Savings Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid mt-5">
    <h1 class="mb-4 text-center">Budget Tracker</h1>

    <!-- Budget Dropdown -->
    <form method="get" action="" class="mb-4" id="budgetForm">
        <div class="form-group">
            <label for="budget_id" class="form-label">Select Budget</label>
            <select id="budget_id" name="budget_id" class="form-control">
                <option value="">-- Select Budget --</option>
                <?php foreach ($budgets as $budget): ?>
                    <option value="<?php echo htmlspecialchars($budget['id'], ENT_QUOTES, 'UTF-8'); ?>"
                        <?php echo $budget['id'] == $selected_budget_id ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($budget['type'], ENT_QUOTES, 'UTF-8') . ' - ' . htmlspecialchars($budget['start_date'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <script>
        document.getElementById('budget_id').addEventListener('change', function() {
            var selectedValue = this.value;
            if (selectedValue) {
                window.location.href = '?pg=expenses&budget_id=' + encodeURIComponent(selectedValue);
            }
        });
    </script>

    <?php if ($selected_budget_id > 0): ?>
        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Type:</strong> <?php echo htmlspecialchars($type); ?></p>
                <p><strong>Amount:</strong> <?php echo htmlspecialchars($amount); ?></p>
                <p><strong>Start Date:</strong> <?php echo htmlspecialchars($start_date); ?> &nbsp; <strong>End Date:</strong> <?php echo htmlspecialchars($end_date); ?></p>
                <p><strong>Remaining Budget:</strong> <?php echo htmlspecialchars(number_format($remaining_budget, 2)); ?></p>
                
                <!-- Buttons to Open the Modals -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                    Add Expense
                </button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSavingsModal">
                    Add Savings
                </button>
            </div>
        </div>

        <!-- Include Expense and Savings Modals -->
        <?php include 'modal/addexpensemodal.php'; ?>
        <?php include 'modal/addsavingsmodal.php'; ?>

        <h2 class="mt-5">Expenses</h2>
        <?php if (!empty($expenses)): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($expenses as $expense): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($expense['category']); ?></td>
                                <td><?php echo htmlspecialchars(number_format($expense['amount'], 2)); ?></td>
                                <td><?php echo htmlspecialchars((new DateTime($expense['date']))->format('F j, Y')); ?></td>
                                <td>
                                <button class="btn btn-primary editBtn" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $expense['id']; ?>">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update
                                </button>

                                <?php include "modal/editexpensemodal.php"; ?>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No expenses recorded for this budget.</p>
        <?php endif; ?>

        <h2 class="mt-5">Savings</h2>
        <?php if (!empty($savings)): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($savings as $saving): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($saving['category']); ?></td>
                                <td><?php echo htmlspecialchars(number_format($saving['amount'], 2)); ?></td>
                                <td><?php echo htmlspecialchars((new DateTime($saving['date']))->format('F j, Y')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No savings recorded for this budget.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>Please select a budget to view details.</p>
    <?php endif; ?>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
