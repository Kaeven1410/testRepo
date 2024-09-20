<?php
// Connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "example_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch input from login form
$user = $_POST['username'];
$pass = $_POST['password'];

// Vulnerable SQL query
$sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User authenticated successfully
    echo "Login successful!";
} else {
    // Invalid credentials
    echo "Login failed.";
}

$conn->close();
?>
