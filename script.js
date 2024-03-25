document.addEventListener('DOMContentLoaded', function () {
    
    fetchServices();
    retrieveSelectedServices();
    fetchCityName();
   
    fetchSubmittedServices();
   
    addServiceButton.addEventListener('click', addService);
    submitButton.addEventListener('click', submitServices);
});
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
    const servicesDropdown = document.getElementById('servicesDropdown');
    const selectedServiceId = servicesDropdown.value;
    

    if (selectedServiceId) {
        const selectedServicesList = document.getElementById('selectedServicesList');

        const isAlreadySelected = Array.from(selectedServicesList.children).some(item => item.dataset.serviceId === selectedServiceId);
           
        if (isAlreadySelected) {
            alert('This service is already selected.');
        } else {
            const listItem = document.createElement('li');
            listItem.textContent = servicesDropdown.options[servicesDropdown.selectedIndex].text;
            listItem.dataset.serviceId = selectedServiceId;

            const deleteButton = createDeleteButton(selectedServiceId);
                listItem.appendChild(deleteButton);
            selectedServicesList.appendChild(listItem);

            const emailContactInput = document.getElementById('email_contact');
            const providerIdentifier = emailContactInput.value;

            
            fetch('submiting.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email_contact: providerIdentifier,
                    service_name: servicesDropdown.options[servicesDropdown.selectedIndex].text,
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
            })
            .catch(error => {
                console.error('Error submitting services:', error);
            });
        }
        fetchServiceDetails(selectedServiceId)
    .then(service => {
        const listItem = createServiceListItem(service);
        selectedServicesList.appendChild(listItem);
        updateLocalStorage();
    })
    }
}
function submitServices() {
    const cityNameInput = document.getElementById('cityName');
    const cityName = cityNameInput.value;

    if (cityName.trim() !== '') {
        const emailContactInput = document.getElementById('email_contact');
        const providerIdentifier = emailContactInput.value;

        fetch('cP.php', {
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




    function retrieveSelectedServices() {
        const selectedServicesList = document.getElementById('selectedServicesList');
        const selectedServices = JSON.parse(localStorage.getItem('selectedServices')) || [];
    
        selectedServices.forEach(serviceId => {
            fetchServiceDetails(serviceId)
                .then(service => {
                    const listItem = createServiceListItem(service);
                    selectedServicesList.appendChild(listItem);
                })
                .catch(error => console.error('Error fetching service details:', error));
        });
    }
    
     function createServiceListItem(service) {
            const listItem = document.createElement('li');
            listItem.textContent = service.service_name;
            listItem.dataset.serviceId = service.service_id;
        
            const deleteButton = createDeleteButton(service.service_id, listItem);
            listItem.appendChild(deleteButton);
        
            return listItem;
        }
        
        function fetchServiceDetails(serviceId) {
            return fetch(`get_service_details.php?serviceId=${serviceId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        return data.service;
                    } else {
                        throw new Error(data.message || 'Error fetching service details.');
                    }
                });
        } 
    

    function createDeleteButton(serviceId, listItem) {
        const deleteButton = document.createElement('button');
        deleteButton.className = 'delete-button';
        deleteButton.textContent = 'Delete';
        deleteButton.onclick = function () {
            deleteService(listItem, serviceId);
        };

        
        return deleteButton;
    }
    
    function updateLocalStorage() {
        const selectedServicesList = document.getElementById('selectedServicesList');
        const updatedSelectedServices = Array.from(selectedServicesList.children).map(item => item.dataset.serviceId);
        localStorage.setItem('selectedServices', JSON.stringify(updatedSelectedServices));
    }
    
    function deleteService(listItem, serviceId) {
        const confirmation = confirm('Do you want to delete this service?');
    
        if (confirmation) {
            listItem.remove();
            updateLocalStorage();
    
            fetch('delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    serviceId: serviceId,
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
            })
            .catch(error => {
                console.error('Error deleting service:', error);
            });
        }
    } 
  
   
    
    function submitServices() {
        const cityNameInput = document.getElementById('cityName');
        const cityName = cityNameInput.value;
    
        if (cityName.trim() !== '') {
            const emailContactInput = document.getElementById('email_contact');
            const providerIdentifier = emailContactInput.value;
    
            fetch('cP.php', {
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
    
      
        fetch('cD.php', {
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
    function fetchSubmittedServices() {
        const emailContactInput = document.getElementById('email_contact');
        const providerIdentifier = emailContactInput.value;
        
    
       
        fetch('servicesList.php', {
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
            const selectedServicesList = document.getElementById('selectedServicesList');
            selectedServicesList.innerHTML = '';
    
            if (data.services.length > 0) {
                data.services.forEach(service => {
                    const listItem = document.createElement('li');
                    listItem.textContent = service.service_name;
                    selectedServicesList.appendChild(listItem);

                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Delete';
                    deleteButton.onclick = function () {
                        deleteService(service.service_name);
                    };
                    listItem.appendChild(deleteButton);
    
                    servicesList.appendChild(listItem);
                });
                
            } else {
                const listItem = document.createElement('li');
                // listItem.textContent = 'No services submitted by the provider';
                selectedServicesList.appendChild(listItem);
            }
        })
        .catch(error => {
            console.error('Error fetching services:', error);
        });
    }
    function deleteService(serviceName) {
        const confirmation = confirm('Do you want to delete this service?');
    
        if (confirmation) {
            const emailContactInput = document.getElementById('email_contact');
            const providerIdentifier = emailContactInput.value;
    
           
            fetch('delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    identifier: providerIdentifier,
                    serviceName: serviceName,
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                
                fetchSubmittedServices();
            })
            .catch(error => {
                console.error('Error deleting service:', error);
            });
        }
    }

    