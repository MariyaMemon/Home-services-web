$('#requestModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var providerId = button.data('provider-id');
    var providerUsername = button.data('provider-username');
    var providerProfilePicture = button.data('provider-profile-picture');
    var servicesList = button.siblings('.service-container').find('.service');
  


    $('#selectedProviderId').val(providerId);
    $('#providerUsername').val(providerUsername);
    $('#providerProfilePicture').val(providerProfilePicture);

    $('#providerProfilePictureDisplay').attr('src', providerProfilePicture);

    $('#providerUsernameDisplay').text(providerUsername);


    $('#selectedService').empty().append('<option value="">Select service</option>');
    servicesList.each(function() {
    var serviceText = $(this).text();
    var serviceId = $(this).data('service-id'); // Assuming you have a data attribute for service ID
    $('#selectedService').append('<option value="' + serviceText + '" data-service-id="' + serviceId + '">' + serviceText +  '</option>');
  });


    var cityName = button.siblings('.city-container').find('.city').text();
    $('#cityName').text(cityName);
  });

function updateSelectedServiceId() {
    var selectedServiceDropdown = document.getElementById("selectedService");
    var selectedServiceIdInput = document.getElementById("selectedServiceId");

    // Check if elements are found
    if (selectedServiceDropdown && selectedServiceIdInput) {
        // Get the selected option from the dropdown
        var selectedOption = selectedServiceDropdown.options[selectedServiceDropdown.selectedIndex];

        // Log the selected service ID to the console
        console.log("Selected Service ID:", selectedOption.getAttribute("data-service-id"));

        // Set the value of the hidden input to the selected service ID
        selectedServiceIdInput.value = selectedOption.getAttribute("data-service-id");
    } else {
        console.error("Elements not found. Check the IDs 'selectedService' and 'selectedServiceId'.");
    }
}
function updateHiddenRequestAddress() {
    var requestAddress = document.getElementById("requestAddress").value;
    document.getElementById("hiddenRequestAddress").value = requestAddress;
}
