<?php
session_start(); // Start the session

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost"; // or your server name
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "barangay_db"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barangay_id = $_POST['barangay-id'];
    $resident_password = $_POST['resident-password'];

    // Debugging outputs
    echo "Barangay ID: " . $barangay_id . "<br>";
    echo "Resident Password: " . $resident_password . "<br>";

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM user_credentials WHERE userid = ? LIMIT 1");
    $stmt->bind_param("s", $barangay_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user data
        $user = $result->fetch_assoc();
        
        // Verify the password without hashing
        if ($user['password'] === $resident_password) { 
            // Set session variables
            $_SESSION['userid'] = $user['userid'];
            $_SESSION['name'] = $user['name'];
            // Redirect to the dashboard or another page
            header("Location: login_test.php");
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Invalid password.'); window.location.href='login.php';</script>";
        }
    } else {
        // No user found
        echo "<script>alert('No user found with that Barangay ID.'); window.location.href='login.php';</script>";
    }

    // Close statement and connection
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESIDENT'S LOGIN | BARANGAY-WBA</title>

    <!-- MONTSERRAT GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- CSS STYLESHEET LINK -->
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/login.css">

    <!-- ICONSCOUT CDN -->
    <link href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" rel="stylesheet">

</head>
<body>
    <section class="form_section">
        <div class="container side_section-container">
            <img src="IMAGES/pamplona_side-section.png">
        </div>

        <div class="container form_section-container">
            <h3>LOGIN</h3> 
            <h4>Login your credentials.</h4>
            <div class="alert_message error">
                <p>This is an error message</p>
            </div>
            <form action="login.php" method="POST" enctype="multipart/form-data">
                <input type="text" placeholder="Barangay ID" id="barangay-id" name="barangay-id" required>
                <input type="password" placeholder="Password" id="resident-password" name="resident-password" required>
                <button type="submit" class="btn">Login</button>
                <center><small><b> <a href="forgot_password.html">Forgot Password?</a></b></small></center>
                <small>Doesn't have an account? <b> <a href="sign_up.html">Sign up</a></b></small>
            </form>
        </div>
    </section>
    <!-- =========== END OF FORM SECTION =========== -->

    <footer>
        <div class="container footer_container">
            <div class="footer_1">
                <img class="footer_logo" src="IMAGES/pamplona_logo.JPG">
                <p>Pamplona Uno</p>
                <p>Las Pinas City</p>
                <p>Metro Manila</p>
                <div>
                    <i class="uil uil-facebook"></i>
                    <a class="pamplona_logo" href="facebook.com">Barangay Pamplona Uno</a>
                </div>
            </div>

            <div class="footer_2">
                <h4>Home</h4>
                <ul class="permalinks">
                    <li><a href="index.html">Announcement</a></li>
                    <li><a href="index.html">Barangay Facilities</a></li>
                </ul>

                <h4>Publications</h4>
                <ul class="permalinks">
                    <li><a href="index.html">Executive Order</a></li>
                    <li><a href="index.html">Barangay Ordinance</a></li>
                    <li><a href="index.html">Barangay Resolution</a></li>
                </ul>
            </div>

            <div class="footer_3">
                <h4>News & Updates</h4>

                <h4>Services</h4>
                <ul class="permalinks">
                    <li><a href="index.html">Community Development</a></li>
                    <li><a href="index.html">Disaster Preparedness</a></li>
                    <li><a href="index.html">Education</a></li>
                    <li><a href="index.html">Elderly</a></li>
                    <li><a href="index.html">Health</a></li>
                    <li><a href="index.html">Justice</a></li>
                    <li><a href="index.html">Livelihood & Employment</a></li>
                    <li><a href="index.html">Social</a></li>
                    <li><a href="index.html">Women's Welfare</a></li>
                    <li><a href="index.html">Youth & Sports</a></li>
                </ul>
            </div>

            <div class="footer_4">
                <h4>About Us</h4>
                <ul class="permalinks">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="index.html">News & Updates</a></li>
                    <li><a href="index.html">Services</a></li>
                    <li><a href="index.html">Publications</a></li>
                    <li><a href="index.html">About</a></li>
                    <li><a href="index.html">Contact</a></li>
                </ul>

                <h4>Contact Us</h4>
                <ul class="permalinks">
                    <li><a href="index.html">+63-945-999-1000</a></li>
                    <li><a href="index.html">+63-945-999-1000</a></li>
                    <li><a href="index.html">BarangayPamplonaUno@gmail.com</a></li>
                    <li><a href="index.html">PamplonaSecretary@gmail.com</a></li>
                </ul>
            </div>
        </div>
        <div class="footer_copyright">
            <small>Copyright &copy; Barangay Pamplona Uno | Las Pinas City</small>
        </div>
    </footer>
</body>
</html>
