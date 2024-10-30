<!-- Edit Savings Modal -->
<div class="modal fade" id="editSavingsModal" tabindex="-1" aria-labelledby="editSavingsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSavingsModalLabel">Edit Savings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSavingsForm" method="post" action="update_savings.php">
                <div class="modal-body">
                    <input type="hidden" name="savings_id" id="editSavingsId">
                    <div class="mb-3">
                        <label for="editSavingsCategory" class="form-label">Category</label>
                        <input type="text" class="form-control" id="editSavingsCategory" name="category" required>
                    </div>
                    <div class="mb-3">
                        <label for="editSavingsAmount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="editSavingsAmount" name="amount" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="editSavingsDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="editSavingsDate" name="date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Savings Modal -->
<div class="modal fade" id="deleteSavingsModal" tabindex="-1" aria-labelledby="deleteSavingsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSavingsModalLabel">Delete Savings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteSavingsForm" method="post" action="delete_savings.php">
                <div class="modal-body">
                    <input type="hidden" name="savings_id" id="deleteSavingsId">
                    <p>Are you sure you want to delete this savings record?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
