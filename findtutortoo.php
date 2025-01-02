<?php
/* session_start();

// Check if the user is logged in by verifying the session
if (!isset($_SESSION['user_id']) && !isset($_SESSION['tutor_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include database connection file
include 'db_connection.php';

// Determine which ID to use
$tutor_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $_SESSION['tutor_id'];
$_SESSION['userID'] = $tutor_id;

// Fetch tutor's details from the database
$sql = "SELECT name, surname, email, phone, bio,  image_path FROM tutors WHERE tutor_id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $tutor_id);
$stmt->execute();
$stmt->bind_result($name, $surname, $email, $phone, $bio, $profile_image);
$stmt->fetch();
$stmt->close();
$db->close(); */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TutorConnect - Find a Tutor</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="reviewformStyling.css">
  

    <style>
        nav {
            z-index: 1000;
        }
        
    

    </style>

</head>
<body>
    <!-- Header -->
    <header style="background: url('background.jpg') no-repeat center center; background-size: cover; padding: 120px; text-align: center; color: white;">
        <img src="logo.png" alt="TutorConnect Logo" style="position: absolute; top: 20px; left: 20px; width: 80px; height: auto;">
    </header>
       <!-- NAVIGATION -->
<nav>

    <input type="checkbox" id="menu-toggle" class="menu-toggle" />
    <label for="menu-toggle" class="menu-icon">☰ Menu</label>
  
    <ul class="nav-list" >
      <li ><a href="index.php">Home</a></li>
      <li class="active"><a href="findtutor.php">Find a Tutor</a></li>
      <!--<li>
        <a href="#">Services ▼</a>
        <ul class="dropdown">
          <li><a href="tutoring.html">Tutoring</a></li>
          <li><a href="consulting.html">Consulting</a></li>
          <li><a href="coaching.html">Coaching</a></li>
        </ul>
      </li>-->
      <li><a href="about.html">About Us</a></li>
      <li><a href="contact.html">Contact</a></li>
      <li><a href="reviews.html">Reviews</a></li>
    </ul>
  </nav>

    <main>
        <!-- Search Section -->
        <!-- <section style="text-align: center; padding: 100px 0; position: relative; width: 100%; box-sizing: border-box;" class="search-section">
            <div style="position: relative;">
                <h2>Search for Tutors by Subject</h2>
                <p>Enter the subject you need help with, and we'll find the best tutors for you.</p>
                <form id="searchForm" action="search_results.html" method="get">
                    <input type="text" id="subject" name="subject" required placeholder="Enter a subject (e.g., Math, Science)" style="padding: 10px; width: 300px; border-radius: 5px; border: 1px solid #ccc;">
                    <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px;">Search</button>
                </form>
            </div>
                            <form id="searchForm">
                    <input type="text" id="subject" name="subject" required placeholder="Enter a subject (e.g., Math, Science)" style="padding: 10px; width: 300px; border-radius: 5px; border: 1px solid #ccc;">
                    <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px;">Search</button>
                </form>
        </section>  -->

    

        <!-- Search Results Modal -->
        <section class="search-section" style="text-align: center; padding: 100px 0; position: relative;">
            <div>
                <h2>Search for Tutors by Subject</h2>
                <p>Enter the subject you need help with, and we'll find the best tutors for you.</p>
                <form id="searchForm" method="GET" action="">
                    <input type="text" id="subject" name="subject" required placeholder="Enter a subject (e.g., Math, Science)" style="padding: 10px; width: 300px; border-radius: 5px; border: 1px solid #ccc;">
                    <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px;">Search</button>
                </form>
            </div>
        </section>

 

    <!-- Featured Tutors -->
    <h1 id="tutor-header" style="text-align: center; margin-bottom: 20px; font-size: 28px;">Featured Tutors</h1>
    <section class="featuredTutor-carousel" style="position: relative; width: 100%; max-width: 1200px; margin: auto; overflow: hidden;">
        <button class="carousel-btn left" onclick="moveLeft()" style="position: absolute; top: 50%; left: 0; transform: translateY(-50%); background-color: #333; color: white; border: none; padding: 10px 20px; cursor: pointer;">&lt;</button>

        <div class="featuredTutor-column" id="tutorCarousel" style="display: flex; gap: 20px; padding: 20px 0; overflow-x: scroll; scroll-behavior: smooth;">

            <?php
                include 'db_connection.php'; // Adjust the file path as necessary

                // Check if the search term is set
                $searchTerm = isset($_GET['subject']) ? trim($_GET['subject']) : '';

                // Prepare the SQL query with a WHERE clause to filter by subject
                if ($searchTerm) {
                    $stmt = $db->prepare("SELECT tutor_id, name, surname, bio, image_path, preferred_tutoring_mode, price, subjects FROM tutors WHERE subjects LIKE ?");
                    $likeSearchTerm = "%{$searchTerm}%"; 
                    $stmt->bind_param("s", $likeSearchTerm);
                    $stmt->execute();
                    $result = $stmt->get_result();
                } else {
                    $result = $db->query("SELECT tutor_id, name, surname, bio, image_path, preferred_tutoring_mode, price, subjects FROM tutors");
                }

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tutor_id = $row['tutor_id'];
                        $name = htmlspecialchars($row['name'] ?? ''); 
                        $surname = htmlspecialchars($row['surname'] ?? ''); 
                        $subject_expertise = htmlspecialchars($row['subjects'] ?? '');
                        $bio = htmlspecialchars($row['bio'] ?? '');
                        $image_path = !empty($row['image_path']) ? htmlspecialchars($row['image_path']) : 'default_tutor_image.jpg'; 
                        $preferred_tutoring_mode = htmlspecialchars($row['preferred_tutoring_mode'] ?? '');
                        $price = htmlspecialchars($row['price'] ?? '');

                        // Generate the HTML for the tutor block
                        echo "
                        <article class=\"tutor-blocks\" style=\"flex: 0 0 250px; text-align: center; border: 1px solid #ddd; border-radius: 10px; padding: 20px; background-color: #f9f9f9;\">
                            <a href=\"tutorProfile.php?tutor_id={$tutor_id}\" style=\"text-decoration: none; color: #333;\">
                                <img src=\"{$image_path}\" class=\"tutor-images\" alt=\"{$name}\" style=\"width: 100%; height: 150px; object-fit: cover; border-radius: 8px;\">
                                <h4 style=\"margin-top: 10px; font-size: 18px; color: #444;\">{$name} {$surname} - {$subject_expertise}</h4>
                                <p style=\"font-size: 14px; color: #555;\">{$bio}</p>
                            </a>
                            <button id=\"openModalBtn{$tutor_id}\" class=\"reviewButton\" style=\"background-color: #007bff; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer;\" title=\"Press Me!\"><strong>Rate Tutor</strong></button>
                        </article>";
                    }
                } else {
                    echo "<p>No featured tutors available at the moment.</p>";
                }
            ?>

        </div>
        <button class="carousel-btn right" onclick="moveRight()" style="position: absolute; top: 50%; right: 0; transform: translateY(-50%); background-color: #333; color: white; border: none; padding: 10px 20px; cursor: pointer;">&gt;</button>
    </section>

    <!-- JavaScript for Carousel -->
    <script>
        const tutorCarousel = document.getElementById('tutorCarousel');
        const blockWidth = tutorCarousel.querySelector('.tutor-blocks').offsetWidth + 20; // Block width + gap

        function moveLeft() {
            tutorCarousel.scrollLeft -= blockWidth; // Scroll left by the width of one block
        }

        function moveRight() {
            tutorCarousel.scrollLeft += blockWidth; // Scroll right by the width of one block
        }

        // Auto-scroll every 8 seconds (Optional)
        setInterval(() => {
            moveRight();
        }, 8000);
    </script>


            

                <!-- <article class="tutor-blocks">
                    <a href="tutor_profile.php?id=1"> <!-- Replace '1' with the tutor's ID 
                        <img src="images/mtho.jpeg" class="tutor-images" alt="Mthobisi Latha" width="100" height="150" style="object-fit: cover;">
                        <h4>Mtho - Math 3 Expert</h4>
                        <p>Mtho specializes in algebra and calculus, with over 10 years of experience.</p>
                    </a>
                    <button id="openModalBtn1" class="reviewButton" title="Press Me!"><strong>Rate Tutor</strong></button>
                </article>
        
                <article class="tutor-blocks">
                    <a href="tutor_profile.php?id=2"> <!-- Tutor 2 ID 
                        <img src="images/kwenza.jpeg" class="tutor-images" alt="Kwenza Hadebe" width="100" height="150" style="object-fit: cover;">
                        <h4>Kwenza - CS3 Guru</h4>
                        <p>Kwenza has a passion for Java (Data structures) and compilers, making complex topics easy to understand.</p>
                    </a>
                    <button id="openModalBtn2" class="reviewButton" title="Press Me!"><strong>Rate Tutor</strong></button>
                </article>
        
                <article class="tutor-blocks">
                    <a href="tutor_profile.php?id=3"> <!-- Tutor 3 ID 
                        <img src="images/rinae.jpeg" class="tutor-images" alt="Rinae Makhado" width="100" height="150" style="object-fit: cover;">
                        <h4>Rinae - IS3 Specialist</h4>
                        <p>Rinae offers tutoring in Data Analysis and SQL, helping students become experts.</p>
                    </a>
                    <button id="openModalBtn3" class="reviewButton" title="Press Me!"><strong>Rate Tutor</strong></button>
                </article>
        
                <article class="tutor-blocks">
                    <a href="tutor_profile.php?id=4"> <!-- Tutor 4 ID 
                        <img src="images/siya.jpeg" class="tutor-images" alt="Siyabulela Gongqa" width="100" height="150" style="object-fit: cover;">
                        <h4>Siya - Accounting 3 Master</h4>
                        <p>Siya offers tutoring in Taxation, Auditing, and cash flows. People call him the king of balancing books.</p>
                    </a>
                    <button id="openModalBtn4" class="reviewButton" title="Press Me!"><strong>Rate Tutor</strong></button>
                </article>
        
                <article class="tutor-blocks">
                    <a href="tutor_profile.php?id=5"> <!-- New Tutor ID 
                        <img src="images/new_tutor.jpeg" class="tutor-images" alt="New Tutor" width="100" height="150" style="object-fit: cover;">
                        <h4>New Tutor - Subject Expertise</h4>
                        <p>Description of the new tutor goes here.</p>
                    </a>
                    <button id="openModalBtn5" class="reviewButton" title="Press Me!"><strong>Rate Tutor</strong></button>
                </article> -->
        


      <!-- The modal -->
      <div id="modalOverlay" class="modal-overlay">
      <div class="modal" id="myModal">

          <!-- the pop up form -->
          <div class="modal-content">
              <span class="close" id="closeModal1">&times;</span>
              <h2>Rate Your Experience</h2>
              <p>Your Feedback is Highly Valued</p>
              <form class="popupForm">
                  <div class="star-rating">
                      <span class="star" data-value="5">&#9733;</span>
                      <span class="star" data-value="4">&#9733;</span>
                      <span class="star" data-value="3">&#9733;</span>
                      <span class="star" data-value="2">&#9733;</span>
                      <span class="star" data-value="1">&#9733;</span>
                  </div>
                  <div class="rating-value">Rating: 0</div>
                  <textarea id="comments" name="comments" rows="4" placeholder="Write your thoughts here..."></textarea><br><br>
                  <button class="submitButton" type="submit">Submit</button>
              </form>
          </div>
          
      </div>
  

    
    </main>

  
    <!-- FOOTER -->
    <footer > 
        <p>&copy; 2024 TutorConnect. All rights reserved.</p>
        <p>Authors: Kwenza Hadebe | Rinae Makhado | Siyabulela Gongqa | Mthobisi Latha</p>
        <p>Contact: <a href="mailto:hadebezohh@gmail.com">hadebezohh@gmail.com</a></p>
        <p>Follow us on:
          <a href="https://facebook.com/tutorconnect" target="_blank" style="color: black;">Facebook</a> |
          <a href="https://twitter.com/tutorconnect" target="_blank" style="color: black;">Twitter</a> |
          <a href="https://instagram.com/tutorconnect" target="_blank" style="color: black ;">Instagram</a>
        </p>
      </footer>

      
      <!-- Back to Top Button -->
<button id="backToTopBtn" class="back-to-top" onclick="scrollToTop()">&#8679; Back to Top</button>
<script src="script.js"></script>


<!-- review pop up form -->
<!-- <script>
    document.addEventListener('DOMContentLoaded', () => {
    const openModalBtn1 = document.getElementById('openModalBtn1');
    const modalOverlay = document.getElementById('modalOverlay');
    const modalContent = document.getElementById('myModal');

    // Function to fetch and load external form
    function loadForm() {
        fetch('reviewForm.html') // Specify the path to your form HTML file
            .then(response => response.text())
            .then(data => {
                modalContent.innerHTML = data; // Insert the form HTML
                modalOverlay.style.display = 'flex'; // Show the modal
            })
            .catch(error => console.error('Error loading form:', error));
    }

    // Open modal on button click
    openModalBtn1.addEventListener('click', () => {
        loadForm(); // Load form when button is clicked
    });

    // Close modal when clicking outside or on close button
    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('modal-overlay') || event.target.classList.contains('close')) {
            modalOverlay.style.display = 'none'; // Hide the modal
        }
    });
}); -->


</body>

</html>