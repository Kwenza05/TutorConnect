 /* loop for tutor-blocks */                          
let currentIndex = 0;

    function moveSlide(direction) {
        const tutorContainer = document.getElementById('tutorContainer');
        const totalTutors = document.querySelectorAll('.tutor-blocks').length;

        currentIndex += direction;

        // Loop the index
        if (currentIndex < 0) {
            currentIndex = totalTutors - 1;
        } else if (currentIndex >= totalTutors) {
            currentIndex = 0;
        }

        // Calculate the new translate value
        const offset = -currentIndex * (100 / totalTutors);
        tutorContainer.style.transform = `translateX(${offset}%)`;
    }



/*------------------------------Kwenza--------------------- */
document.addEventListener("DOMContentLoaded", function() {
    // 1. Change the background color of the body element
    document.body.style.backgroundColor = "#e6f7ff";

    // 2. Access and change an attribute of the meta tag
    const metaTag = document.querySelector('meta');
    metaTag.setAttribute('content', 'Updated content through DOM manipulation');

    // 3. Change the style of the first container (Browser Information)
    const browserInfoDiv = document.getElementById('browserInfo');
    browserInfoDiv.style.border = "1px solid #007bff";
    browserInfoDiv.style.padding = "20px";
    browserInfoDiv.style.backgroundColor = "white";

    // 4. Add a class name to the Java status div
    const javaStatusDiv = document.getElementById('javaStatus');
    javaStatusDiv.classList.add('highlight');

    // 5. Toggle the visibility of the locationStatus div
    const locationStatusDiv = document.getElementById('locationStatus');
    setTimeout(function() {
        locationStatusDiv.style.display = locationStatusDiv.style.display === 'none' ? 'block' : 'none';
    }, 3000);  // Toggle visibility after 3 seconds

    // 6. Get all elements by class name and change their font color
    const infoBlocks = document.getElementsByClassName('info');
    for (let i = 0; i < infoBlocks.length; i++) {
        infoBlocks[i].style.color = "#ff5733";  // Changing font color to orange
    }

// 7. Modify the text content of an existing paragraph and change the font
const existingPara = document.querySelector('p');
if (existingPara) {
    existingPara.textContent = "Your one-stop platform to connect with a tutor of your choice.";
    existingPara.style.fontFamily = "'Comic Sans MS', cursive"; // Set the font family
    existingPara.style.fontSize = "18px"; // Optionally change the font size
}


    // 8. Use querySelectorAll to get all buttons and change their background color
    const buttons = document.querySelectorAll('button');
    buttons.forEach(function(button) {
        button.style.backgroundColor = "#28a745";  // Change all buttons to green
        button.style.color = "#fff";  // White text for buttons
        button.style.padding = "10px 20px";  // Adjust padding for buttons
    });

    // 9. Add an event listener to an input field to change its border color on focus
    const inputField = document.querySelector('input[type="text"]');
    if (inputField) {
        inputField.addEventListener('focus', function() {
            inputField.style.borderColor = "#ff7e5f";  // Change border color when focused
        });
        inputField.addEventListener('blur', function() {
            inputField.style.borderColor = "#ccc";  // Reset border color when unfocused
        });
    }

    // Existing code for navigator properties and methods
    const appName = navigator.appName;
    const appCodeName = navigator.appCodeName;
    const appVersion = navigator.appVersion;
    const userAgent = navigator.userAgent;
    const platform = navigator.platform;

    const browserDetails = `
        <strong>App Name:</strong> ${appName}<br>
        <strong>App Code Name:</strong> ${appCodeName}<br>
        <strong>App Version:</strong> ${appVersion}<br>
        <strong>User Agent:</strong> ${userAgent}<br>
        <strong>Platform:</strong> ${platform}
    `;
    document.getElementById('browserDetails').innerHTML = browserDetails;

    const javaEnabled = navigator.javaEnabled();
    document.getElementById('javaResult').textContent = javaEnabled ? 'Yes, Java is enabled' : 'No, Java is not enabled';

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                document.getElementById('locationResult').textContent = `Latitude: ${latitude}, Longitude: ${longitude}`;
            },
            function(error) {
                document.getElementById('locationResult').textContent = `Unable to retrieve location: ${error.message}`;
            }
        );
    } else {
        document.getElementById('locationResult').textContent = 'Geolocation is not supported by your browser.';
    }
    /*The HTLM DOM events*/
    // 1. onclick - Highlight a tutor block when clicked
    function highlightTutor(){
        document.querySelectorAll('.tutor-blocks').forEach(function(block){
            block.style.border = ""; 
        });
        this.style.border = "2px solid #05445E";  // blue border when clicked
    }
    document.querySelectorAll('.tutor-blocks').forEach(function(block) {
        block.addEventListener('click', highlightTutor);
    });
    
    // 2. onmouseup - Change the background color after releasing the mouse button and unhighlight the previously highlighted block
    function changeColorOnMouseUp() {
        // Remove the highlighting (background color) from all tutor blocks
        document.querySelectorAll('.tutor-blocks').forEach(function(block) {
            block.style.backgroundColor = "";  // Reset to default background
        });
        this.style.backgroundColor = "#CCFFCC"; // Highlight the clicked block with a light red background
    }
    document.querySelectorAll('.tutor-blocks').forEach(function(block) {
        block.addEventListener('mouseup', changeColorOnMouseUp);
    }) 
    // 3. onfocus - Change border color when an input field gains focus
    function focusInput() {
        this.style.border = "2px solid #007bff";  // Blue border on focus
    }
    document.querySelectorAll('input').forEach(function(input) {
        input.addEventListener('focus', focusInput);
    }); 


});


/*------------------------------Kwenza--------------------- */

/* --------------chnages to the tutor blocks ------------------------ */
document.addEventListener("DOMContentLoaded", function() {
    const carousel = document.querySelector('.featuredTutor-column'); // The container of tutor blocks
    const blocks = document.querySelectorAll('.tutor-blocks'); // All tutor blocks
    const btnLeft = document.querySelector('.carousel-btn.left');
    const btnRight = document.querySelector('.carousel-btn.right');
    
    let currentIndex = 0;
    const visibleBlocks = 4; // Number of blocks visible at a time
    const blockWidth = blocks[0].offsetWidth + 20; // Block width + margin (adjust as needed)

    // Function to update the display of the tutor blocks
    function updateCarousel() {
        // Ensure that the blocks are transformed based on the currentIndex
        carousel.style.transform = `translateX(-${blockWidth * currentIndex}px)`;
    }

    // Move carousel to the left (previous)
    btnLeft.addEventListener('click', function() {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = blocks.length - visibleBlocks; // Wrap to the end
        }
        updateCarousel();
    });

    // Move carousel to the right (next)
    btnRight.addEventListener('click', function() {
        if (currentIndex < blocks.length - visibleBlocks) {
            currentIndex++;
        } else {
            currentIndex = 0; // Wrap back to the start
        }
        updateCarousel();
    });

    // Initialize the carousel
    updateCarousel();
});


 /* scroll to the top function */
 // Show the button when the user scrolls near the bottom of the page
 window.onscroll = function() {
    const scrollTopBtn = document.getElementById("backToTopBtn");

    // Get the total scrollable height of the document
    const totalHeight = document.documentElement.scrollHeight - window.innerHeight;

    // Show the button when the user is within 100px from the bottom
    if (window.pageYOffset > totalHeight - 100) {
        scrollTopBtn.style.display = "block";
    } else {
        scrollTopBtn.style.display = "none";
    }
};

// Scroll to the top when the button is clicked
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: "smooth" // Smooth scroll effect
    });
}

 /* review button */


 /* pop up review button */

 // Modal for Tutor 1
/* var modal1 = document.querySelectorAll(".modal")[0];
var btn1 = document.getElementById("openModalBtn1");
var close1 = modal1.getElementsByClassName("close")[0];

btn1.onclick = function() {
    modal1.style.display = "flex";
}

close1.onclick = function() {
    modal1.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal1) {
        modal1.style.display = "none";
    }
}

// Modal for Tutor 2
var modal2 = document.querySelectorAll(".modal")[1];
var btn2 = document.getElementById("openModalBtn2");
var close2 = modal2.getElementsByClassName("close")[0];

btn2.onclick = function() {
    modal2.style.display = "flex";
}

close2.onclick = function() {
    modal2.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal2) {
        modal2.style.display = "none";
    }
}

// Modal for Tutor 3
var modal3 = document.querySelectorAll(".modal")[2];
var btn3 = document.getElementById("openModalBtn3");
var close3 = modal3.getElementsByClassName("close")[0];

btn3.onclick = function() {
    modal3.style.display = "flex";
}

close3.onclick = function() {
    modal3.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal3) {
        modal3.style.display = "none";
    }
}

// Modal for Tutor 4
var modal4 = document.querySelectorAll(".modal")[3];
var btn4 = document.getElementById("openModalBtn4");
var close4 = modal4.getElementsByClassName("close")[0];

btn4.onclick = function() {
    modal4.style.display = "flex";
}

close4.onclick = function() {
    modal4.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal4) {
        modal4.style.display = "none";
    }
} */
// JavaScript to handle the star rating and reviews
// Select all star elements and the rating display element
const stars = document.querySelectorAll('.star');
const ratingDisplay = document.querySelector('.rating-value');
let ratingValue = 0;

// Function to reset rating display and stars
function resetRating() {
    ratingValue = 0; // Reset rating value
    ratingDisplay.textContent = 'Rating: 0'; // Reset displayed rating
    stars.forEach(star => star.classList.remove('active')); // Reset all stars
}

// Add click event listeners to each star
stars.forEach(star => {
    star.addEventListener('click', function() {
        // Get the rating value from the clicked star
        ratingValue = this.getAttribute('data-value');

        // Update the displayed rating
        ratingDisplay.textContent = `Rating: ${ratingValue}`;

        // Highlight the selected stars
        stars.forEach(s => s.classList.remove('active')); // Reset all stars
        for (let i = 0; i < ratingValue; i++) {
            stars[i].classList.add('active'); // Activate selected stars
        }
    });
});

// JavaScript to handle form submission
document.querySelector('.popupForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    const comments = document.getElementById('comments').value;

    // Ensure a rating is selected and comments are provided
    if (ratingValue === 0) {
        alert("Please provide a rating before submitting.");
        return;
    }

    if (comments.trim() === "") {
        alert("Please provide comments before submitting.");
        return;
    }

    // Prepare the form data to be sent
    const formData = new FormData();
    formData.append('rating', ratingValue);
    formData.append('comment', comments);
    formData.append('tutling_id', document.getElementById('tutling_id').value); // Include tutling ID
    formData.append('tutor_id', document.getElementById('tutor_id').value); // Include tutor ID

    // Send data to PHP script via fetch API
    fetch('submit_review.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        // Show response from PHP script
        alert(result);

        // Reset form and rating after submission
        this.reset(); // Reset the form fields
        resetRating(); // Reset star visuals and rating
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error submitting your review. Please try again.'); // Alert the user in case of an error
    });
});

// Function to handle modal display
const modalOverlay = document.getElementById('modalOverlay');
const closeModalBtn = document.getElementById('closeModal1');

// Add event listeners to all review buttons
document.querySelectorAll('.reviewButton').forEach(button => {
    button.addEventListener('click', () => {
        modalOverlay.style.display = 'flex'; // Show the modal
        resetRating(); // Reset the star rating each time the modal opens
    });
});

// Close modal when clicking the close button
closeModalBtn.addEventListener('click', () => {
    modalOverlay.style.display = 'none';
});

// Close the modal when clicking outside of it
window.addEventListener('click', (event) => {
    if (event.target === modalOverlay) {
        modalOverlay.style.display = 'none';
    }
});
function editTutor(id) {
    // Your code to handle editing a tutor
    console.log('Edit tutor with ID:', id);
}

function deleteTutor(id) {
    if (confirm('Are you sure you want to delete this tutor?')) {
        // Your code to handle deletion
        console.log('Delete tutor with ID:', id);
    }
}

function editStudent(id) {
    // Your code to handle editing a student
    console.log('Edit student with ID:', id);
}

function deleteStudent(id) {
    if (confirm('Are you sure you want to delete this student?')) {
        // Your code to handle deletion
        console.log('Delete student with ID:', id);
    }
}

function viewDetailedStatistics() {
    // Your code to view detailed statistics
    console.log('View detailed statistics');
}

