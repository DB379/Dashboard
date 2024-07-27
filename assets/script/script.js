// Function to show a specific tab
function showTab(tabName) {
    // Get all elements with class="tab-content" and hide them
    var tabs = document.getElementsByClassName('tab-content');
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].style.display = "none";
    }

    // Get all elements with class="tab-button" and remove the "active" class
    var tabButtons = document.getElementsByClassName('tab-button');
    for (var i = 0; i < tabButtons.length; i++) {
        tabButtons[i].classList.remove('active');
    }

    // Show the current tab
    document.getElementById(tabName).style.display = "block";

    // Set the active class on the corresponding tab button
    // Assuming the buttons are in the same order as the tab contents
    for (var i = 0; i < tabButtons.length; i++) {
        if (tabButtons[i].getAttribute('onclick').includes("'" + tabName + "'")) {
            tabButtons[i].classList.add('active');
        }
    }
}

// Initial setup to show the first tab when the page loads
window.onload = function() {
    showTab('profile'); // Default tab
}


function uploadPicture() {
    const form = document.getElementById('profilePicForm');
    const formData = new FormData(form);

    fetch('upload_profile_pic.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);  // Handle the response from the server
        alert("Profile picture updated successfully!");
        // Optionally refresh the profile picture on the page
        document.getElementById('userProfilePic').style.backgroundImage = 'url(../assets/users/profile/' + formData.get('upload-pic').name + ')';
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Failed to update profile picture.");
    });
}