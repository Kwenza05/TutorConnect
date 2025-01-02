<?php
session_start();

// Check if the user is logged in by verifying the session
if (!isset($_SESSION['user_id']) && !isset($_SESSION['tutor_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include database connection file
include 'db_connection.php';

// Determine which ID to use
$tutling_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $_SESSION['tutor_id'];
// storing this global variable for updating
$_SESSION['tutling_id'] = $tutling_id;


// Fetch tutor's details from the database
$sql = "SELECT name, surname, email, phone, image_path, preferred_tutoring_mode FROM tutlings WHERE tutling_id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $tutling_id);
$stmt->execute();
$stmt->bind_result($name, $surname, $email, $phone, $profile_image, $tutoringType );
$stmt->fetch();
$stmt->close();
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }

        /* Header Styles */
        header {
            background-color: #13536e;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header img {
            width: 150px;
            display: block;
            margin: 0 auto 10px;
        }

        header h1 {
            font-size: 2em;
            margin: 0;
        }

        /* Profile Container */
        .profile-container {
            width: 80%;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            text-align: center;
        }

        .profile-header img {
            border-radius: 50%;
            width: 150px;
            margin-bottom: 20px;
        }

        .profile-header h2 {
            color: #333;
        }

        .profile-header p {
            color: #666;
            margin: 5px 0; /* Add margin for spacing */
        }

        /* Form Styles */
        .profile-form {
            margin-top: 20px;
        }

        .profile-form label {
            font-size: 1.1em;
            color: #000000;
            display: block;
            margin-bottom: 5px;
        }

        .profile-form input, 
        .profile-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        .profile-form button {
            background-color: #13536e;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            text-align: center;
        }

        .profile-form button:hover {
            background-color: #75E6DA;
        }

        /* Back Button */
        .back-button {
            display: block;
            text-align: center;
            margin: 20px auto;
            background-color: #13536e;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #75E6DA;
        }

        /* Subject List */
        .subject-list {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .subject-list span {
            display: inline-block;
            background-color: #e2e6ea;
            color: #000000;
            padding: 15px;
            padding-right: 25px;
            margin: 5px 5px 0 0;
            border-radius: 20px;
            font-size: 1em;
            position: relative;
        }

        .subject-list span button {
            background-color: transparent;
            border: none;
            color: #0011ff;
            font-size: 0.9em;
            margin-left: 10px;
            cursor: pointer;
            position: absolute;
            top: 0;
            right: 0;
            padding: 5px 10px;
            margin-left: 50px;
            border-radius: 50%;
            line-height: 1;
        }

        .subject-list span button:hover {
            color: #cc0000;
        }
    </style>
</head>
<body>

    <header>
        <img src="images/lgRemoved.png" alt="TutorConnect Logo">
        <h1>Student Profile</h1>
    </header>

    <div class="profile-container">
        <div class="profile-header">
            <img src="<?php echo !empty($profile_image) ? htmlspecialchars($profile_image) : 'images/dummy.jpg'; ?>" alt="Profile Picture" id="profile-pic-preview">
            <h2 id="student-name"><?php echo htmlspecialchars($name) ?></h2>
            <p id="student-last-name"><?php echo htmlspecialchars($surname) ?></p> <!-- Add last name display -->
        </div>

        <!-- Student Profile Form -->
        <form class="profile-form" action="tuteeUpdate.php" method="POST" enctype="multipart/form-data" onsubmit="return showSelectedSubjects()">
            <!-- Personal Details Section -->
            <label for="name">First Name:</label>
            <input type="text" id="name" name="name" required oninput="updateProfileName()" readonly value="<?php echo htmlspecialchars($name) ?>">

            <label for="last-name">Last Name:</label>
            <input type="text" id="last-name" oninput="updateProfileName()" readonly value="<?php echo htmlspecialchars($surname) ?>" >
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required readonly value="<?php echo htmlspecialchars($email) ?>">

            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" placeholder="<?php echo htmlspecialchars($phone) ?>" required>

            <!-- Profile Picture Upload -->
            <label for="profile-pic">Upload Your Profile Picture:</label>
            <input type="file" id="profile-pic" name="profile-pic" accept="image/*" required onchange="previewImage(event)">

            <!-- Preview Image -->
            <div>
                <img id="image-preview" src="#" alt="Image Preview" style="display: none; width: 150px; border-radius: 50%; margin-top: 10px;">
            </div>

            <!-- Subject List Display -->
            <div class="subject-list" id="subject-list">
                <!-- Subjects will be displayed here -->
            </div>

            <!-- Hidden input to collect all subjects -->
            <input type="hidden" id="subjects" name="subjects">

            <!-- Tutoring Mode Section -->
            <br><br><br>
             <div class="form-group">
                <label>Where Will Your Lessons Take Place?</label>
                <table>
                    <tr>
                        <td><label style="padding-bottom: 15px;">online</label></td>
                        <td><input type="radio" name="tutoringType" value="online"></td>
                    </tr>
                    <tr>
                        <td><label style="padding-bottom: 15px;">In-Person</label></td>
                        <td><input type="radio" name="tutoringType" value="in-person"></td>
                    </tr>
                </table>
                
                
            </div>

            <!-- Submit Button -->
            <button type="submit">Submit Profile</button>
        </form>

        <!-- Back to Dashboard Button -->
        <a href="tutee_dashboard.php" class="back-button">Back to Dashboard</a>
    </div>

    <script>

        function previewImage(event) {
            const file = event.target.files[0];
            const img = document.getElementById('profile-pic-preview');
            const imagePreview = document.getElementById('image-preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result; // Update the image source to the uploaded image
                    imagePreview.src = e.target.result; // Set the preview to show the uploaded image
                    imagePreview.style.display = 'block'; // Display the image preview
                }
                reader.readAsDataURL(file);
            }
        }

        function updateProfileName() {
            const name = document.getElementById('name').value;
            const lastName = document.getElementById('last-name').value;
            document.getElementById('student-name').textContent = name;
            document.getElementById('student-last-name').textContent = lastName; // Update last name display
        }

        function showSelectedSubjects() {
            // This function can be used to handle any additional validation before form submission
            return true; // Allow form submission
        }
    </script>
</body>
</html>
