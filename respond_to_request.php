<?php

// respond_to_request.php
session_start();
include 'db_connection.php';

// Check if the tutor is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

// Check if the request ID and action are set
if (isset($_POST['request_id']) && isset($_POST['action'])) {
    $request_id = intval($_POST['request_id']);
    $action = $_POST['action'];
    $tutor_id = $_SESSION['userID'];

    if ($action == 'accept') {
        // Update the request status to accepted
        $query = "UPDATE tutor_requests SET request_status = 'accepted' WHERE request_id = '$request_id'";
        if ($db->query($query)) {
            // Retrieve the tutling_id from the tutor_requests table
            $query = "SELECT tutling_id FROM tutor_requests WHERE request_id = '$request_id'";
            $result = $db->query($query);
            
            if ($result && $row = $result->fetch_assoc()) {
                $tutling_id = $row['tutling_id'];
                
                // Now insert into tutors_tutlings
                $insertQuery = "INSERT INTO tutors_tutlings (tutor_id, tutling_id) VALUES ('$tutor_id', '$tutling_id')";
                if ($db->query($insertQuery)) {
                    echo 'Request accepted successfully!';
                } else {
                    echo 'Error inserting into tutors_tutlings: ' . $db->error;
                }
            } else {
                echo 'Error: Could not retrieve tutling_id for the request.';
            }
        } else {
            echo 'Error: ' . $db->error;
        }
    } elseif ($action == 'reject') {
        // Update the request status to rejected
        $query = "UPDATE tutor_requests SET request_status = 'rejected' WHERE request_id = '$request_id'";
        if ($db->query($query)) {
            echo 'Request rejected successfully!';
        } else {
            echo 'Error: ' . $db->error;
        }
    }
} else {
    echo 'Invalid request.';
}


?>