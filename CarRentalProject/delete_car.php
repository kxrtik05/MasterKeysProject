<?php
include 'conn.php';
$id = $_GET['id'];

$sql = "DELETE FROM cars WHERE id=$id";
if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Car deleted successfully!'); window.location='index.php';</script>";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
?>
