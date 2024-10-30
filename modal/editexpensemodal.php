
<?php

include 'db/database.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input

    $expense_id = $_POST['expense_id'];
    $category= $_POST['edit_category'];
    $amount = $_POST['edit_amount'];
    $date = $_POST['edit_date']; 
    

    // Update task in the database with status
    $sql = "UPDATE expenses SET category='$category', expense='$amount', date='$date' WHERE id='$expense_id'";
    
    if ($conn->query($sql) === TRUE) {
      
        exit();
    } else {
        // Error updating task
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>






<!-- editModal.php -->
<div class="modal fade" id="editModal<?php echo $expense['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit Task Form -->
                <form action="" method="POST">
                    <input type="hidden" name="expense_id" value="<?php echo $expense['id']; ?>">
                    <div class="mb-3">
                        <label for="edit_category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="edit_category" name="edit_category" value="<?php echo $expense['category']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_amount" class="form-label">Amount</label>
                        <input type="text" class="form-control" id="edit_amount" name="edit_amount" value="<?php echo $expense['amount']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="edit_date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="edit_date" name="edit_date" value="<?php echo $expense['date']; ?>">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
