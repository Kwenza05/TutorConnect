<?php
session_start();
include 'db_connection.php';

// Check if tutoring ID is set in session
if (!isset($_SESSION['tutling_id'])) {
    die(" Error: Tutoring ID is not set in the session.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if POST variables are set
    if (!isset($_POST['tutor_id']) || !isset($_POST['message'])) {
        die("Error: Tutor ID or message not provided.");
    }
    
    $tutling_id = $_SESSION['tutling_id'];  
    $tutor_id = $_POST['tutor_id'];
    $message = $_POST['message'];
    $sent_at = date('Y-m-d H:i:s');  // Current timestamp

    // Insert the message into the database
    $sql = "INSERT INTO messages (tutling_id, tutor_id, message, sent_at, sender) VALUES (?, ?, ?, ?, 'student')";
    $stmt = $conn->prepare($sql);
    
    // Check if prepare was successful
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("iiss", $tutling_id, $tutor_id, $message, $sent_at);
    
    if ($stmt->execute()) {
        header("Location: messages.html");  
        exit; // Terminate the script after redirect
    } else {
        echo "Error sending message: " . $stmt->error; // More specific error
    }

    $stmt->close();
    $conn->close();
}
?>

