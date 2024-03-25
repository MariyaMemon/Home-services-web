<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="rating.css">
<div class="modal" id="reviewModal">
  <div class="modal-dialog">
    <div class="ratingModal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        
      </div>

      <!-- Modal Body -->
      <div class="ratingModal-body">
    
        <div id="rating-stars">
          <!-- Display 5 stars -->
          <?php
          for ($i = 1; $i <= 5; $i++) {
            echo "<span class='star' data-rating='$i'>&#9734;</span>";
          }
          ?>
          <input type="hidden" id="selectedRating" name="selectedRating" value="">
        </div>
        <textarea id="review-text" placeholder="Add your review here..."></textarea>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="submit-review-btn">Submit Review</button>
        <button type="button" class="btn btn-secondary" id="cancel-btn" data-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>

<?php
$sql = "SELECT p.*, ps.service_id, s.service_name, ps.cityName, ps.price
        FROM `provider` p
        LEFT JOIN `provider_services` ps ON p.providers_id = ps.providers_id
        LEFT JOIN `services` s ON ps.service_id = s.service_id
        LEFT JOIN `reviews` r ON p.providers_id = r.providers_id"; 

$result = $conn->query($sql); 

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $providers = array(); 

  while ($row = $result->fetch_assoc()) {
    $providerId = $row['providers_id'];

    if (!isset($providers[$providerId])) {
      $providers[$providerId] = array(
        'user_name' => $row['user_name'],
        'profile_picture' => !empty($row['profile_picture']) ? $row['profile_picture'] : 'default-person-icon.png',
        'services' => array(),
        'cityName' => $row['cityName'],
        'price' => $row['price'],
        'averageRating' => null,
      );
    }

    $providers[$providerId]['services'][] = $row['service_name']; 

   
    }
    foreach ($providers as $providerId => &$provider) {
      $averageRatingQuery = "SELECT AVG(rating) AS averageRating FROM reviews WHERE providers_id = ?";
      $stmtAverageRating = $conn->prepare($averageRatingQuery);
      $stmtAverageRating->bind_param("i", $providerId);
      $stmtAverageRating->execute();
      $stmtAverageRating->bind_result($averageRating);
      $stmtAverageRating->fetch();
      $stmtAverageRating->close();

      // Store average rating in the providers array
      $provider['averageRating'] = $averageRating !== null ? round($averageRating) : null;
  }
  }

  foreach ($providers as $providerId => $provider) {
    echo '<div class="provider-item">';
    echo '<div class="provider-picture">';
    echo "<img src='{$provider['profile_picture']}' alt='Provider Picture'>";
    echo '</div>';
    echo '<div id="provider-item" class="provider-details">';
    echo "<h2 >{$provider['user_name']}</h2>";
    
    echo '<div class="city-container">';
    echo '<span class="city">' . $provider['cityName'] . '</span>';
    echo '</div>';

    echo '<div class="service-container">';
    foreach ($provider['services'] as $service) {
       
        $serviceIdQuery = "SELECT service_id FROM services WHERE service_name = ?";
        $stmtServiceId = $conn->prepare($serviceIdQuery);
        $stmtServiceId->bind_param("s", $service);
        $stmtServiceId->execute();
        $stmtServiceId->bind_result($serviceId);
        $stmtServiceId->fetch();
        $stmtServiceId->close();
    
        echo '<li class="service" data-service-id="' . $serviceId . '">' . $service . ' - ' . $provider['price'] . '</li>';
    }
    echo '</div>';
    
    echo '<div class="average-rating" data-toggle="modal" data-target="#reviewModal">';
    
    if ($provider['averageRating'] !== null) {
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $provider['averageRating']) {
                echo "<span class='star filled'>&#9733;</span>"; // Filled star
            } else {
                echo "<span class='star'>&#9734;</span>"; // Empty star
            }
        }
    } else {
        // If no rating is available, display all stars as empty
        for ($i = 1; $i <= 5; $i++) {
            echo "<span class='star'>&#9734;</span>"; // Empty star
        }
    }
    echo '</div>';





    

    echo '<button type="button" class="btn send-request-btn requestt" data-toggle="modal" data-target="#requestModal"';
    echo ' data-provider-id="' . $providerId . '"';
    echo ' data-provider-username="' . $provider['user_name'] . '"';
    echo ' data-provider-profile-picture="' . $provider['profile_picture'] . '">Send Request</button>';

   
  
    echo '</div>';
    echo '</div>';
}



?>
<script>

document.addEventListener('DOMContentLoaded', function() {
  let selectedRating = 0;
  let selectedProviderId = null;

  // Event listener for submitting the review
  document.getElementById('submit-review-btn').addEventListener('click', function() {
    const reviewText = document.getElementById('review-text').value;

    // Check if a rating and provider are selected
    if (selectedRating > 0 && selectedProviderId !== null) {
      // Send the review data to the server using fetch
      fetch('submit_review.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          providerId: selectedProviderId,
          rating: selectedRating,
          review: reviewText,
        }),
      })
      .then(response => response.json())
      .then(data => {
        // Handle response from the server
        if (data.success) {
          // Optionally, you can perform actions like showing a success message or updating the UI
          console.log('Review submitted successfully');
        } else {
          console.error('Failed to submit review');
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });

      // Hide the modal after submitting the review
      $('#reviewModal').modal('hide');
    } else {
      console.error('Please select a rating and a provider before submitting the review');
    }
  });

      // Hide the modal after submitting the review
      $('#reviewModal').modal('hide');
    } else {
      console.error('Please select a rating and a provider before submitting the review');
    }
  

  // Function to update the displayed stars based on user interaction
  function updateStars(rating) {
    document.querySelectorAll('#reviewModal #rating-stars .star').forEach(function(star) {
      const starRating = parseInt(star.getAttribute('data-rating'));
      if (starRating <= rating) {
        star.classList.add('filled');
      } else {
        star.classList.remove('filled');
      }
    });
    selectedRating = rating; // Update the selected rating
  }

  // Event listener for clicking on a star
  document.querySelectorAll('#reviewModal #rating-stars .star').forEach(function(star) {
    star.addEventListener('click', function() {
      const rating = parseInt(this.getAttribute('data-rating'));
      updateStars(rating);
    });
  });

  // Event listener for clicking on a provider's average rating stars
  document.querySelectorAll('.average-rating').forEach(function(averageRating) {
    averageRating.addEventListener('click', function() {
      selectedProviderId = this.getAttribute('data-provider-id');
      $('#reviewModal').modal('show');
    });
  });
});
</script>










