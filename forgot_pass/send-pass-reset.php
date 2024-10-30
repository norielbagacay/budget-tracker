<?php
session_start(); // Start the session

$email = $_POST["email"];

$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

include '../db/database.php';

// Ensure your table has the columns reset_token_hash and reset_token_expires_at
$sql = "UPDATE user SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $token_hash, $expiry, $email);
$stmt->execute();

if ($stmt->affected_rows === 0) {
    // Email not found or update failed, store error message in session and redirect
    $_SESSION['error'] = 'Email not found';
    header('Location: forgot-password.php');
    exit();
}


$mail = require __DIR__ . "/mailer.php";
$mail->setFrom("sample@gmail.com", "Forgot Pass");
$mail->addAddress($email);
$mail->Subject = "Password Reset";

$mail->Body = <<<END
<html>
<head>
    <style>
        /* Add some styles if needed */
        body { font-family: Arial, sans-serif; }
        .container { padding: 20px; }
        .header { font-size: 24px; color: #333; }
        .content { font-size: 16px; }
        .footer { font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Password Reset Request</div>
        <div class="content">
            <p>Hi,</p>
            <p>We received a request to reset your password. You can reset it using the link below:</p>
            <p><a href="http://localhost/budget_tracker/forgot_pass/reset-pass.php?token=$token">Reset your password</a></p>
            <p>If you did not request a password reset, please ignore this email.</p>
        </div>
        <div class="footer">
            <p>Thank you,<br>The Team</p>
        </div>
    </div>
</body>
</html>
END;

try {
    if ($mail->send()) {
      
        $_SESSION['success'] = 'Password reset link has been sent to your email.';
    } else {
        
        $_SESSION['error'] = 'Message could not be sent. Mailer error: ' . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    $_SESSION['error'] = 'Message could not be sent. Mailer error: ' . $mail->ErrorInfo;
}


header('Location: success_message.php');
exit();
?>
