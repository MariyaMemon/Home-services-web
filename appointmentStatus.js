
document.addEventListener('DOMContentLoaded', function() {
    // Function to handle accepting an appointment
    document.querySelectorAll('.accept-appointment-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var requestId = this.getAttribute('data-request-id');
            updateRequestStatus(requestId, 'accepted');
        });
    });

    // Function to handle rejecting an appointment
    document.querySelectorAll('.reject-appointment-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var requestId = this.getAttribute('data-request-id');
            updateRequestStatus(requestId, 'rejected');
        });
    });

    // Function to update request status via fetch
    function updateRequestStatus(requestId, status) {
        fetch('update_request_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'requestId=' + encodeURIComponent(requestId) + '&status=' + encodeURIComponent(status),
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            location.reload(); // Refresh the page after updating status
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});
//fetching

 // JavaScript code to handle the clear history button click
 var clearHistoryBtn = document.getElementById('clearHistoryBtn');

 if (clearHistoryBtn) {
     clearHistoryBtn.addEventListener('click', function() {
         // Add logic here to clear the appointment history
         // Use fetch or AJAX to send a request to the server
     });
 }
