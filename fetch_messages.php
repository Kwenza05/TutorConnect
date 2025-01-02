<?php
include 'db_connection.php';

if (isset($_GET['tutor_id'])) {
    $tutling_id = $_SESSION['tutling_id'];
    $tutor_id = $_GET['tutor_id'];

    // Fetch the conversation between student and tutor
    $sql = "SELECT message, sender FROM messages WHERE (tutling_id = ? AND tutor_id = ?) OR (tutling_id = ? AND tutor_id = ?) ORDER BY sent_at ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $tutling_id, $tutor_id, $tutor_id, $tutling_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    $stmt->close();
    $conn->close();

    echo json_encode($messages);
}
?>
