document.addEventListener('DOMContentLoaded', function () {   
    fetchServices();
    fetchAndDisplayServices();
    fetchCityName();
   
    
    addServiceButton.addEventListener('click', addService);
    document.getElementById('submitButton').addEventListener('click', submitServicesAndCity); 
});
function submitServicesAndCity() {
    submitServices(); 
    addCity(); 
}
function fetchServices(){
    fetch('get_services.php')
        .then(response => response.json())
        .then(services => {
            const servicesDropdown = document.getElementById('servicesDropdown');            
            services.forEach(services => {
                const option = document.createElement('option');
                option.value = services.service_id; 
                option.text = services.service_name; 
                servicesDropdown.appendChild(option);
            });            
             const selectedServices = JSON.parse(localStorage.getItem('selectedServices')) || [];
             const selectedServicesList = document.getElementById('selectedServicesList');
    
             selectedServices.forEach(serviceId => {
                 const listItem = document.createElement('li');
                 const selectedService = services.find(service => service.service_id === serviceId);
                 listItem.textContent = selectedService.service_name;
                 listItem.dataset.serviceId = selectedService.service_id;
                 selectedServicesList.appendChild(listItem);
             });            
    })
    .catch(error => console.error('Error fetching services:', error));
}
function addService() {
    var servicesDropdown = document.getElementById("servicesDropdown");
    var priceDropdown = document.getElementById("priceDropdown");
    var selectedServicesList = document.getElementById("selectedServicesList");

    var selectedService = servicesDropdown.options[servicesDropdown.selectedIndex].text;
    var selectedPrice = priceDropdown.value;

    if (selectedService && selectedPrice) {
        var listItem = document.createElement("li");
        listItem.className = "service-item"; // Add class for styling

        var servicePriceContainer = document.createElement("div"); // Container for service and price
        servicePriceContainer.className = "service-price-container"; // Add class for styling

        var serviceSpan = document.createElement("span");
        var serviceText = document.createTextNode(selectedService);
        serviceSpan.appendChild(serviceText);

        var priceSpan = document.createElement("span");
        priceSpan.className = "service-price"; // Add class for styling
        var priceText = document.createTextNode(selectedPrice);
        priceSpan.appendChild(priceText);

        var crossButton = document.createElement("button");
        crossButton.innerHTML = "X"; 
        crossButton.onclick = function () {
            listItem.remove();
        };

        servicePriceContainer.appendChild(serviceSpan);
        servicePriceContainer.appendChild(document.createTextNode(" - ")); // Add separator
        servicePriceContainer.appendChild(priceSpan);

        listItem.appendChild(servicePriceContainer);
        listItem.appendChild(crossButton);

        selectedServicesList.appendChild(listItem);

        servicesDropdown.value = "";
        priceDropdown.value = "";        
    }
}


function submitServices() {
    var selectedServicesList = document.getElementById("selectedServicesList");

    var servicesData = [];
    var listItems = selectedServicesList.getElementsByTagName("li");
   

    for (var i = 0; i < listItems.length; i++) {
        var itemText = listItems[i].textContent.split(" - ");
        var service = itemText[0];
        var price = itemText[1];
        servicesData.push({ service: service, price: price });
    }
    servicesData[0].price = servicesData[0].price.slice(0,3);
   
    fetch('submit_services.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ services: servicesData }),
    })
    .then(response => response.json())
    .then(data => {
        alert("submitted successfully!")
        selectedServicesList.innerHTML = '';
        fetchAndDisplayServices(); 
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

function fetchAndDisplayServices() {
    fetch('P_submitedServices.php')
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data)) {
                displaySubmittedServices(data);
            } else {
                console.error('Invalid or missing services data:', data);
            }
        })
        .catch(error => console.error('Error fetching services:', error));
}


function createUpdateModal(service) {
    var modal = document.createElement('div');
    modal.className = 'modal';

    var content = document.createElement('div');
    content.className = 'modal-content';

    var closeBtn = document.createElement('span');
    closeBtn.innerHTML = '&times;';
    closeBtn.className = 'close';
    closeBtn.onclick = function () {
        modal.style.display = 'none';
    };
    
    // Creating dropdown for selecting service
    var updateServiceDropdown = document.createElement('select');
    updateServiceDropdown.id = 'updateServiceDropdown';

    var servicesDropdownOptions = document.getElementById('servicesDropdown').options;
    for (var i = 1; i < servicesDropdownOptions.length; i++) {
        var option = document.createElement('option');
        option.value = servicesDropdownOptions[i].value;
        option.text = servicesDropdownOptions[i].text;
        updateServiceDropdown.appendChild(option);
    }

    // Creating dropdown for selecting price
    var updatePriceDropdown = document.createElement('select');
    updatePriceDropdown.id = 'updatePriceDropdown';

    var priceDropdownOptions = document.getElementById('priceDropdown').options;
    for (var i = 1; i < priceDropdownOptions.length; i++) {
        var option = document.createElement('option');
        option.value = priceDropdownOptions[i].value;
        option.text = priceDropdownOptions[i].text;
        updatePriceDropdown.appendChild(option);
    }

    // Creating Update button
    var updateBtn = document.createElement('button');
    updateBtn.innerHTML = 'Update';
    updateBtn.onclick = function () {
        // Retrieve the selected service and price values
        var updatedService = updateServiceDropdown.options[updateServiceDropdown.selectedIndex].text;
        var updatedPrice = updatePriceDropdown.value;
        // Pass the values to the updateService function
        updateService(service.service_id, updatedService, updatedPrice);
        // Hide the modal
        modal.style.display = 'none';
    };

    // Appending elements to content div
    content.appendChild(closeBtn);
    content.appendChild(updateServiceDropdown);
    content.appendChild(updatePriceDropdown);
    content.appendChild(updateBtn);

    // Appending content to modal
    modal.appendChild(content);

    // Appending modal to document body
    document.body.appendChild(modal);

    // Displaying modal
    modal.style.display = 'block';
}


function displaySubmittedServices(services) {
    var submittedServicesList = document.getElementById('submittedServicesList');
    submittedServicesList.innerHTML = ''; 

    services.forEach(service => {
        var listItem = document.createElement('li');
        listItem.className = 'service-item';

        var serviceContainer = document.createElement('div');
        serviceContainer.className = 'service-container';
        
        var serviceText = document.createTextNode(service.service_name + ' - ' + service.price);
        serviceContainer.appendChild(serviceText);
        
        var updateButton = document.createElement('button');
        updateButton.innerHTML = 'Update';
        updateButton.className = 'update-button'; // Add class for styling
        updateButton.onclick = function () {
            createUpdateModal(service);
        };
        
        var deleteButton = document.createElement('button');
        deleteButton.innerHTML = 'Delete';
        deleteButton.className = 'delete-button'; // Add class for styling
        deleteButton.onclick = function () {
            deleteService(service.service_id);
        };
        
        serviceContainer.appendChild(updateButton);
        serviceContainer.appendChild(deleteButton);
        
        listItem.appendChild(serviceContainer);

        submittedServicesList.appendChild(listItem);
    });
}



function updateService(service_id, updatedService, updatedPrice) {
    console.log('Updating service:', service_id, updatedService, updatedPrice);
    fetch('update_service.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ service_id: service_id, updatedService: updatedService, updatedPrice: updatedPrice }),
    })
    .then(response => response.json())
    .then(data => {
        console.log('Service updated successfully:', data);
        // Refresh the page or update the UI as needed
        // fetchSubmittedServices(); // Assuming you have a function to fetch and display submitted services
    })
    .catch((error) => {
        console.error('Error updating service:', error);
    });
}



function deleteService(serviceId) {
    fetch('delete_service.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ service_id: serviceId }),
    })
    .then(response => response.json())
    .then(data => {
        console.log('Service deleted successfully:', data);
        fetchAndDisplayServices();
    })
    .catch((error) => {
        console.error('Error deleting service:', error);
    });
}
function addCity() {
    const cityNameInput = document.getElementById('cityName');
        const cityName = cityNameInput.value;
    
        if (cityName.trim() !== '') {
            const emailContactInput = document.getElementById('email_contact');
            const providerIdentifier = emailContactInput.value;
    
            fetch('cityPost.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    identifier: providerIdentifier, 
                    cityName: cityName,
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('City submitted successfully:', data);
            })
            .catch(error => {
                console.error('Error submitting city:', error);
            });
        } else {
            alert('Please enter a valid city name.');
        }
    }

    function fetchCityName() {
        const emailContactInput = document.getElementById('email_contact');
        const providerIdentifier = emailContactInput.value;
    
      
        fetch('cityDisplay.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                identifier: providerIdentifier,
            }),
        })
        .then(response => response.json())
        .then(data => {
            const cityNameInput = document.getElementById('cityName');
            cityNameInput.value = data.cityName; 
        })
        .catch(error => {
            console.error('Error fetching city:', error);
        });
    }