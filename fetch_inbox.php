
<?php
include 'db_connection.php';  // Include database connection

$tutling_id = $_SESSION['tutling_id']; // Assuming student ID is stored in session

// Fetch distinct tutors who messaged the student
$sql = "SELECT DISTINCT tutor_id, message FROM messages WHERE tutling_id = ? ORDER BY sent_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tutling_id);
$stmt->execute();
$result = $stmt->get_result();

$inbox_items = '';
while ($row = $result->fetch_assoc()) {
    $tutor_id = $row['tutor_id'];
    $message = $row['message'];

    // Fetch tutor's name from the tutor table
    $sql_tutor = "SELECT name FROM tutors WHERE id = ?";
    $stmt_tutor = $conn->prepare($sql_tutor);
    $stmt_tutor->bind_param("i", $tutor_id);
    $stmt_tutor->execute();
    $result_tutor = $stmt_tutor->get_result();
    $tutor_name = $result_tutor->fetch_assoc()['name'];

    $inbox_items .= "<div class='inbox-item' onclick=\"openMessage($tutor_id, '$message')\">
                        <strong>$tutor_name:</strong> $message
                     </div>";
}

$stmt->close();
$conn->close();

echo $inbox_items;
?>
