<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$dbname = "barangay_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and sanitize inputs
$name = $conn->real_escape_string(trim($_POST['name']));
$address = $conn->real_escape_string(trim($_POST['address']));
$email = $conn->real_escape_string(trim($_POST['email']));
$phone = $conn->real_escape_string(trim($_POST['phone_number']));
$birthdate = $conn->real_escape_string(trim($_POST['birthdate']));
$gender = $conn->real_escape_string(trim($_POST['gender']));

// File upload validation
$target_dir = "C:/xampp/htdocs/BARANGAYCARE-WBA/RESIDENTS/uploads/";
$proof_of_residency = $target_dir . basename($_FILES["proof_of_residency"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($proof_of_residency, PATHINFO_EXTENSION));

// Allow certain file formats
if($fileType != "pdf" && $fileType != "jpg" && $fileType != "png") {
    echo "Sorry, only PDF, JPG, and PNG files are allowed.";
    $uploadOk = 0;
}

// Check if file upload is valid
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["proof_of_residency"]["tmp_name"], $proof_of_residency)) {
        // Insert into database with status set to 'pending'
        $sql = "INSERT INTO residents (name, address, email, phone_number, birthdate, gender, proof_of_residency, status)
        VALUES ('$name', '$address', '$email', '$phone', '$birthdate', '$gender', '$proof_of_residency', 'pending')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully. Status is set to pending.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
?>
