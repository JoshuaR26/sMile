<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["email"];
    $password = $_POST["password"];

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "webdex";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }

    $sql = "SELECT * FROM login_credentials WHERE email = '$username' AND password = '$password'";

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        header("location: success.html");
        die();
    } else {
        $conn->close();
        header("Location: error.html");
        die();
    }
}
?>