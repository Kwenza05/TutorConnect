<?php
// Start session to access the session variables
session_start();

// Include database connection file
include 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['logged_in_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if form is submitted and contains a request and a tutor ID
if (isset($_POST['request_status']) && isset($_POST['tutor_id'])) {
    $tutling_id = $_SESSION['logged_in_id']; // Get the logged-in ID from the session
    $tutor_id = intval($_POST['tutor_id']); // Get the tutor ID from the hidden input field
    $request_status = $db->real_escape_string($_POST['request_status']); // Sanitize the request status
  
    
    // Insert the request into the tutor_requests table
    $query = "INSERT INTO tutor_requests (tutling_id, tutor_id, request_status)
              VALUES ('$tutling_id', '$tutor_id', '$request_status' )";

    // Execute the query and check if the request was successful
    if ($db->query($query)) {
        echo 'Request sent successfully!';
    } else {
        echo 'Error: ' . $db->error;
    }
} else {
    echo 'Please provide a valid request and ensure the tutor ID is set.';
}
?>