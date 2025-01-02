<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: login.html");
    exit();
}
?>

<!doctype html>
<html lang="en"> 
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px 10px;
            text-align: center;
        }
        .container {
            margin: 20px auto;
            max-width: 800px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            margin-top: 0;
        }
        .logout-btn {
            background-color: #ff4b4b;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }
        .logout-btn:hover {
            background-color: #ff1a1a;
        }
    </style>
</head> 
<body> 
    <!-- Header -->
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    </header>
    
    <div class="container">
        <!-- Dashboard Sections -->
        <div class="section">
            <h2>Your Profile</h2>
            <p>Username: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            <!-- You can add more profile details here -->
        </div>

        <div class="section">
            <h2>Your Courses</h2>
            <ul>
                <li>Course 1: Introduction to Programming</li>
                <li>Course 2: Web Development Basics</li>
                <li>Course 3: Data Structures</li>
            </ul>
        </div>

        <div class="section">
            <h2>Upcoming Events</h2>
            <p>No upcoming events at this time.</p>
        </div>

        <!-- Logout Button -->
        <a href="logout.php" class="logout-btn">Log Out</a>
    </div>
</body>
</html>
