<!doctype html> 
<html lang="en"> 
  <head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TutorConnect</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="reviewformStyling.css">

    
    <style>
      body {
          font-family: Arial, sans-serif;
          padding: 20px;
      }
      .info {

          padding: 10px;
          background-color: #f0f0f0;
          border-radius: 5px;
      }
    </style>
  </head> 
  <body>  	     
  <!-- HEADER -->
  <header style="background-image: url('images/BrightFooter.png'); background-size: cover; background-position: center; padding: 200px;">
    <!-- Auth Buttons -->
    <div class="auth-buttons">
        <a href="login.php" class="btn">Log In</a>
        <a href="register.php" class="btn">Sign Up</a>
    </div>
  

  <!-- Content Container -->
  <div class="container">
      <!-- Text Content -->
      <div class="text-content">
          <h1 id="h1-header">Welcome to TutorConnect!</h1> 
          <p>Your one-stop platform to connect with a tutor of your choice.</p>
      </div>
  </div>
</header>

<style>
  /* Auth buttons for login and register */
  .auth-buttons {
      position: absolute;
      top: 20px;
      right: 20px;
  }


  .auth-buttons a {
      color: white;
      text-decoration: none;
      margin: 0 10px;
      padding: 10px 20px;
      border: 1px solid white;
      border-radius: 5px;
      transition: background-color 0.3s;
  }

  .auth-buttons a:hover {
      background-color: #189AB4; /* Lighter Teal on hover */
  }

  /* Container for content */
  .container {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
  }

  /* Text content */
  .text-content h1 {
      font-size: 3.5em;
      color: #75E6DA;
      text-shadow: 3px 3px 0 #000000, 6px 6px 0 #1ca5c0, 9px 9px 0 #011f1c; /* 3D shadow effect with the palette */
      transition: transform 0.3s ease-in-out, color 0.3s ease-in-out;
      cursor: pointer;
  }

  .text-content p {
      color: #D4F1F4;
  }

  .text-content h1:hover {
      transform: scale(1.2);
      color: #05445E; /* Dark Teal on hover */
  }

  /* Bouncing animation */
  @keyframes bounce {
      0% { transform: translateY(0); }
      50% { transform: translateY(-15px); }
      100% { transform: translateY(0); }
  }

  /* Trigger bounce effect */
  .bounce {
      animation: bounce 0.5s;
  }
  /*pics */
  /* General Styles for Larger Screens */
.text-info {
  display:flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 40px;
}

.text-info .text {
  flex: 5; /* Text takes up half of the container */
}

.text-info .image {
  flex: 1 0 7%; /* Image takes up 30% of the container width */
  padding-left: 50px; /* Adds some spacing between text and image */
}

.text-info .image img {
  max-width: 60%; /* Makes the image fully responsive */
  height: auto;
  border-radius: 80px; /* Optional: Add rounded corners */
}

/* Styles for Smaller Screens (Tablets and below) */
@media (max-width: 768px) {
  .text-info {
      flex-direction: column; /* Stack text and image vertically */
      align-items: flex-start; /* Align items to the start */
  }

  .text-info .image {
      padding-left: 0;
      margin-top: 10px; /* Add margin between text and image */
      width: 100%; /* Make the image take full width on smaller screens */
  }

  .text-info .image img {
      width: 100%; /* Ensures image stays responsive */
  }
}

/* Styles for Very Small Screens (Mobile Phones) */
@media (max-width: 480px) {
  .text-info .text, 
  .text-info .image {
      width: 100%; /* Text and image take full width on small screens */
  }

  .text-info .image img {
      width: 100%; /* Ensure image fits container */
      max-width: none; /* Prevent shrinking */
  }
}
</style>

<script>
  // Get the welcome text element
  const welcomeText = document.getElementById('h1-header');

  // Add an event listener to trigger bounce effect when clicked
  welcomeText.addEventListener('click', function() {
      welcomeText.classList.add('bounce');
      
      // Remove the bounce class after the animation to allow it to be triggered again
      setTimeout(function() {
          welcomeText.classList.remove('bounce');
      }, 500);  // Duration of the bounce animation
  });
</script>



    <!-- NAVIGATION -->
    <nav>

      <input type="checkbox" id="menu-toggle" class="menu-toggle" />
      <label for="menu-toggle" class="menu-icon">☰ Menu</label>

      <ul class="nav-list" >
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="findtutor.php">Find a Tutor</a></li>
        <li><a href="about.html">About Us</a></li>
        <li><a href="contact.html">Contact</a></li>
        <li><a href="reviews.html">Reviews</a></li>
      </ul>
    </nav>



  <!-- SIDEBAR -->
  <div class="sidebar">
    <ul>
      <li><a href="tutoring.html">Tutoring</a></li>
      <li><a href="consulting.html">Consulting</a></li>
      <li><a href="coaching.html">Coaching</a></li>
    </ul>
  </div>

    
<!-- MAIN CONTENT SECTION -->
<main style="padding: 20px; margin-top: 10px;">
  <!-- About TutorConnect -->
  <section class="text-info with-image">
    <div class="text">
      <h2>About TutorConnect</h2>
      <p>TutorConnect is dedicated to helping university students achieve their academic goals by connecting them with expert tutors. 
        Whether you need help with a challenging subject or want to excel in your studies, our tutors are here to guide you. 
        Our platform offers a simple way to browse through a variety of qualified tutors, each specializing in different subjects, 
        allowing you to find the best fit for your learning style.<br>

        With TutorConnect, you can choose one-on-one tutoring or group sessions, all tailored to your academic needs. 
        Our mission is to provide personalized support that helps you reach your full potential. Whether you are preparing for exams 
        or seeking to improve your grades, we are here to help you succeed.</p>
    </div>
    <div class="image">
      <img src="images\TeamInnovation.jpg" alt="About TutorConnect Image" />
    </div>
  </section>

  <!-- What We Offer -->
  <section class="text-info with-image">
    <div class="text">
      <h2>What We Offer</h2>
      <p>TutorConnect is dedicated to helping university students achieve their academic goals by connecting them with expert tutors. 
        Whether you need help with specific subjects or are aiming to excel, our tutors provide personalized, one-on-one sessions tailored to your needs.<br> 
        We cover a wide range of subjects, from core courses to specialized areas, ensuring that you can find the right tutor for your academic journey. 
        Our platform makes it easy to browse tutor profiles and select the perfect match to help you succeed.</p>
    </div>
    <div class="image">
      <img src="images\IllustrationBooks.jpg" alt="What We Offer Image" />
    </div>
  </section>

  <!-- How It Works -->
  <section class="text-info with-image">
    <div class="text">
      <h2>How It Works</h2>
      <ol>
        <li><strong>Sign Up:</strong> Create an account to get started.</li>
        <li><strong>Browse Tutors:</strong> Explore available tutors and their specialties.</li>
        <li><strong>Book a Session:</strong> Schedule a tutoring session that fits your needs.</li>
        <li><strong>Learn & Succeed:</strong> Improve your skills and achieve your academic goals!</li>
      </ol>
    </div>
    <div class="image">
      <img src="images\YakketyYak.jpg" alt="How It Works Image" />
    </div>
  </section>
</main>




   <!-- Container for browser information -->
<div id="browserInfo" class="info hide-info">
  <h3>Browser Information:</h3>
  <p id="browserDetails"></p>
</div>

<!-- Container for Java status -->
<div id="javaStatus" class="info hide-info">
  <h3>Java Enabled:</h3>
  <p id="javaResult"></p>
</div>

<!-- Container for location status -->
<div id="locationStatus" class="info hide-info">
  <h3>Your Location:</h3>
  <p id="locationResult">Getting location...</p>
</div>
<style>.hide-info {
  display: none;
}
</style>

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
  </div>

<!-- Chatbot HTML Structure -->
<div class="chatbot-container" id="chatbot" style="display: none;">
  <div class="chatbot-header">
      <span>Chat with us</span>
      <button id="close-chatbot" onclick="toggleChatbot()">x</button>
  </div>
  <div class="chatbot-content">
      <div class="chatbot-messages" id="chatbot-messages">
          <div class="message bot-message">
              <p>Hello! How can I assist you today?</p>
          </div>
      </div>
      <div class="chatbot-input">
          <input type="text" id="userMessage" placeholder="Type your message..." onkeydown="handleKeyPress(event)">
          <button onclick="sendMessage()">Send</button>
      </div>
  </div>
</div>

<!-- Floating button to open chatbot -->
<button class="open-chatbot-btn" id="open-chatbot-btn" onclick="toggleChatbot()">Chat</button>

<script>
// Function to toggle chatbot visibility
function toggleChatbot() {
    const chatbotContainer = document.getElementById('chatbot');
    chatbotContainer.style.display = (chatbotContainer.style.display === 'flex') ? 'none' : 'flex';
}

// Function to send a message
function sendMessage() {
    const userMessageInput = document.getElementById('userMessage');
    const messageText = userMessageInput.value;

    if (messageText.trim() === '') return; // Do not send empty messages

    // Append user message to the messages container
    const messageElement = document.createElement('div');
    messageElement.textContent = 'You: ' + messageText;
    document.getElementById('chatbot-messages').appendChild(messageElement);

    // Clear input field
    userMessageInput.value = '';

    // Get bot response
    getBotResponse(messageText);
}

// Function for bot response with keyword detection
function getBotResponse(userMessage) {
    const response = getResponseMessage(userMessage); // Get response based on user message
    const botMessageElement = document.createElement('div');
    botMessageElement.textContent = 'Bot: ' + response;
    document.getElementById('chatbot-messages').appendChild(botMessageElement);
}

// Define a function to get the bot's response based on user input using keyword detection
function getResponseMessage(userMessage) {
    userMessage = userMessage.toLowerCase(); // Normalize user input
    
    // Define keywords and responses
    const keywords = {
        "hi"  : "Hi, How can I help you today?",
        "tutor": "We have a variety of tutors available. What subject are you interested in?",
        "subject": "We offer tutoring in math, science, languages, and more. What do you need help with?",
        "register": "You can register as a tutor or a tutee on our website. Would you like more information?",
        "login": "Please enter your email and password to log in.",
        "help": "I'm here to assist you! What do you need help with?",
        "thanks": "You're welcome! If you have any more questions, feel free to ask.",
        "goodbye": "Goodbye! Have a great day!"
    };

    // Check for keywords in the user message
    for (const key in keywords) {
        if (userMessage.includes(key)) {
            return keywords[key];
        }
    }
    
    return "I'm sorry, I didn't understand that. Can you please rephrase?"; // Default response
}

// Handle Enter key press for sending messages
function handleKeyPress(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}
</script>

    <!-- FOOTER -->
    <footer style="  padding: 5px; color: black;"> 
      <p>&copy; 2024 TutorConnect. All rights reserved.</p>
      <p>Authors: Kwenza Hadebe | Rinae Makhado | Siyabulela Gongqa | Mthobisi Latha</p>
      <p>Contact: <a href="mailto:hadebezohh@gmail.com">hadebezohh@gmail.com</a></p>
      <p>Follow us on:
        <a href="https://facebook.com/tutorconnect" target="_blank" style="color: black;">Facebook</a> |
        <a href="https://twitter.com/tutorconnect" target="_blank" style="color: black;">Twitter</a> |
        <a href="https://instagram.com/tutorconnect" target="_blank" style="color: black;">Instagram</a>
      </p>
    </footer>
    <script src="script.js"></script>
    <button id="backToTopBtn" class="back-to-top" onclick="scrollToTop()">&#8679; Back to Top</button>
  </body> 
  <script src="script.js"></script>
</html>