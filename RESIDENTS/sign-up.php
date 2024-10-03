<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESIDENT'S SIGN-UP | BARANGAY-WBA</title>

    <!-- MONTSERRAT GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- CSS STYLESHEET LINK -->
     <link rel="stylesheet" href="CSS/style.css">
     <link rel="stylesheet" href="CSS/sign-up.css">

     <!-- ICONSCOUT CDN -->
    <link href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" rel="stylesheet">

    
</head>
<body>
    <div class="pamplona_banner">
        <p><b>Welcome!</b> The Barangay Pamplona Uno's Official Website</p>
    </div>
    <!-- =========== END OF ANNOUNCEMENT BANNER =========== -->

    <section class="form_section">
        <div class="container form_section-container">
            <img class="form_logo" src="IMAGES/pamplona_logo.JPG">
            <h2>SIGN UP</h2> 
            <div class="alert_message error">
                <p>This is an error message</p>
            </div>
            <form action="submit_signup.php" method="POST" enctype="multipart/form-data">
                <input type="text" placeholder="Full Name" id="name" name="name" required>
                <input type="text" placeholder="Address" id="address" name="address" required>
                <!-- <input type="text" placeholder="Last Name"> -->
                <input type="email" placeholder="Email" id="email" name="email" required>
                <input type="number" placeholder="Phone Number" class="no-spinner" id="phone" name="phone_number">
                <input type="date" placeholder="Birthdate" id="birthdate" name="birthdate">
                <label for="gender">Gender:</label>
                <select id="gender" aria-placeholder="Gender" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                <label class="checkbox-control">
                    <input type="checkbox" required>
                    <span class="checkmark">
                        <i class="uil uil-check"></i>
                    </span>
                    I hereby certify that all provided information are correct.
                </label>
                
                <div class="form_control">
                    <label for="proof-residency">Proof of Residency</label>
                    <input type="file" id="proof" name="proof_of_residency" accept=".pdf, .jpg, .png" required>
                </div>

                <button type="submit" class="btn">Sign Up</button>
                <small>Already have an account? <a href="login.html">Login</a></small>
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
                        <li><a href="index.html">BarangayPamplonaUno@gmail.com </a></li>
                        <li><a href="index.html">PamplonaSecretary@gmail.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer_copyright">
            <small>Copyright &copy; Barangay Pamplona Uno | Las Pinas City</small>
        </div>
    </footer>

    <script>
        // JavaScript for client-side validation
        document.getElementById('signupForm').addEventListener('submit', function(event) {
            // Phone number validation
            const phone = document.getElementById('phone').value;
            const phoneRegex = /^[0-9]{10,15}$/;

            if (!phoneRegex.test(phone)) {
                alert('Invalid phone number. It should be 10 to 15 digits.');
                event.preventDefault(); // Prevent form submission
            }

            // Email validation (using pattern attribute in HTML already)

            // File validation for proof of residency
            const fileInput = document.getElementById('proof');
            const filePath = fileInput.value;
            const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.pdf)$/i;

            if (!allowedExtensions.exec(filePath)) {
                alert('Invalid file type. Only JPG, PNG, and PDF files are allowed.');
                fileInput.value = ''; // Clear the file input
                event.preventDefault();
            }

            // Checkbox validation (to make sure the user certifies their info)
            const certify = document.getElementById('certify').checked;
            if (!certify) {
                alert('Please certify that the information is correct.');
                event.preventDefault();
            }
        });
    </script>
</body>
</html>