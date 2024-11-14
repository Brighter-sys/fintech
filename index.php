<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fintech Demo</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery and Chart.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container my-4">
    <!-- Currency and Language Selectors -->
    <div class="d-flex justify-content-between mb-3">
        <!-- Currency Selector -->
        <select id="currency" class="form-control w-25">
            <option value="USD">USD</option>
            <option value="KES">KES</option>
            <option value="LRD">LRD</option>
        </select>
        <!-- Language Selector -->
        <select id="language" class="form-control w-25">
            <option value="en">English</option>
            <option value="fr">French</option>
        </select>
    </div>

    <!-- Form for Uploading Transaction Data -->
    <form id="transactionForm" action="form-handler.php" method="POST">
        <div class="form-group">
            <label for="amount">Transaction Amount</label>
            <input type="number" id="amount" name="amount" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit Transaction</button>
    </form>

    <!-- Modal for Success Message -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalMessage">Transaction recorded successfully!</div>
            </div>
        </div>
    </div>

    <!-- Chart for Visualizing Transactions -->
    <canvas id="transactionChart" class="mt-5"></canvas>
</div>

<!-- Bootstrap and Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="scripts.js"></script>
</body>
</html>
