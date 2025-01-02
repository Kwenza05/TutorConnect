<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TutorConnect - Register</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Basic reset */
body, html {
  margin: 0;
  padding: 0;
  font-family: 'Roboto', sans-serif;
}
/* Centering the headings */
h1, h2 {
  text-align: center;
  color: #05445E;
  font-family: 'Roboto', sans-serif;
  font-weight: bold;
}
a {
  color: #189AB4;
  text-decoration: none;
}
a:hover {
  color: #05445E; /* Color on hover */
}



/* Navigation styling */
nav {
  background-color: #13536e; /* Background color for the navigation bar */
}

.menu-toggle {
  display: none;
}

.menu-icon {
  display: none;
}

.nav-list {
  list-style-type: none;
  margin: 0;
  padding: 0;
  text-align: center;
}

.nav-list li {
  display: inline-block;
  margin: 0;
  padding: 0;
}

.nav-list li a {
  color: white;
  text-decoration: none;
  padding: 15px 20px;
  display: inline-block;
}

.nav-list li a:hover,
.nav-list li.active a {
  background-color: #75E6DA;
  color: white;
}

/* Dropdown menu */
.dropdown {
  display: none;
  position: absolute;
  background-color: #13536e;
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.nav-list li:hover .dropdown {
  display: block;
}

.dropdown li {
  display: block;
}

.dropdown li a {
  padding: 10px 20px;
}

/* Form section styling */
main {
  padding: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

form {
  border: 2px solid #05445E; /* Border color and width */
  border-radius: 8px; /* Rounded corners */
  padding: 20px;
  background: white;
  max-width: 500px; /* Max width of the form */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: shadow for better visual separation */
  width: 100%;
}

form h2 {
  text-align: center;
  color: #05445E;
}

form label {
  display: block;
  margin-bottom: 5px;
  color: #2c3e50;
}

form input[type="text"],
form input[type="email"],
form textarea {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
  box-sizing: border-box;
  margin-bottom: 10px; /* Space between fields */
}

form input[type="submit"] {
  width: 100%;
  padding: 10px;
  background-color: #05445E;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}

form input[type="submit"]:hover {
  background-color: #2c3e50;
}
*{box-sizing: border-box;
}
     </style>

</head>
<body>
    <!-- Header -->
    <header style="background: url('background.jpg') no-repeat center center; background-size: cover; padding: 120px; text-align: center; color: white;">
        <img src="logo1.png" alt="TutorConnect Logo" style="position: absolute; top: 20px; left: 20px; width: 110px; height: auto;">
    </header>

    <!-- NAVIGATION -->
<nav>

    <input type="checkbox" id="menu-toggle" class="menu-toggle" />
    <label for="menu-toggle" class="menu-icon">☰ Menu</label>
  
    <ul class="nav-list" >
      <li ><a href="index.php">Home</a></li>
      <li><a href="findtutor.php">Find a Tutor</a></li>
      </li>
      <li><a href="about.html">About Us</a></li>
      <li><a href="contact.html">Contact</a></li>
      <li><a href="reviews.html">Reviews</a></li>
    </ul>
  </nav>

  <section class="registerForm" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div style="border: 1px solid #ccc; padding: 20px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center;">Register as a New User</h2>

        <?php if (isset($_GET['error']) && $_GET['error'] == 'duplicate'): ?>
        <p style="color: red;">Email already exists. Please use another email.</p>
    <?php endif; ?>

        <form id="registrationForm" action="register_user.php" method="POST" onsubmit="return validateForm()">

            <table>
                <!-- Name and Surname -->
                <tr>
                    <td><label for="name">First Name:</label></td>
                    <td><input type="text" id="name" name="name" value="<?= isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '' ?>" required></td>
                    <td><span class="error" id="nameError"></span></td>
                </tr>
                <tr>
                    <td><label for="surname">Surname:</label></td>
                    <td><input type="text" id="surname" name="surname" value= "<?= isset($_GET['surname']) ? htmlspecialchars($_GET['surname']) : '' ?>" required></td>
                    <td><span class="error" id="surnameError"></span></td>
                </tr>

                <!-- Email and Phone Number -->
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" id="email" name="email" required></td>
                    <td><span class="error" id="emailError"></span></td>
                </tr>
                <tr>
                    <td><label for="phone">Phone Number:</label></td>
                    <td><input type="tel" id="phone" name="phone" pattern="[0-9]{10}" title="Enter a 10-digit phone number" value="<?= isset($_GET['phone']) ? htmlspecialchars($_GET['phone']) : '' ?>"
                       required></td>
                    <td><span class="error" id="phoneError"></span></td>
                </tr>

                <!-- Password -->
                <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input type="password" id="password" name="password" required></td>
                    <td><span class="error" id="passwordError"></span></td>
                </tr>

                <!-- Checkbox for Role (Tutor or Tutee) -->
                <tr>
                    <td><label>Are you registering as:</label></td>
                    <td>
                        <input type="checkbox" id="tutor" name="role" value="tutor" onclick="onlyOne(this)"> Tutor
                        <input type="checkbox" id="tutee" name="role" value="tutee" onclick="onlyOne(this)"> Tutee
                    </td>
                </tr>
            </table>

            <br>
            <button type="submit">Sign Up</button>
        </form>

        <br>
        <a href="index.php">Back to Home</a>
    </div>
</section>
<script>
  function validateForm() {
      // Get form values
      var name = document.getElementById("name").value;
      var surname = document.getElementById("surname").value;
      var email = document.getElementById("email").value;
      var phone = document.getElementById("phone").value;
      var password = document.getElementById("password").value;
      var tutor = document.getElementById("tutor").checked;
      var tutee = document.getElementById("tutee").checked;

      var isValid = true;

      // Name validation
      if (name === "") {
          document.getElementById("nameError").textContent = "First name is required";
          isValid = false;
      } else {
          document.getElementById("nameError").textContent = "";
      }

      // Surname validation
      if (surname === "") {
          document.getElementById("surnameError").textContent = "Surname is required";
          isValid = false;
      } else {
          document.getElementById("surnameError").textContent = "";
      }

      // Email validation
      var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
      if (!emailPattern.test(email)) {
          document.getElementById("emailError").textContent = "Please enter a valid email address";
          isValid = false;
      } else {
          document.getElementById("emailError").textContent = "";
      }

      // Phone number validation (10 digits)
      var phonePattern = /^[0-9]{10}$/;
      if (!phonePattern.test(phone)) {
          document.getElementById("phoneError").textContent = "Please enter a valid 10-digit phone number";
          isValid = false;
      } else {
          document.getElementById("phoneError").textContent = "";
      }

      // Password validation
      if (password === "") {
          document.getElementById("passwordError").textContent = "Password is required";
          isValid = false;
      } else if (password.length < 6) {
          document.getElementById("passwordError").textContent = "Password must be at least 6 characters";
          isValid = false;
      } else {
          document.getElementById("passwordError").textContent = "";
      }

      // Role validation (Tutor or Tutee must be selected)
      if (!tutor && !tutee) {
          alert("Please select whether you are registering as a Tutor or Tutee");
          isValid = false;
      }

      // Return true if form is valid
      return isValid;
  }

  // Ensure only one checkbox (Tutor or Tutee) is selected
  function onlyOne(checkbox) {
      var checkboxes = document.getElementsByName("role");
      checkboxes.forEach((item) => {
          if (item !== checkbox) item.checked = false;
      });
  }
</script>


<!-- Footer -->
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

