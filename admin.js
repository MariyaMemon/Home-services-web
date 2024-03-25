const sidebar = document.getElementById('sidebar');
const content = document.getElementById('content');

sidebar.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    content.classList.toggle('active');
});

function signOut() {
    sessionStorage.clear();
    window.location.assign("Home.php");
}




function updateProfilePicture(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader()
        reader.onload = function (e) {
            document.querySelector('.profile-picture img').src = e.target.result;

            // Fetch API to send the file to the server
            var formData = new FormData();
            formData.append('profile_picture', input.files[0]);

            fetch('update_profile_picture.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => console.log(data))
                .catch(error => console.error('Error:', error));
        };
        reader.readAsDataURL(input.files[0]);
    }
}





