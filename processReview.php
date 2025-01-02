<?php
session_start();

// Include database connection file
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form submission
    $tutor_id = $_POST['tutor_id']; // Get from form input
    $tutling_id = $_POST['tutling_id']; // Get from form input
    $rating = $_POST['rating']; // Rating from form input
    $comment = $_POST['comment']; // Comment from form input

    // Validate that the inputs are not empty
    if (empty($tutor_id) || empty($tutling_id) || empty($rating) || empty($comment)) {
        echo "All fields are required.";
        exit();
    }

    // Check if the tutor_id and tutling_id correspond to the same review_id
    $stmt = $db->prepare("SELECT review_id FROM reviews WHERE tutor_id = ? AND tutling_id = ?");
    $stmt->bind_param("ii", $tutor_id, $tutling_id);
    $stmt->execute();
    $stmt->bind_result($review_id);
    $stmt->fetch();
    $stmt->close();

    if (!$review_id) {
        echo "No matching review found for the given tutor and tutling.";
        exit();
    }

    // Verify that the tutling has been accepted for tutoring
    // This assumes you have a separate table or column to check for accepted status
    // Example: Check the 'status' column in the 'tutlings' table
    $stmt = $db->prepare("SELECT status FROM tutlings WHERE tutling_id = ?");
    $stmt->bind_param("i", $tutling_id);
    $stmt->execute();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();

    if ($status !== 'accepted') {
        echo "The tutling has not been accepted for tutoring.";
        exit();
    }

    // Confirm the status in the relevant column reflects acceptance
    // Assuming you have a 'status' column in the reviews table
    $stmt = $db->prepare("SELECT status FROM reviews WHERE review_id = ?");
    $stmt->bind_param("i", $review_id);
    $stmt->execute();
    $stmt->bind_result($review_status);
    $stmt->fetch();
    $stmt->close();

    if ($review_status !== 'accepted') {
        echo "The review status does not reflect acceptance.";
        exit();
    }

    // Insert the review into the database
    $stmt = $db->prepare("INSERT INTO reviews (tutor_id, tutling_id, rating, comment, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiis", $tutor_id, $tutling_id, $rating, $comment);

    if ($stmt->execute()) {
        echo "Review submitted successfully.";
    } else {
        echo "Error submitting review: " . $db->error;
    }

    $stmt->close();
    $db->close();
} else {
    echo "Invalid request method.";
}
?>
