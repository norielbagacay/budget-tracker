<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include '../db/database.php';
  
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
        header("Location: ../login/register.php?error=$error");
        exit();
    }

   
    $encrypted_password = password_hash($password, PASSWORD_BCRYPT);

   
    $checkEmailQuery = "SELECT * FROM user WHERE email = '$email'";
    $checkEmailResult = $conn->query($checkEmailQuery);
    if ($checkEmailResult->num_rows > 0) {
        $error = "Email already exists!";
        header("Location: ../login/register.php?error=$error");
        exit();
    }

    $insertQuery = "INSERT INTO user (name, email, pass) VALUES ('$name', '$email', '$encrypted_password')";
    if ($conn->query($insertQuery) === TRUE) {
     
        header("Location: ../login/login.php");
        exit();
    } else {
        
        $error = "Registration failed. Please try again later.";
        header("Location: ../login/register.php?error=$error");
        exit();
    }
}
?>
