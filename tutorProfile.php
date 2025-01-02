<?php
// Start session
session_start();

// Include database connection file
include 'db_connection.php';

// Check if the user is logged in by verifying the session for either user_id or tutling_id
if (isset($_SESSION['user_id'])) {
    // If user_id is set, assign it to a global session variable
    $_SESSION['logged_in_id'] = $_SESSION['user_id'];
} elseif (isset($_SESSION['tutling_id'])) {
    // If tutling_id is set, assign it to the same global session variable
    $_SESSION['logged_in_id'] = $_SESSION['tutling_id'];
} else {
    // Redirect to login page if neither user_id nor tutling_id is set (i.e., not logged in)
    header("Location: login.php");
    exit();
}

// Fetch tutor profile based on tutor ID from URL parameter
if (isset($_GET['tutor_id'])) {
    $tutor_id = intval($_GET['tutor_id']); // Ensure tutor_id is an integer
    $stmt = $db->prepare("SELECT * FROM Tutors WHERE tutor_id = ?");
    $stmt->bind_param("i", $tutor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tutor = $result->fetch_assoc();

    if (!$tutor) {
        $errorMessage = "Tutor not found.";
    }
} else {
    $errorMessage = "Tutor ID not provided.";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($tutor['name'] . ' ' . $tutor['surname']); ?> - Tutor Profile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Reset some default styles */
        body, h1, p, form {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* Style for the body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* Light background color */
            color: #333; /* Dark text color */
            line-height: 1.6; /* Improve readability */
        }
        /* Container for the tutor profile */
        .tutor-profile-container {
            max-width: 600px; /* Max width for the profile container */
            margin: 20px auto; /* Centered with some margin */
            padding: 20px;
            background-color: white; /* White background for the profile */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            transition: transform 0.2s; /* Animation for hover effect */
        }
        .tutor-profile-container:hover {
            transform: translateY(-5px); /* Lift effect on hover */
        }
        /* Tutor profile picture */
        .tutor-profile-pic {
            display: block;
            margin: 0 auto 15px; /* Centered with bottom margin */
            border-radius: 50%; /* Make it a circle */
            border: 3px solid #189AB4; /* Add border around image */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Shadow around image */
        }
        /* Headline styling */
        h1 {
            font-size: 26px; /* Larger font size for the name */
            text-align: center; /* Centered text */
            margin-bottom: 15px; /* Space below the heading */
            color: #05445E; /* Darker color for heading */
        }
        /* Paragraph styling */
        p {
            font-size: 16px; /* Standard font size for text */
            margin-bottom: 10px; /* Space below paragraphs */
        }
        /* Form styling */
        form {
            margin-top: 20px; /* Space above the form */
            display: flex; /* Flexbox for form layout */
            flex-direction: column; /* Column layout */
        }
        /* Textarea styling */
        textarea {
            width: 100%; /* Full width */
            padding: 10px; /* Padding for textarea */
            border-radius: 4px; /* Rounded corners */
            border: 1px solid #ccc; /* Border color */
            resize: none; /* Disable resizing */
            margin-bottom: 10px; /* Space below textarea */
        }
        /* Button styling */
        button {
            background-color: #28a745; /* Green background */
            color: white; /* White text */
            padding: 10px 15px; /* Padding for button */
            border: none; /* No border */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer on hover */
            font-size: 16px; /* Standard font size */
            transition: background-color 0.3s, transform 0.2s; /* Smooth transition for hover */
        }
        /* Button hover effect */
        button:hover {
            background-color: #218838; /* Darker green on hover */
            transform: scale(1.05); /* Slightly increase size on hover */
        }
        /* Success message styling */
        .success {
            color: #28a745; /* Green color for success messages */
            font-weight: bold; /* Bold text */
            margin-top: 10px; /* Space above the success message */
        }
        /* Error message styling */
        .error {
            color: #dc3545; /* Red color for error messages */
            font-weight: bold; /* Bold text */
            margin-top: 10px; /* Space above the error message */
        }

        /* Hide the option with value "pending" */
        option[value="pending"] {
            display: none; /* This will hide the option */
        }

          /* Hide the select element */
    .hidden {
        display: none;
    }
        
    </style>
</head>
<body>

<div class="tutor-profile-container">
    <?php if (isset($errorMessage)): ?>
        <p class="error"><?php echo htmlspecialchars($errorMessage); ?></p>
    <?php else: ?>
        <h1><?php echo htmlspecialchars($tutor['name'] . ' ' . $tutor['surname']); ?></h1>

        <!-- Display tutor profile picture -->
        <?php $profilePicPath = "images/" . htmlspecialchars($tutor['tutor_id']) . ".jpg"; ?>
        <?php if (file_exists($profilePicPath)): ?>
            <img src="<?php echo $profilePicPath; ?>" alt="<?php echo htmlspecialchars($tutor['name']); ?>'s Picture" class="tutor-profile-pic" width="200">
        <?php else: ?>
            <img src="<?php echo htmlspecialchars($tutor['image_path'] ?? ''); ?>" alt="Default Profile Picture" class="tutor-profile-pic" width="200"> <!-- Default image if not found -->
        <?php endif; ?>

        <!-- Display tutor bio and subject specialization -->
        <p><strong>Subject Specialization:</strong> <?php echo htmlspecialchars($tutor['subjects'] ?? ''); ?></p>
        <p><strong>Bio:</strong> <?php echo htmlspecialchars($tutor['bio'] ?? ''); ?></p>


        <form method="post" action="requestMessage.php">
            <input type="hidden" name="tutor_id" value="<?php echo htmlspecialchars($tutor['tutor_id']); ?>">
            
            <label for="message">Send a request to <?php echo htmlspecialchars($tutor['name'] ?? ''); ?>:</label><br>
            
            <!-- Dropdown to choose request status -->
            <select name="request_status" class="hidden">
              
                <option  value="pending">Accept Request</option>
                
            </select><br>

            <button type="submit">Send Request</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
