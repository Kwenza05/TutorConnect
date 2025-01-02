<?php
session_start();

// Check if the user is logged in by verifying the session
if (!isset($_SESSION['user_id']) && !isset($_SESSION['tutling_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include database connection file
include 'db_connection.php';

// Determine which ID to use
$tutling_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $_SESSION['tutling_id'];
$_SESSION['userID'] = $tutling_id;

// Fetch tutor's details from the database
$sql = "SELECT name, surname, image_path FROM tutlings WHERE tutling_id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $tutling_id);
$stmt->execute();
$stmt->bind_result($name, $surname, $profile_image);
$stmt->fetch();
$stmt->close();
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutee Dashboard</title>
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
            padding-left: 300px;
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
            margin: 10px 0;
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
            width: 210px;
        }

        .sidebar button {
            background-color: #75E6DA;
            color: #ffffff;
            border: 1px solid white;
            border-radius: 15px;
            padding: 10px;
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

        /* Messaging Section */
        .messages-section {
            margin-top: 20px;
            display: none;
        }

        .message-box {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .message-box .tutor-message, .message-box .student-message {
            margin: 10px 0;
            padding: 10px;
            border-radius: 10px;
        }

        .tutor-message {
            background-color: #e0f7fa;
            text-align: left;
        }

        .student-message {
            background-color: #d1c4e9;
            text-align: right;
        }

        .message-input {
            display: flex;
            margin-top: 10px;
        }

        .message-input input {
            flex: 1;
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .message-input button {
            background-color: #13536e;
            color: white;
            border: none;
            padding: 10px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            margin-left: 10px;
        }

        .message-input button:hover {
            background-color: #75E6DA;
        }
    </style>
</head>
<body>
    <header>
        <img src="images/lgRemoved.png" alt="TutorConnect Logo">
        <h1>Welcome to Your Dashboard</h1>
    </header>

    <!-- Sidebar -->
    <div class="sidebar">
        <img src="<?php echo !empty($profile_image) ? htmlspecialchars($profile_image) : 'images/dummy.jpg'; ?>" alt="Profile Picture">
        <h3><?php echo htmlspecialchars($name) . " " . htmlspecialchars($surname); ?></h3>
        <div>
            <a href="tutee_profile.php"><button>Edit Student Profile</button></a>
        </div>
        <a href="index.php">Home</a>
        <a href="message.php">My Messages</a>
        <a href="findtutor.php">Find a Tutor</a>
        <a href="#">Help</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Main Dashboard Content -->
    <div class="dashboard">
        <div class="dashboard-header">
            <h1> <?php echo "Hi ". htmlspecialchars($name); ?></h1>
            <p>Welcome to your student dashboard! You can find all your information here regarding your lessons, tutor requests, and completed sessions.</p>
        </div>
    </div>
</body>
</html>
