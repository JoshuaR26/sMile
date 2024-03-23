<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webdex";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // File upload handling
    if (isset($_FILES['aadhaar_file'])) {
        $errors = array();
        $file_name = $_FILES['aadhaar_file']['name'];
        $file_size = $_FILES['aadhaar_file']['size'];
        $file_tmp = $_FILES['aadhaar_file']['tmp_name'];
        $file_type = $_FILES['aadhaar_file']['type'];
        $file_ext = strtolower(end(explode('.', $_FILES['aadhaar_file']['name'])));

        $extensions = array("pdf", "jpg", "jpeg");

        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "extension not allowed, please choose a PDF or JPG file.";
        }

        if ($file_size > 5000000) {
            $errors[] = 'File size must be exactly 5 MB';
        }

        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, "../php/uploads" . $file_name);
            $aadhaarFilePath = "../php/uploads" . $file_name;
        } else {
            print_r($errors);
        }
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone_number, country, state, city, pincode, aadhaar_file_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $fname, $lname, $email, $phone, $country, $state, $city, $pincode, $aadhaarFilePath);

    // Set parameters and execute
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phno'];
    if (isset($_POST['country'])) {
        $country = $_POST['country'];
    } else {
        $country = ''; // Default value or handle the missing key as needed
    }
    
    if (isset($_POST['state'])) {
        $state = $_POST['state'];
    } else {
        $state = ''; // Default value or handle the missing key as needed
    }
    
    if (isset($_POST['city'])) {
        $city = $_POST['city'];
    } else {
        $city = ''; // Default value or handle the missing key as needed
    }
    $pincode = $_POST['pincode'];


    if ($stmt->execute()) {
        $last_id = $conn->insert_id;
        // Insert login credentials
        $stmt = $conn->prepare("INSERT INTO login_credentials (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
