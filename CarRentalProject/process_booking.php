<?php
require_once 'conn.php'; // Your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get all the data from the form
    $car_id = $_POST['car_id'];
    $user_name = $_POST['user_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $total_amount = $_POST['total_amount'];
    
    // We use a transaction to make sure BOTH queries succeed or fail together.
    // This stops you from having a booking for a car that is still "Available".
    mysqli_begin_transaction($conn);

    try {
        // --- Query 1: INSERT the new booking ---
        $sql1 = "INSERT INTO bookings (car_id, user_name, start_date, end_date, total_amount, payment_status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt1 = mysqli_prepare($conn, $sql1);

    $payment_status = 'Paid'; // Set status to 'Paid' on success

    // "isssds" = integer, string, string, string, double, string
    mysqli_stmt_bind_param($stmt1, "isssds", $car_id, $user_name, $start_date, $end_date, $total_amount, $payment_status);

    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);

        // --- Query 2: UPDATE the car's status ---
        $sql2 = "UPDATE cars SET status = 'Unavailable' WHERE id = ?";
        $stmt2 = mysqli_prepare($conn, $sql2);
        // "i" = integer
        mysqli_stmt_bind_param($stmt2, "i", $car_id);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);

        // If both queries were successful, commit the changes
        mysqli_commit($conn);

        echo "<script>
                alert('Booking successful! The car is now reserved.');
                window.location.href = 'fleet.php';
              </script>";

    } catch (mysqli_sql_exception $exception) {
        // If anything went wrong, roll back all changes
        mysqli_rollback($conn);
        
        echo "<script>
                alert('Booking failed. Please try again.');
                window.location.href = 'car_details.php?id=$car_id';
              </script>";
        // echo "Error: " . $exception->getMessage(); // Uncomment for debugging
    }

    mysqli_close($conn);

} else {
    // Redirect if accessed directly
    header("Location: fleet.php");
    exit();
}
?>