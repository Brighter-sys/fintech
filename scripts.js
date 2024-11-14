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

    // Currency conversion (for display purposes)
    $('#currency').change(function() {
        const selectedCurrency = $(this).val();
        // You could apply conversion logic here
        alert('Currency changed to ' + selectedCurrency);
    });

    // Language translation (basic demo)
    $('#language').change(function() {
        const selectedLanguage = $(this).val();
        if (selectedLanguage === 'fr') {
            $('#modalTitle').text('Succès');
            $('#modalMessage').text('Transaction enregistrée avec succès !');
            $('label[for="amount"]').text('Montant de la transaction');
        } else {
            $('#modalTitle').text('Success');
            $('#modalMessage').text('Transaction recorded successfully!');
            $('label[for="amount"]').text('Transaction Amount');
        }
    });
});
