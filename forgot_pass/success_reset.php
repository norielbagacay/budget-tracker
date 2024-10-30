<?php
session_start(); // Start the session

// Ensure the session message is set
if (!isset($_SESSION['success_reset'])) {
    header('Location: process-reset-pass.php');
    exit();
}

$successMessage = htmlspecialchars($_SESSION['success_reset']);
unset($_SESSION['success_reset']); // Clear the success message
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Success</title>
 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?php echo $successMessage; ?>',
                confirmButtonText: 'Continue'
            }).then((result) => {
                if (result.isConfirmed) {
                 
                    window.location.href = '../login/login.php';
                }
            });
        });

        
    </script>
</body>
</html>
