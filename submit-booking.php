<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$servername = "localhost"; // Replace with your servername
$username = "root"; // Replace with your username
$password = ""; // Replace with your password
$database = "flight_booking"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $departure_city = validateInput($_POST["departure_city"]);
    $arrival_city = validateInput($_POST["arrival_city"]);
    $departure_date = validateInput($_POST["departure_date"]);
    $return_date = validateInput($_POST["return_date"]);
    $full_name = validateInput($_POST["full_name"]);
    $email = validateInput($_POST["email"]);
    $seat = validateInput($_POST["seat"]);
    $checked_baggage = validateInput($_POST["checked_baggage"]);
    $carry_on = validateInput($_POST["carry_on"]);
    $card_number = validateInput($_POST["card_number"]);
    $expiry_date = validateInput($_POST["expiry_date"]);
    $cvv = validateInput($_POST["cvv"]);

    // Validate checkbox for terms and conditions
    if (!isset($_POST["terms"])) {
        echo "Please agree to the terms and conditions.";
        exit;
    }

    // Construct SQL query
    $sql = "INSERT INTO bookings (departure_city, arrival_city, departure_date, return_date, full_name, email, seat, checked_baggage, carry_on, card_number, expiry_date, cvv) VALUES ('$departure_city', '$arrival_city', '$departure_date', '$return_date', '$full_name', '$email', '$seat', '$checked_baggage', '$carry_on', '$card_number', '$expiry_date', '$cvv')";

    // Echo SQL query (for debugging)
    echo "SQL Query: " . $sql . "<br>";

    // Execute SQL query
    if ($conn->query($sql) === TRUE) {
        echo "Booking successful!";
        header("Location: users.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // If the form is not submitted, redirect back to the form page
    header("Location: flight-booking.html");
    exit;
}

// Function to validate and sanitize input data
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Close database connection
$conn->close();
?>
