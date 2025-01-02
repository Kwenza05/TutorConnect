<?php
// Include the database connection file
include 'db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'];
    $comments = $_POST['comment'];
    $tutlingId = $_POST['tutling_id']; // Received from the form
    $tutorId = $_POST['tutor_id']; // Received from the form

    // Validate required fields
    if (empty($rating) || empty($tutlingId) || empty($tutorId)) {
        echo "Rating, tutling ID, and tutor ID are required.";
        exit;
    }

    // Prepare SQL statement to insert the review
    $sql = "INSERT INTO reviews (tutling_id, tutor_id, rating, comment, created_at) VALUES (?, ?, ?, ?, NOW())"; // Corrected SQL
    $stmt = $pdo->prepare($sql);

    // Execute the statement with the provided values
    if ($stmt->execute([$tutlingId, $tutorId, $rating, $comments])) {
        echo "Review submitted successfully!";
    } else {
        echo "Failed to submit review. Please try again.";
    }
}
?>
