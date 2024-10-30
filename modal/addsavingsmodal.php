<!-- Add Savings Modal -->
<div class="modal fade" id="addSavingsModal" tabindex="-1" aria-labelledby="addSavingsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSavingsModalLabel">Add Savings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <input type="hidden" name="budget_id" value="<?php echo htmlspecialchars($selected_budget_id); ?>">
                    <div class="mb-3">
                        <label for="savings_category" class="form-label">Category</label>
                        <select id="savings_category" name="savings_category" class="form-select" required>
                            <option value="emergency">Emergency</option>
                            <option value="education">Education</option>
                            <option value="vacation">Vacation</option>
                            <option value="gadget">Gadget</option>
                            <option value="home purchases">Home Purchases</option>
                            <option value="investment">Investment</option>
                            <option value="vehicle">Vehicle</option>
                            <option value="personal">Personal</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="savings_amount" class="form-label">Amount</label>
                        <input type="number" id="savings_amount" name="savings_amount" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="savings_date" class="form-label">Date</label>
                        <input type="date" id="savings_date" name="savings_date" class="form-control" required>
                    </div>
                    <button type="submit" name="add_savings" class="btn btn-success">Add Savings</button>
                </form>
            </div>
        </div>
    </div>
</div>
