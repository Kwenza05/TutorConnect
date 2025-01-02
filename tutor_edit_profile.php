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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form submission
    
    // Fetch the submitted form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $bio = $_POST['bio'];
    $profile_pic = $_FILES['profile-pic'];
    $price = $_POST['price'];
    $tutoringType = $_POST['tutoringType']; // Get tutoringType from radio button

    // Get the selected subject (single subject)
    if (isset($_POST['subjects'])) {
        $subject = htmlspecialchars($_POST['subjects']);
    } else {
        $subject = ''; // Handle case where no subject is selected
    }

    // Process file upload for the profile picture
    if ($profile_pic['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $profile_pic['tmp_name'];
        $filename = basename($profile_pic['name']);
        $destination = "uploads/" . $filename;
        
        // Move the uploaded file to the destination directory
        if (move_uploaded_file($tmp_name, $destination)) {
            // File upload successful, store the file path
            $image_path = $destination;
        } else {
            // Handle file upload error
            $image_path = null;
        }
    }

    // Insert or update the tutor's information in the database
    $tutor_id = $_SESSION['userID'];

    $sql = "UPDATE tutors SET phone = ?, bio = ?, image_path = ?, price = ?, preferred_tutoring_mode = ? , subjects = ? WHERE tutor_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sssdssi", $phone, $bio, $image_path, $price, $tutoringType , $subject, $tutor_id );
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
         // Update successful, redirect to profile page or show success message
         header("Location: tutor_profile.php?subject=" . $subject);
         exit();
    } else {
        // Handle update error
        echo "Error updating profile.";
    }

    $stmt->close();
    $db->close();
}
?>
