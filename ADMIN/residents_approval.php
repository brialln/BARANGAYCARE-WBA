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

// Update resident status
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $remark = $_POST['remark'];

    $sql = "UPDATE residents SET status='$status', remark='$remark' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Status updated successfully.";
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
