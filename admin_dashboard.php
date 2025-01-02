<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TutorConnect</title>
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
            width: 260px;
            height: calc(100vh - 60px);
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
            width: 220px;
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

        /* Card Styles */
        .card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            margin: 10px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            margin-top: 0;
        }

        .card button {
            background-color: #13536e;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }

        .card button:hover {
            background-color: #75E6DA;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        table th, table td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        table th {
            background-color: #13536e;
            color: white;
        }
    </style>
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file -->
</head>
<body>

<header>
    <img src="images/lgRemoved.png" alt="TutorConnect Logo">
    <h1>Admin Dashboard</h1>
</header>

<!-- Sidebar -->
<div class="sidebar">
    <img src="images/admin.jpg" alt="Admin Picture">
    <h3><?php echo htmlspecialchars($adminName); ?></h3> <!-- Display Admin Name -->
    <a href="#">Dashboard</a>
    <a href="#">Manage Tutors</a>
    <a href="#">Manage Students</a>
    <a href="#">View Messages</a>
    <a href="#">View Statistics</a>
    <a href="logout.php">Logout</a> <!-- Link to Logout -->
</div>

<!-- Main Dashboard Content -->
<div class="dashboard">
    <div class="dashboard-header">
        <h1>Welcome to the Admin Dashboard</h1>
    </div>

    <!-- Manage Tutors Section -->
    <div class="card">
        <h2>Manage Tutors</h2>
        <table>
            <thead>
                <tr>
                    <th>Tutor Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
// admin_dashboard.php
include 'db_connection.php'; // Ensure this is included first

// Check if the connection is established
if ($db === null) {
    die("Database connection failed.");
}

// Function to fetch tutors
function fetchTutors($db) {
    $sql = "SELECT id, name, email, status FROM tutors"; 
    $result = $db->query($sql);
    if (!$result) {
        die("Query failed: " . $db->error);
    }
    $tutors = [];
    while ($row = $result->fetch_assoc()) {
        $tutors[] = $row;
    }
    return $tutors;
}

// Function to fetch admin details
function fetchAdmin($db) {
    $sql = "SELECT name FROM admins LIMIT 1"; 
    $result = $db->query($sql);
    if (!$result) {
        die("Query failed: " . $db->error);
    }
    $admin = $result->fetch_assoc();
    return $admin ? $admin['name'] : null; // Return null if no admin found
}

// Function to fetch students
function fetchStudents($db) {
    $sql = "SELECT id, name, email, status FROM tutlings"; 
    $result = $db->query($sql);
    if (!$result) {
        die("Query failed: " . $db->error);
    }
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    return $students;
}

// Fetch statistics
$totalTutors = $db->query("SELECT COUNT(*) as count FROM tutors")->fetch_assoc()['count'];
$totalStudents = $db->query("SELECT COUNT(*) as count FROM tutlings")->fetch_assoc()['count'];
$activeTutors = $db->query("SELECT COUNT(*) as count FROM tutors WHERE status = 'Active'")->fetch_assoc()['count'];
$activeStudents = $db->query("SELECT COUNT(*) as count FROM tutlings WHERE status = 'Active'")->fetch_assoc()['count'];

// Fetch admin name
$adminName = fetchAdmin($db);

// Close the connection after fetching data
$db->close(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TutorConnect</title>
    <style>
        /* Your CSS Styles Here */
    </style>
</head>
<body>
<header>
    <img src="images/lgRemoved.png" alt="TutorConnect Logo">
    <h1>Admin Dashboard</h1>
</header>

<!-- Sidebar -->
<div class="sidebar">
    <img src="images/admin.jpg" alt="Admin Picture">
    <h3><?php echo htmlspecialchars($adminName ?? 'Admin'); ?></h3> <!-- Use null coalescing operator -->
    <a href="#">Dashboard</a>
    <a href="#">Manage Tutors</a>
    <a href="#">Manage Students</a>
    <a href="#">View Messages</a>
    <a href="#">View Statistics</a>
    <a href="logout.php">Logout</a> <!-- Link to Logout -->
</div>

<!-- Main Dashboard Content -->
<div class="dashboard">
    <div class="dashboard-header">
        <h1>Welcome to the Admin Dashboard</h1>
    </div>

    <!-- Manage Tutors Section -->
    <div class="card">
        <h2>Manage Tutors</h2>
        <table>
            <thead>
                <tr>
                    <th>Tutor Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tutors = fetchTutors($db); // Call function
                foreach ($tutors as $tutor) {
                    echo "<tr>
                            <td>" . htmlspecialchars($tutor['name']) . "</td>
                            <td>" . htmlspecialchars($tutor['email']) . "</td>
                            <td>" . htmlspecialchars($tutor['status']) . "</td>
                            <td>
                                <button onclick=\"editTutor('{$tutor['id']}')\">Edit</button>
                                <button onclick=\"deleteTutor('{$tutor['id']}')\">Delete</button>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Manage Students Section -->
    <div class="card">
        <h2>Manage Students</h2>
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $students = fetchStudents($db); // Call function
                foreach ($students as $student) {
                    echo "<tr>
                            <td>" . htmlspecialchars($student['name']) . "</td>
                            <td>" . htmlspecialchars($student['email']) . "</td>
                            <td>" . htmlspecialchars($student['status']) . "</td>
                            <td>
                                <button onclick=\"editStudent('{$student['id']}')\">Edit</button>
                                <button onclick=\"deleteStudent('{$student['id']}')\">Delete</button>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- View Statistics Section -->
    <div class="card">
        <h2>Statistics</h2>
        <p>Total Tutors: <strong><?php echo $totalTutors; ?></strong></p>
        <p>Total Students: <strong><?php echo $totalStudents; ?></strong></p>
        <p>Active Tutors: <strong><?php echo $activeTutors; ?></strong></p>
        <p>Active Students: <strong><?php echo $activeStudents; ?></strong></p>
    </div>
</div>

</body>
</html>
