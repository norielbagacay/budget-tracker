<?php
session_start();
require_once 'db/database.php';

if (!isset($_SESSION['user_id'])) {
    // Redirect if user is not logged in
    header("Location: login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch total savings for each category, filtered by user_id
$query = "
    SELECT category, SUM(amount) AS total_amount
    FROM savings
    WHERE user_id = ?
    GROUP BY category
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$savings_by_category = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Savings Summary</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid mt-5">
    <h1 class="mb-4 text-center">Savings</h1>

    <?php if (!empty($savings_by_category)): ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Total Savings</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($savings_by_category as $savings): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($savings['category']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($savings['total_amount'], 2)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No savings recorded.</p>
    <?php endif; ?>
</div>

</body>
</html>
