document.addEventListener("DOMContentLoaded", function() {
    const carousel = document.querySelector('.featuredTutor-column'); // The container of tutor blocks
    const blocks = document.querySelectorAll('.tutor-blocks'); // All tutor blocks
    const btnLeft = document.querySelector('.carousel-btn.left');
    const btnRight = document.querySelector('.carousel-btn.right');
    
    let currentIndex = 0;
    const visibleBlocks = 3; // Number of blocks visible at a time
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
var modal1 = document.querySelectorAll(".modal")[0];
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
}

