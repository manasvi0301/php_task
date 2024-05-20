<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $tracking_number = $_POST['tracking_number'];
    $tracking_link = $_POST['tracking_link'];
    $status = $_POST['status'];

    $sql = "UPDATE orders SET tracking_number=?, tracking_link=?, status=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $tracking_number, $tracking_link, $status, $id);
    
    if ($stmt->execute()) {
        echo "Order updated successfully!";
    } else {
        echo "Error updating order: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: index.php");
    exit();
}
?>