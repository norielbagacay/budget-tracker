<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once '../db/database.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password against the hashed password in the database
        if (password_verify($password, $user['pass'])) {
            // Regular user login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            header("Location: ../dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid username or password!";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid username or password!";
        header("Location: login.php");
        exit();
    }
}
?>
