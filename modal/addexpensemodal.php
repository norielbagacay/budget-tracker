<!-- Modal -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExpenseModalLabel">Add Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <input type="hidden" name="budget_id" value="<?php echo htmlspecialchars($selected_budget_id); ?>">
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" id="category" name="category" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="expense" class="form-label">Expense</label>
                        <input type="number" id="expense" name="expense" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" id="date" name="date" class="form-control" required>
                    </div>
                    <button type="submit" name="add_expense" class="btn btn-primary">Add Expense</button>
                </form>
            </div>
        </div>
    </div>
</div>
