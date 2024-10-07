<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// HTML content for the login test
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Test | Barangay WBA</title>

    <!-- MONTSERRAT GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- CSS STYLESHEET LINK -->
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <header>
        <h1>Welcome to the Login Test Page</h1>
        <p>Hello, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>
    </header>

    <main>
        <section>
            <h2>Your Login was Successful!</h2>
            <p>Thank you for logging in. You can now access the features of the site.</p>
        </section>
    </main>

    <footer>
        <div class="container footer_container">
            <small>Copyright &copy; Barangay Pamplona Uno | Las Pinas City</small>
        </div>
    </footer>
</body>
</html>
