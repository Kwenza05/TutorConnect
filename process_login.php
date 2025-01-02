<?php
// Include database connection file
include 'db_connection.php'; // Adjust the path as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to prevent SQL injection
    $sql = "SELECT tutor_id, password, 'tutor' AS role FROM Tutors WHERE email = ? 
            UNION 
            SELECT tutling_id AS tutor_id, password, 'tutee' AS role FROM Tutlings WHERE email = ?
            UNION 
            SELECT admin_id AS tutor_id, password, 'admin' AS role FROM Admins WHERE email = ?"; // Corrected table name

    $stmt = $db->prepare($sql);
    $stmt->bind_param("sss", $email, $email, $email); // Bind email three times

    // Execute the statement
    $stmt->execute();
    $stmt->store_result();

    // Check if any rows are returned
    if ($stmt->num_rows > 0) {
        // Fetch the user_id, password, and role (tutor, tutee, or admin)
        $stmt->bind_result($user_id, $stored_password, $role);
        $stmt->fetch();

        // Verify the password based on the role
        if ($role === 'admin') {
            // For admin, compare the password directly (since it's in plain text)
            if ($password === $stored_password) {
                // Start session and store necessary information
                session_start();
                $_SESSION['email'] = $email; // Store email in session for further use
                $_SESSION['user_id'] = $user_id; // Store user_id (admin_id) in session
                $_SESSION['role'] = $role; // Store the role in session (admin)

                header("Location: admin_dashboard.php"); // Redirect admins
                exit(); // Ensure no further code is executed after redirection
            } else {
                header('Location: login.php?error=invalid_password&email=' . urlencode($email));
                exit();
            }
        } else {
            // For tutors and tutlings, use password_verify to check hashed passwords
            if (password_verify($password, $stored_password)) {
                // Start session and store necessary information
                session_start();
                $_SESSION['email'] = $email; // Store email in session for further use
                $_SESSION['user_id'] = $user_id; // Store user_id (tutor_id or tutling_id) in session
                $_SESSION['role'] = $role; // Store the role in session (tutor or tutee)

                // Redirect based on the role
                if ($role === 'tutor') {
                    header("Location: tutor_dashboard.php"); // Redirect tutors
                } elseif ($role === 'tutee') {
                    header("Location: tutee_dashboard.php"); // Redirect tutees
                }
                exit(); // Ensure no further code is executed after redirection
            } else {
                header('Location: login.php?error=invalid_password&email=' . urlencode($email));
                exit();
            }
        }
    } else {
        header("Location: login.php?error=no_account");
        exit();
    }

    // Close the statement and connection
    $stmt->close();
    $db->close();
}
?>
