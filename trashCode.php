<!-- // function createServiceListItem(service) {
    //     const listItem = document.createElement('li');
    //     listItem.textContent = service.service_name;
    //     listItem.dataset.serviceId = service.service_id;
    
    //     const deleteButton = createDeleteButton(service.service_id, listItem);
    //     listItem.appendChild(deleteButton);
    
    //     return listItem;
    // }
    
    // function fetchServiceDetails(serviceId) {
    //     return fetch(`get_service_details.php?serviceId=${serviceId}`)
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.success) {
    //                 return data.service;
    //             } else {
    //                 throw new Error(data.message || 'Error fetching service details.');
    //             }
    //         });
    // } -->


    <!-- // function deleteService(listItem, serviceId) {
    //     const confirmation = confirm('Do you want to delete this service?');
    
    //     if (confirmation) {
    //         listItem.remove();
    //         updateLocalStorage();
    
    //         fetch('delete.php', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //             },
    //             body: JSON.stringify({
    //                 serviceId: serviceId,
    //             }),
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             console.log('Success:', data);
    //         })
    //         .catch(error => {
    //             console.error('Error deleting service:', error);
    //         });
    //     }
    // } -->