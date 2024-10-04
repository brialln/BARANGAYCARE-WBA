<?php
// Include PHPMailer classes
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barangay_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update resident status and create user credentials if approved
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $remark = $_POST['remark'];

    // Update resident status
    $sql = "UPDATE residents SET status='$status', remark='$remark' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Status updated successfully.";

        // If status is approved, create user credentials
        if ($status === 'approved') {
            // Fetch the resident's birthday for use as the password
            $resident_sql = "SELECT name, email, birthdate FROM residents WHERE id='$id'";
            $resident_result = $conn->query($resident_sql);
            $resident = $resident_result->fetch_assoc();

            // Get the highest current user ID
            $max_user_id_sql = "SELECT MAX(userid) AS max_userid FROM user_credentials";
            $max_user_id_result = $conn->query($max_user_id_sql);
            $max_user_id = $max_user_id_result->fetch_assoc()['max_userid'];
            $new_user_id = ($max_user_id ? $max_user_id + 1 : 1); // Increment or start at 1

            // Format user ID to 6 digits with leading zeros
            $formatted_user_id = str_pad($new_user_id, 6, '0', STR_PAD_LEFT);

            // Set the password to the resident's birthday
            $password = $resident['birthdate']; // Use the birthdate as the password

            // Insert into user_credentials table
            $user_sql = "INSERT INTO user_credentials (userid, password, residentid, name, email, role)
                         VALUES ('$formatted_user_id', '$password', '$id', '{$resident['name']}', '{$resident['email']}', 'resident')";

            if ($conn->query($user_sql) === TRUE) {
                echo "User credentials created successfully. User ID: $formatted_user_id | Password: $password";

                // Send email with the credentials
                $mail = new PHPMailer(true); // Enable PHPMailer exceptions

                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.mail.yahoo.com'; // Set the SMTP server
                    $mail->SMTPAuth = true;
                    $mail->Username = 'barangaycarelp@yahoo.com'; // Your Yahoo email
                    $mail->Password = 'supersarap.'; // Your Yahoo password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587; // TCP port to connect to

                    // Recipients
                    $mail->setFrom('barangaycarelp@yahoo.com', 'Barangay System');
                    $mail->addAddress($resident['email'], $resident['name']); // Add resident's email

                    // Email content
                    $mail->isHTML(true); // Set email format to HTML
                    $mail->Subject = 'Your Barangay System Login Credentials';
                    $mail->Body    = "
                        <h3>Hello, {$resident['name']}!</h3>
                        <p>Your application has been approved. Here are your login details:</p>
                        <p><b>User ID:</b> $formatted_user_id<br>
                        <b>Password:</b> {$resident['birthdate']} (Your birthdate)</p>
                        <p>Please change your password after logging in for the first time.</p>
                        <p>Best regards,<br>Barangay System Team</p>";
                    $mail->AltBody = "Hello, {$resident['name']}! Your application has been approved. 
                        User ID: $formatted_user_id | Password: {$resident['birthdate']}
                        Please change your password after logging in for the first time.";

                    $mail->send();
                    echo "Email has been sent.";
                } catch (Exception $e) {
                    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Error creating user credentials: " . $conn->error;
            }
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Fetch residents from database
$sql = "SELECT * FROM residents";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Residents Approval</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        .action-btn {
            margin: 5px;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }
        .approve-btn {
            background-color: green;
            color: white;
        }
        .disapprove-btn {
            background-color: red;
            color: white;
        }
        .disabled {
            background-color: grey;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<h2>Residents Approval List</h2>

<table>
    <tr>
        <th>Name</th>
        <th>Address</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Birthdate</th>
        <th>Gender</th>
        <th>Proof of Residency</th>
        <th>Status</th>
        <th>Remark</th>
        <th>Action</th>
    </tr>

    <?php if ($result->num_rows > 0) : ?>
        <?php while($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone_number']; ?></td>
            <td><?php echo $row['birthdate']; ?></td>
            <td><?php echo $row['gender']; ?></td>
            <td><a href="/BARANGAYCARE-WBA/RESIDENTS/uploads/<?php echo $row['proof_of_residency']; ?>" target="_blank">View Proof</a></td>
            <td><?php echo ucfirst($row['status']); ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <textarea name="remark" placeholder="Add a remark"><?php echo $row['remark']; ?></textarea>
            </td>
            <td>
                <?php if ($row['status'] == 'pending') : ?>
                    <button type="submit" name="status" value="approved" class="action-btn approve-btn">Approve</button>
                    <button type="submit" name="status" value="disapproved" class="action-btn disapprove-btn">Disapprove</button>
                <?php else : ?>
                    <button type="button" class="action-btn approve-btn disabled" disabled>Approve</button>
                    <button type="button" class="action-btn disapprove-btn disabled" disabled>Disapprove</button>
                <?php endif; ?>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else : ?>
        <tr>
            <td colspan="10">No residents found</td>
        </tr>
    <?php endif; ?>
</table>

</body>
</html>

<?php
$conn->close();
?>
