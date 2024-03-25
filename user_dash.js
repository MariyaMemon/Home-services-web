const sidebar = document.getElementById('sidebar');
const content = document.getElementById('content');
sidebar.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    content.classList.toggle('active');
});

function signOut(){
    sessionStorage.clear();
window.location.assign("Home.php"); 

}

function updateProfilePicture(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.querySelector('.profile-picture img').src = e.target.result;

            var formData = new FormData();
            formData.append('upload_picture', input.files[0]);

            fetch('upload_profile_picture.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to upload profile picture');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log('Profile picture updated successfully.');
                } else {
                    console.error('Failed to update profile picture:', data.error);
                }
            })
            .catch(error => {
                console.error('Error during updateProfilePicture fetch:', error);
            });
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function deleteProfilePicture() {
    if (confirm("Are you sure you want to delete your profile picture?")) {
        var formData = new FormData();
        formData.append('delete_profile', true);

        fetch('delete_profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Profile picture deleted successfully.');
                document.getElementById('profile-picture-container').innerHTML = '<img src="default-person-icon.png" alt="Default Icon">';
            } else {
                console.error('Failed to delete profile picture:', data.error);
                alert("Failed to delete profile picture. Please try again.");
            }
        })
        .catch(error => console.error('Error during deleteProfilePicture fetch:', error));
    }
}


function saveChanges() {
    var newPassword = document.getElementById('password').value;
    var formData = new FormData();
    formData.append('save_changes', true);
    formData.append('new_password', newPassword);

    fetch('update_userPasswd.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Changes saved successfully.');
           
        } else {
           
            alert("Failed to save changes. Please try again.");
        }
    })
    .catch(error => console.error('Error during saveChanges fetch:', error));
}


document.getElementById('service-select').addEventListener('change', function() {
    var selectedServiceId = this.value;

    if (selectedServiceId) {
        fetch('get_providers.php?service_id=' + selectedServiceId)
            .then(response => response.json())
            .then(data => {
                var providerListSection = document.querySelector('.provider-list-section');
                providerListSection.innerHTML = ''; 

                if (data.length > 0) {
                    data.forEach(provider => {
                        var providerItem = document.createElement('div');
                        providerItem.classList.add('provider-item');
                        providerItem.innerHTML = `
                            <div class="provider-picture">
                                <img src="${provider.profile_picture}" alt="Provider Picture">
                            </div>
                            <div class="provider-details">
                                <h2>${provider.user_name}</h2>
                                <div class="city-container">
                                    <span class="city">${provider.cityName}</span>
                                </div>
                                <div class="service-container">
                                    <li class="service" data-service-id="${provider.service_id}">
                                        ${provider.service_name} - ${provider.price}
                                    </li>
                                </div>
                                <div class="average-rating" data-toggle="modal" data-target="#reviewModal">
                                    ${provider.averageRating !== null ? getStarRatingHTML(provider.averageRating) : ''}
                                    ${getStarRatingHTML(provider.averageRating)}
                                    </div>
                                <button type="button" class="btn send-request-btn requestt" data-toggle="modal" data-target="#requestModal"
                                    data-provider-id="${provider.providers_id}"
                                    data-provider-username="${provider.user_name}"
                                    data-provider-profile-picture="${provider.profile_picture}">Send Request</button>
                            </div>
                        `;
                        providerListSection.appendChild(providerItem);
                    });
                } else {
                    providerListSection.innerHTML = '<p>No providers available for the selected service.</p>';
                }
            })
            .catch(error => console.error('Error fetching providers:', error));
    }
});



document.getElementById('city-select').addEventListener('change', function() {
    var selectedCity = this.value;
    if (selectedCity) {
        fetch('get_providers_by_city.php?city=' + selectedCity)
            .then(response => response.json())
            .then(data => {
                var providerListSection = document.querySelector('.provider-list-section');
                providerListSection.innerHTML = ''; 

                data.forEach(provider => {
                    var providerItem = document.createElement('div');
                    providerItem.classList.add('provider-item');
                    providerItem.innerHTML = `
                        <div class="provider-picture">
                            <img src="${provider.profile_picture}" alt="Provider Picture">
                        </div>
                        <div class="provider-details">
                            <h2>${provider.user_name}</h2>
                            <div class="city-container">
                                <span class="city">${provider.cityName}</span>
                            </div>
                            <div class="service-container">
                                <li class="service" data-service-id="${provider.service_id}">
                                    ${provider.service_name} - ${provider.price}
                                </li>
                            </div>
                            <div class="average-rating" data-toggle="modal" data-target="#reviewModal">
                              ${provider.averageRating !== null ? getStarRatingHTML(provider.averageRating) : ''}
                              ${getStarRatingHTML(provider.averageRating)}
                              </div>
                            <button type="button" class="btn send-request-btn requestt" data-toggle="modal" data-target="#requestModal"
                                data-provider-id="${provider.providers_id}"
                                data-provider-username="${provider.user_name}"
                                data-provider-profile-picture="${provider.profile_picture}">Send Request</button>
                        </div>
                    `;
                    providerListSection.appendChild(providerItem);
                });
            })
            .catch(error => console.error('Error fetching providers:', error));
    }
});
function getStarRatingHTML(rating) {
    var starsHTML = '';
    for (var i = 1; i <= 5; i++) {
        if (i <= rating) {
            starsHTML += "<span class='star filled'>&#9733;</span>"; 
        } else {
            starsHTML += "<span class='star'>&#9734;</span>"; 
        }
    }
    return starsHTML;
}

$('.send-request-again-btn').click(function () {
    var providerId = $(this).data('provider-id');
    var providerUsername = $(this).data('provider-name');
    var providerProfilePicture = $(this).data('profile-picture');
    var serviceName = $(this).data('service-name'); // Added line to retrieve service name
    var cityName = $(this).data('city');

    // Update the modal content with provider details
    $('#selectedProviderId').val(providerId);
    $('#providerUsernameDisplay').text(providerUsername);
    $('#providerProfilePictureDisplay').attr('src', providerProfilePicture);
    $('#cityName').text(cityName);

    // Set the selected service in the dropdown
    $('#selectedService').val(serviceName); // Select the service in the dropdown
});

// Optional: Trigger change event to ensure that updateSelectedServiceId() function is called
$('#selectedService').trigger('change');


