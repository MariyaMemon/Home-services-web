const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        sidebar.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            content.classList.toggle('active');
        });
        //end sidebar
     function signOut(){
        // localStorage.removeItem('selectedServicesList'); 
     sessionStorage.clear();
    //  selectedServicesList.innerHTML = '';
    //  fetchServices();
     window.location.assign("Home.php");        
       }      
       //end signout
       function updateProfilePicture(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.querySelector('.profile-picture img').src = e.target.result;
    
                var formData = new FormData();
                formData.append('upload_picture', input.files[0]);
    
                fetch('upload_profile.php', {
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
            formData.append('delete_providerProfile.php', true);
    
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
    
    //end p update.
    