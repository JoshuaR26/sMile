<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webdex";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $subject = $_POST['issue'];
    $feedback = $_POST['Feedback'];
    $rating = $_POST['rating'];

    // Prepare SQL query
    $sql = "INSERT INTO feedbacks (name, feedback, rating, subject) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $name, $feedback, $rating, $subject); // Corrected the type definition string

    // Execute query
    if ($stmt->execute()) {
        echo "Feedback submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $stmt->close();
}
$conn->close();
?>
