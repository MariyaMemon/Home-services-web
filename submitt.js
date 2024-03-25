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



    
