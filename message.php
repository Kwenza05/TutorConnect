<?php
include 'db_connect.php'; // Include your database connection file

// Initialize message status variable
$messageStatus = '';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tutling_id']) && isset($_POST['tutor_id']) && isset($_POST['message']) && isset($_POST['sender'])) {
        // Retrieve and sanitize inputs
        $tutling_id = intval($_POST['tutling_id']); // Assuming tutling_id is an integer
        $tutor_id = intval($_POST['tutor_id']); // Assuming tutor_id is an integer
        $message = $db->real_escape_string($_POST['message']);
        $sender = $db->real_escape_string($_POST['sender']); // Can be 'tutling' or 'tutor'

        // Insert message into the messages table
        $query = "INSERT INTO messages (tutling_id, tutor_id, message, sender) VALUES ($tutling_id, $tutor_id, '$message', '$sender')";
        
        if ($db->query($query)) {
            $messageStatus = 'Message sent successfully!';
        } else {
            $messageStatus = 'Error: ' . $db->error;
        }
    } else {
        $messageStatus = 'Error: Missing required fields.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
    <link rel="stylesheet" href="style.css"> <!-- Optional CSS for styling -->
    <style>
        /* Add some basic styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .message-form {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .message-form input, .message-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .message-form button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .message-form button:hover {
            background-color: #218838;
        }
        .status {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="message-form">
    <h2>Send a Message</h2>
    <form method="POST" action="">
        <input type="hidden" name="tutling_id" value="1"
