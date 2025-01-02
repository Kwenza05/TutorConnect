<?php
session_start();

// Check if the user is logged in by verifying the session
if (!isset($_SESSION['userID'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include database connection file
include 'db_connection.php';

$tutor_id = $_SESSION['userID'];

// Fetch tutor's details from the database
$sql = "SELECT name, surname, email, phone, bio, image_path FROM tutors WHERE tutor_id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $tutor_id);
$stmt->execute();
$stmt->bind_result($name, $surname, $email, $phone, $bio, $profile_image);
$stmt->fetch();
$stmt->close();
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Profile</title>
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
            margin: 5px 0;
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
        <h1>Edit Tutor Profile</h1>
    </header>

    <div class="profile-container">
        <div class="profile-header">
            <img src="<?php echo !empty($profile_image) ? htmlspecialchars($profile_image) : 'images/dummy.jpg'; ?>" alt="Profile Picture" id="profile-pic-preview">
            <h2 id="tutor-name"><?php echo htmlspecialchars($name) ?></h2>
            <p id="tutor-last-name"><?php echo htmlspecialchars($surname) ?></p>
        </div>

        <!-- Tutor Profile Form -->
        <form class="profile-form" action="tutor_edit_profile.php" method="POST" enctype="multipart/form-data" onsubmit="return showSelectedSubjects()">
            <!-- Personal Details Section -->
            <label for="name">First Name:</label>
            <input type="text" id="name" name="name" required oninput="updateProfileName()" readonly value="<?php echo htmlspecialchars($name) ?>">

            <label for="last-name">Last Name:</label>
            <input type="text" id="last-name" oninput="updateProfileName()" readonly value="<?php echo htmlspecialchars($surname) ?>">
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required readonly value="<?php echo htmlspecialchars($email) ?>">

            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" required value="<?php echo htmlspecialchars($phone) ?>" >

            <label for="bio">Short Bio:</label>
            <textarea id="bio" name="bio" rows="4" required><?php if (!empty($bio)) echo htmlspecialchars($bio); ?></textarea>

            <label for="profile-pic">Upload Your Profile Picture:</label>
            <input type="file" id="profile-pic" name="profile-pic" accept="image/*" required onchange="previewImage(event)">

            <!-- Preview Image -->
            <div>
                <img id="image-preview" src="#" alt="Image Preview" style="display: none; width: 150px; border-radius: 50%; margin-top: 10px;">
            </div>

            <!-- Subjects Section -->
            <label for="subjects">What Subject Do You Teach?</label>
            <select name="subjects">
                <option value="Mathematics">Mathematics</option>
                <option value="Science">Science</option>
                <option value="English">English</option>
                <!-- Add other subjects as needed -->
            </select>

            <!-- Container for displaying selected subjects 
         <!--    <div class="subject-list" id="subject-list"></div> 

             Button to add selected subjects
           <!--  <button type="button" onclick="addSubject()">Add Selected Subjects</button>

            <!-- Hidden input to collect all subjects 
            <input type="hidden" id="subjects-input" name="subjects">

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

            <!-- Pricing Section -->
            <label for="price">Pricing per Hour (in Rands):</label>
            <input type="number" id="price" name="price" required min="0" step="0.01" placeholder="Enter your price in Rands">

            <!-- Submit Button -->
            <button type="submit">Submit Profile</button>
        </form>

        <!-- Back to Dashboard Button -->
        <a href="tutor_dashboard.php" class="back-button">Back to Dashboard</a>
    </div>

 

</body>
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('image-preview');

        // Check if a file was selected
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Set the src of the preview image to the selected file
                preview.src = e.target.result;
                preview.style.display = 'block';  // Make the preview image visible
            };

            // Read the selected image file as a data URL
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</html>


