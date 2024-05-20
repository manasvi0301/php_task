<?php
include 'db_connection.php';

// Fetch confirmed orders
$sql = "SELECT * FROM orders WHERE confirmed = 1";
$result = $conn->query($sql);

// Fetch statuses
$status_sql = "SELECT * FROM statuses";
$status_result = $conn->query($status_sql);
$statuses = [];
while ($row = $status_result->fetch_assoc()) {
    $statuses[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dispatch Panel</title>
</head>
<body>
    <h1>Dispatch Panel</h1>
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>Consumer Name</th>
            <th>Product Name</th>
            <th>Tracking Number</th>
            <th>Tracking Link</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <form method='POST' action='update_order.php'>
                    <td>{$row['id']}<input type='hidden' name='id' value='{$row['id']}'></td>
                    <td>{$row['consumer_name']}</td>
                    <td>{$row['product_name']}</td>
                    <td><input type='text' name='tracking_number' value='{$row['tracking_number']}'></td>
                    <td><input type='text' name='tracking_link' value='{$row['tracking_link']}'></td>
                    <td>
                        <select name='status'>";
                        foreach ($statuses as $status) {
                            $selected = $status['status_name'] == $row['status'] ? "selected" : "";
                            echo "<option value='{$status['status_name']}' $selected>{$status['status_name']}</option>";
                        }
            echo "      </select>
                    </td>
                    <td><input type='submit' value='Update'></td>
                </form>
            </tr>";
        }
        ?>
    </table>
</body>
</html>