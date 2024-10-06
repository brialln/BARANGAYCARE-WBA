<?php
    include 'PARTIALS/header.php';
?>

<body>
    <div class="container back_button-container">
        <a href="login.html"><button><i class="uil uil-arrow-circle-left"></i></button></a>
    </div>
    
    <section class="form_section">
        <div class="container form_section-container">
            <img class="form_logo" src="IMAGES/pamplona_logo.JPG">
            <h4>Create your account here</h4>
            <h5>Manage transactions and get the latest updates!</h5> 
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
                <select class="dropdown-gender" id="gender" aria-placeholder="Gender" name="gender" required>
                    <option value="Select">Select</option>
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
                <small>Already have an account? <b><a href="login.html">Login</a></b></small>
            </form>
        </div>
    </section>
    <!-- =========== END OF FORM SECTION =========== -->

<?php
    include 'PARTIALS/footer.php';
?>

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