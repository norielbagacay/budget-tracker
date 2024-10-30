<?php
session_start();
$token = $_POST["token"];

$token_hash = hash("sha256", $token);

include '../db/database.php';

// Prepare and execute the SQL statement
$sql = "SELECT * FROM user WHERE reset_token_hash = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if the token is found and valid
if ($user === null) {
    die("Token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Token has expired");
}

$password = $_POST["password"];
$passwordConfirmation = $_POST["password_confirmation"];

// Password validation
if (strlen($password) < 8) {
    $_SESSION['error'] = 'Password must be at least 8 characters long.';
    header("Location: reset-pass.php?token=$token");
    exit();
}

if (!preg_match("/[a-z]/i", $password)) {
    $_SESSION['error'] = 'Password must contain at least one letter.';
    header("Location: reset-pass.php?token=$token");
    exit();
}


if (!preg_match("/[0-9]/", $password)) {
    $_SESSION['error'] = 'Password must contain at least one number.';
    header("Location: reset-pass.php?token=$token");
    exit();
}

if ($password !== $passwordConfirmation) {
    $_SESSION['error'] = 'Passwords must match.';
    header("Location: reset-pass.php?token=$token");
    exit();
}

// Update the password and reset token
$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE user
        SET pass = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $password_hash, $user["id"]); // Note: changed to "si" to match the integer type for ID
$stmt->execute();


$_SESSION['success_reset'] = 'Password updated. You can now login.';

header('Location: success_reset.php');
exit();