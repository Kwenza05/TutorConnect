<?php
session_start();

// Check if the user is logged in by verifying the session
if (!isset($_SESSION['user_id']) && !isset($_SESSION['tutor_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include database connection file
include 'db_connection.php';

// Determine which ID to use
$tutor_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $_SESSION['tutor_id'];
$_SESSION['userID'] = $tutor_id;

// Retrieve requests for the logged-in tutor
$query = "SELECT r.*, t.name AS tutling_name 
          FROM tutor_requests r 
          JOIN tutlings t ON r.tutling_id = t.tutling_id 
          WHERE r.tutor_id = '$tutor_id' AND r.request_status = 'pending'";

$result = $db->query($query);

// Fetch tutor's details from the database
$sql = "SELECT name, surname, email, phone, bio,  image_path FROM tutors WHERE tutor_id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $tutor_id);
$stmt->execute();
$stmt->bind_result($name, $surname, $email, $phone, $bio, $profile_image);
$stmt->fetch();
$stmt->close();
$db->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Dashboard</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #13536e;
            color: #ffffff;
            position: absolute;
            margin-top: 130px;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
        }

        /* Header Section */
        header {
            background-color: #13536e;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header img {
            position: absolute;
            top: -20px;
            left: 20px;
            width: 180px;
        }

        .sidebar img {
            border-radius: 50%;
            width: 80px;
            height: 80px;
        }

        .sidebar h3 {
            margin: 15px 0;
            color: #ffffff;
        }

        .sidebar a {
            text-decoration: none;
            color: #ffffff;
            padding: 10px 20px;
            display: block;
            width: 100%;
            text-align: left;
        }

        .sidebar a:hover {
            background-color: #75E6DA;
            width: 200px;
        }

        .sidebar button {
            background-color: #75E6DA;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
        }

        .sidebar button:hover {
            background-color: #75E6DA;
            color: #ffffff;
        }

        /* Main Dashboard Styles */
        .dashboard {
            margin-left: 250px;
            padding: 20px;
            background-color: #f9f9f9;
            min-height: 100vh;
        }

        .dashboard-header h1 {
            font-size: 2.5em;
            color: #333333;
        }

        .dashboard-header p {
            font-size: 1.2em;
            color: #000000;
        }

        /* Buttons */
        .dashboard-actions {
            margin-top: 20px;
        }

        .dashboard-actions button {
            background-color: #13536e;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 15px 30px;
            margin-right: 10px;
            font-size: 1.1em;
            cursor: pointer;
        }

        .dashboard-actions button:hover {
            background-color: #75E6DA;
        }

        /* Stats Box */
        .stats-box {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #666666;
        }

        .stats-box p {
            margin: 0;
            font-size: 1.1em;
        }

        .stats-box img {
            width: 80px;
        }
    </style>
</head>

<body>
    <header>
        <img src="images/lgRemoved.png" alt="TutorConnect Logo">
        <h1>Welcome to Your Tutor Dashboard</h1>
    </header>

    <!-- Sidebar -->
    <div class="sidebar">
        <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Picture">
        <h3><?php echo htmlspecialchars($name) . " " . htmlspecialchars($surname); ?></h3>
        
        <a href = "tutor_profile.php"><button>Edit Profile</button></a>
        <a href="#">My Dashboard</a>
        <a href= "message.php">My Messages</a>
        <a href="#">View Lesson Requests</a>
        <a href="#">Manage Lessons</a>
        <a href="#">View Reviews</a>
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Main Dashboard Content -->
    <div class="dashboard">
        <div class="dashboard-header">
            <h1>Hi, <?php echo htmlspecialchars($name); ?></h1>
            <p>Welcome to your tutor dashboard! Here you can manage your lessons, view requests from students, and check your reviews.</p>
        </div>

                    <h2>Your Tutoring Requests</h2>
            <table>
                <tr>
                    <th>Tutling Name</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['tutling_name']); ?></td>
                    <td>
                        <form method="post" action="respond_to_request.php">
                            <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                            <button type="submit" name="action" value="accept">Accept</button>
                            <button type="submit" name="action" value="reject">Reject</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>

        <div class="dashboard-actions">
            <button>View Lesson Requests</button>
            <button>Manage Your Lessons</button>
        </div>
    </div>
</body>
</html>
