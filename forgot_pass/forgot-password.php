<?php
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 5% auto;
            padding: 2rem;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-right: 0;
        }
        .form-control {
            border-left: 0;
            border-radius: 0;
        }
        .error {
            color: red;
            margin-bottom: 1rem;
        }
        .send-button {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2 class="text-center">Forgot Password</h2>
            <br>
            <?php 
            if (isset($_SESSION['error'])) {
                $error = htmlspecialchars($_SESSION['error']); 
                echo "<p class='error'>$error</p>";
                unset($_SESSION['error']); 
            }
            ?>
            <form method="post" action="send-pass-reset.php">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <button type="submit" class="btn btn-primary send-button">Send</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
