<?php
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

// Update resident status using prepared statements for better security
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $remark = $_POST['remark'] ?? '';

    $stmt = $conn->prepare("UPDATE residents SET status=?, remark=? WHERE id=?");
    $stmt->bind_param("ssi", $status, $remark, $id);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Status updated successfully.</p>";
    } else {
        echo "<p style='color: red;'>Error updating record: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Fetch residents from the database
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
        textarea {
            width: 100%;
            resize: vertical;
            height: 50px;
        }
        /* Modal styling */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-height: 80vh;
            overflow-y: auto;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Residents Approval List</h2>

<!-- Modal Structure -->
<div id="proofModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Proof of Residency</h3>
        <img id="proofImage" style="width: 100%; height: auto;" src="" alt="Proof of Residency">
    </div>
</div>

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
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['address']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
            <td><?php echo htmlspecialchars($row['birthdate']); ?></td>
            <td><?php echo htmlspecialchars($row['gender']); ?></td>
            <td>
                <!-- Button to open modal and display proof -->
                <button type="button" class="action-btn" onclick="openProofModal('/BARANGAYCARE-WBA/RESIDENTS/uploads/<?php echo htmlspecialchars($row['proof_of_residency']); ?>')">View Proof</button>
            </td>
            <td><?php echo ucfirst(htmlspecialchars($row['status'])); ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <textarea name="remark" placeholder="Add a remark"><?php echo htmlspecialchars($row['remark']); ?></textarea>
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

<!-- JavaScript to handle modal display -->
<script>
    // Get modal element and image element
    var modal = document.getElementById("proofModal");
    var proofImage = document.getElementById("proofImage");

    // Function to open modal and set image source
    function openProofModal(url) {
        proofImage.src = url;
        modal.style.display = "block";
    }

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
        proofImage.src = ""; // Reset image source
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            proofImage.src = ""; // Reset image source
        }
    }
</script>

</body>
</html>

<?php
$conn->close();
?>
