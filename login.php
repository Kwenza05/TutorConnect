
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TutorConnect - Login</title>
    <link rel="stylesheet" href="login.css">
    <style>
            /* google fonts */
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Playfair+Display:wght@700&display=swap');
/* Background image layer */
.background-image {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url('background.jpg'); 
  background-size: cover; /* Cover the entire element */
  background-position: center; /* Center the background image */
  filter: blur(8px); /* Apply the blur effect */
  -webkit-filter: blur(8px); /* For Safari */
}

/* Main content container */
.content-container {
  position: relative;
  top: 30vh;
  padding: 10px;
  max-width: 600px;
  margin: 0 auto;
  background: rgba(255, 255, 255, 0.5); /* Slightly transparent white background for readability */
  border-radius: 90px; /*rounded corners */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: shadow for better visual separation */
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 30vh; /* Ensure the content container takes full viewport height */
}
/*end of code for login page*/
/* Change the link color */
a {
color: #189AB4;
left: 100%;

}
a:hover {
color: #05445E; /* Color on hover */

}


/* Form section styling */
.form-section {
  width: 100%;
  align-items: center;
  text-align: center;
  font-weight: bold;
  color: #2c3e50;
}

/* Add space between form rows */
.form-group {
margin-bottom: 10px; /* Space between rows */
}



table {
  width: 100%;
  margin: 0 auto;
}

td {
  padding: 10px;
}

label {
font-size: 16px; /* Change the font size */
color: #2c3e50; /* Change the text color */
margin-bottom: 5px; /* Space below the label */
display: block; /* Makes the label take full width */
font-family: 'Roboto', sans-serif;
font-weight: bold;
}


input[type="text"], input[type="password"] {
  width: 80%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 70px;
  font-family: 'Roboto', sans-serif;
  box-sizing: border-box; /* Include padding and border in element's total width and height */
  margin-bottom: 10px; /* Space between fields */
  margin-right: 50%;
}

input[type=submit] {
  font-family: 'Roboto', sans-serif;
  background-color: #13536e;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
  margin-left: 120%;
}

input[type="submit"]:hover {
  background-color: #2c3e50;
}


        /* Highlighted password field style */
        .error-highlight {
            border: 2px solid red; /* Red border to highlight the password input */
        }

    </style>
</head>
<body>

    <!-- Background Container -->
    <div class="background-container">
        <div class="background-image"></div>
    </div>



    <!-- Main Content -->
    <main class="content-container">
      <section class="form-section">
        <h2>Login to Your Account</h2>      
        <form action="process_login.php" method="POST"> <!-- Ensure this points to your processing PHP file -->
            <table>
                <tr>
                    <td><label for="email"><i>Email:</i></label></td> <!-- Change to Email -->
                    <td>
                        <!-- Pre-fill the email field if there is an error -->
                        <input type="text" id="email" name="email" required placeholder="example@example.com" 
                        value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>"> <!-- Keeps the entered email -->
                    </td>
                </tr>
    
                <tr>
                    <td><label for="password"><i>Password:</i></label></td>
                    <td>
                        <input type="password" id="password" name="password" required 
                        class="<?php echo isset($_GET['error']) && $_GET['error'] == "invalid_password" ? "error-highlight" : ''; ?>">
                        
                    </td>
                </tr>
    
                <tr>
                    <td><input type="submit" value="Login" title="Login your account"></td>
                </tr>
            </table>
        </form>
    
        <br>
        <a href="index.php">Back to Home</a> |
        <a href="register.php">Create an Account</a>

         <!-- Error message will appear here -->
         <?php
            // Check if there's an error message in the URL
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 'no_account') {
                    echo "<p style='color:red;'>No account found with that email.</p>";
                } elseif ($_GET['error'] == 'invalid_password') {
                    echo "<p style='color:red;'>Invalid password. Please try again.</p>";
                }
            }
          ?>
    </section>
    
    </main>
    
</body>

</html>

