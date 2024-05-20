<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dispatch_panel";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderId = $_POST['order_id'];
    $trackingNumber = $_POST['tracking_number'];
    $trackingLink = $_POST['tracking_link'];
    $status = $_POST['status'];

    $sql = "UPDATE orders SET tracking_number=?, tracking_link=?, status=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $trackingNumber, $trackingLink, $status, $orderId);
    $stmt->execute();
}

// Fetch confirmed orders
$sql = "SELECT * FROM orders WHERE confirmed = TRUE";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dispatch Panel</title>
</head>
<body>
    <h1>Dispatch Panel</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Consumer Name</th>
            <th>Product Name</th>
            <th>Tracking Number</th>
            <th>Tracking Link</th>
            <th>Status</th>
            <th>Update</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <form method="post">
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['consumer_name']; ?></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><input type="text" name="tracking_number" value="<?php echo $row['tracking_number']; ?>"></td>
                <td><input type="text" name="tracking_link" value="<?php echo $row['tracking_link']; ?>"></td>
                <td>
                    <select name="status">
                        <option value="pending" <?php if($row['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                        <option value="picked" <?php if($row['status'] == 'picked') echo 'selected'; ?>>Picked</option>
                        <option value="in transit" <?php if($row['status'] == 'in transit') echo 'selected'; ?>>In Transit</option>
                        <option value="delivered" <?php if($row['status'] == 'delivered') echo 'selected'; ?>>Delivered</option>
                    </select>
                </td>
                <td>
                    <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                    <input type="submit" value="Update">
                </td>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
