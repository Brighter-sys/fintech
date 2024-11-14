<?php
session_start();

// Debugging: Check session variable
if (isset($_SESSION['username'])) {
    echo "Logged in as: " . $_SESSION['username']; // This should print the username if the user is logged in

    // Fetch transactions if logged in
    include 'db.php'; 
    $transactions = $pdo->query("SELECT * FROM transactions ORDER BY created_at DESC")->fetchAll();
} else {
    // Debugging: If not logged in, show a message
    echo "You are not logged in."; 
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fintech Demo - Transaction Form</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include custom CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- If user is logged in, show the logout button -->
        <?php if (isset($_SESSION['username'])): ?>
            <form action="logout.php" method="POST">
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        <?php endif; ?>
        
        <!-- If user is not logged in, show the login and register forms -->
        <?php if (!isset($_SESSION['username'])): ?>
            <div class="row">
                <div class="col-md-6">
                    <h2>Login</h2>
                    <form action="login-handler.php" method="POST">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="submit">Login</button>
                    </form>
                </div>

                <div class="col-md-6">
                    <h2>Register</h2>
                    <form action="register-handler.php" method="POST">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="submit">Register</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <!-- Start of the transaction form -->
            <h2>Transaction Form</h2>
            <form id="transactionForm" action="form-handler.php" method="POST">
                <!-- Name Field -->
                <div class="form-group">
                    <label for="name">Your Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                
                <!-- Amount Field with validation -->
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="number" class="form-control" id="amount" name="amount" required min="1">
                </div>

                <!-- Currency Selection -->
                <div class="form-group">
                    <label for="currency">Currency:</label>
                    <select class="form-control" id="currency" name="currency">
                        <option value="KES">Kenyan Shilling (KES)</option>
                        <option value="USD">US Dollar (USD)</option>
                        <option value="EUR">Euro (EUR)</option>
                    </select>
                </div>

                <!-- Form Submission Button -->
                <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
            </form>

            <!-- Transaction History Section -->
            <h3 class="mt-4">Transaction History</h3>
            <ul id="transactionHistory" class="list-group">
                <!-- PHP Code to Display Transactions -->
                <?php foreach ($transactions as $transaction): ?>
                    <li class="list-group-item">
                        <?= htmlspecialchars($transaction['amount']) . ' ' . htmlspecialchars($transaction['currency']) . ' on ' . $transaction['created_at'] ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- JavaScript files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    
    <script>
        // Form validation using JavaScript
        document.getElementById('transactionForm').addEventListener('submit', function(e) {
            // Prevent form submission for validation
            e.preventDefault();

            // Get form data
            const name = document.getElementById('name').value;
            const amount = document.getElementById('amount').value;
            const currency = document.getElementById('currency').value;

            // Validate name (should not be empty)
            if (name.trim() === "") {
                alert("Name is required");
                return;
            }

            // Validate amount (should be a positive number)
            if (amount <= 0) {
                alert("Please enter a valid amount");
                return;
            }

            // Validate currency selection
            if (currency === "") {
                alert("Please select a currency");
                return;
            }

            // If validation passes, submit the form via AJAX
            $.ajax({
                type: 'POST',
                url: 'form-handler.php',
                data: {
                    name: name,
                    amount: amount,
                    currency: currency
                },
                success: function(response) {
                    // Handle the response (e.g., success message or transaction list update)
                    alert(response.message);
                    loadTransactionHistory(); // Reload transaction history after submission
                },
                error: function() {
                    alert("There was an error submitting the transaction.");
                }
            });
        });

        // Function to load transaction history via AJAX
// AJAX request to load transaction history
function loadTransactionHistory() {
    $.ajax({
        url: 'get-transactions.php',
        method: 'GET',
        success: function(response) {
            const transactions = JSON.parse(response);  // Parse the JSON response
            const historyList = document.getElementById('transactionHistory');
            historyList.innerHTML = "";  // Clear existing history

            if (transactions.length > 0) {
                transactions.forEach(transaction => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('list-group-item');
                    listItem.textContent = `${transaction.amount} ${transaction.currency} - ${transaction.created_at}`;
                    historyList.appendChild(listItem);
                });
            } else {
                // If no transactions, display a message
                const noTransactionsMessage = document.createElement('li');
                noTransactionsMessage.classList.add('list-group-item');
                noTransactionsMessage.textContent = "No transactions found.";
                historyList.appendChild(noTransactionsMessage);
            }
        },
        error: function() {
            alert("There was an error loading the transaction history.");
        }
    });
}




        // Load transaction history when page loads
        window.onload = loadTransactionHistory;
    </script>
</body>
</html>
