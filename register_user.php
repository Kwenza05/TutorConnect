<?php
// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection file
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement to check for existing email
    if ($role === 'tutor') {
        $check_sql = "SELECT email FROM tutors WHERE email = ?";
        $insert_sql = "INSERT INTO tutors(name, surname, email, phone, password) VALUES (?, ?, ?, ?, ?)";
    } else {
        $check_sql = "SELECT email FROM tutlings WHERE email = ?";
        $insert_sql = "INSERT INTO tutlings(name, surname, email, phone, password) VALUES (?, ?, ?, ?, ?)";
    }

    // Check if the email already exists
    $check_stmt = $db->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Email already exists
        /* echo "Error: Email already exists."; */
        header("Location: register.php?error=duplicate&name=" . urlencode($name) . "&surname=" . urlencode($surname) . "&phone=" . urlencode($phone));
        exit();
    } else {
        // Prepare the insert statement     
        $stmt = $db->prepare($insert_sql);

        // Check if the insert statement was prepared successfully
        if ($stmt) {
            $stmt->bind_param("sssss", $name, $surname, $email, $phone, $hashed_password);

            // Execute the insert statement
            if ($stmt->execute()) {
                // Now fetch the tutor_id or tutling_id
                if ($role == "tutor") {
                    // Get the tutor_id for the newly registered tutor
                    $fetch_id_sql = "SELECT tutor_id FROM tutors WHERE email = ?";
                } else {
                    // Get the tutling_id for the newly registered tutling
                    $fetch_id_sql = "SELECT tutling_id FROM tutlings WHERE email = ?";
                }

                // Prepare the statement to fetch the ID
                $id_stmt = $db->prepare($fetch_id_sql);
                $id_stmt->bind_param("s", $email);
                $id_stmt->execute();
                $id_stmt->bind_result($user_id);
                $id_stmt->fetch();
                $id_stmt->close();

               

                // Redirect based on role
                if ($role == "tutor") {
                     // Store the user ID in the session
                    session_start();
                    $_SESSION['user_id'] = $user_id;
                    header("Location: tutor_dashboard.php");
                    exit();
                } else {
                    // Store the user ID in the session
                    session_start();
                    $_SESSION['user_id'] = $user_id;
                    header("Location: tutee_dashboard.php");
                    exit();
                }
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the insert statement
            $stmt->close();
        } else {
            echo "Error preparing the insert statement: " . $db->error;
        }
    }

    // Close the check statement
    $check_stmt->close();
    // Close the database connection
    $db->close();
}
?>
