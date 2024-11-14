$(document).ready(function() {
    // Submit the form via AJAX
    $('#transactionForm').submit(function(e) {
        e.preventDefault(); // Prevent form submission from reloading the page

        // Gather form data
        const formData = $(this).serialize();

        // AJAX request to PHP form handler
        $.ajax({
            type: 'POST',
            url: 'form-handler.php',
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    // Show success message in modal
                    $('#modalMessage').text(response.message);
                    $('#successModal').modal('show');

                    // Update the chart with new transaction
                    updateChart(response.amount);
                }
            }
        });
    });

    // Initialize chart for transactions
    const ctx = document.getElementById('transactionChart').getContext('2d');
    const transactionChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [], // Will be populated with timestamps
            datasets: [{
                label: 'Transaction Amount',
                data: [],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{ ticks: { beginAtZero: true } }]
            }
        }
    });

    // Function to update the chart with a new transaction
    function updateChart(amount) {
        const timestamp = new Date().toLocaleTimeString();
        transactionChart.data.labels.push(timestamp);
        transactionChart.data.datasets[0].data.push(amount);
        transactionChart.update();
    }

    // Function to fetch transactions from the server and update the chart
    function fetchTransactions() {
        $.ajax({
            type: 'GET',
            url: 'get-transactions.php',  // Path to your get-transactions.php file
            success: function(response) {
                const transactions = JSON.parse(response);  // Parse the returned JSON

                // Clear previous data in the chart
                transactionChart.data.labels = [];
                transactionChart.data.datasets[0].data = [];

                // Loop through the transactions and update the chart
                transactions.forEach(function(transaction) {
                    const timestamp = new Date(transaction.date).toLocaleTimeString();
                    transactionChart.data.labels.push(timestamp);
                    transactionChart.data.datasets[0].data.push(transaction.amount);
                });

                // Update the chart
                transactionChart.update();
            },
            error: function() {
                console.error('Error fetching transactions.');
            }
        });
    }

    // Fetch transactions when the page loads
    fetchTransactions();

    // Set interval to refresh transactions every 5 minutes (optional)
    setInterval(fetchTransactions, 5 * 60 * 1000);  // Refresh every 5 minutes
});
