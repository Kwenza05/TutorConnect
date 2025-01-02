<?php
// Define database connection constants
define("DATABASE_LOCAL", "localhost");
define("DATABASE_NAME", "team15"); 
define("DATABASE_USER", "Team15"); 
define("DATABASE_PASSWORD", "M9xeY5D0"); 

// Create the database connection
$db = new mysqli(DATABASE_LOCAL, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
