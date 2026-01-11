<?php 
// Your existing PHP includes at the top
include 'conn.php'; 

include 'adminheader.php'; 
?>

<div class="container admin-panel">

    <h2>MasterKeys Bookings</h2>
    

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Car ID</th>
                <th>Customer Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Booking Time</th>
                <th>Amount</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <tbody>
            
            <?php
            // Example of what your loop might look like
            $result = mysqli_query($conn, "SELECT * FROM bookings");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['car_id']}</td>
                <td>{$row['user_name']}</td>
                <td>{$row['start_date']}</td>
                <td>{$row['end_date']}</td>
                <td>{$row['booking_time']}</td>
                <td>{$row['total_amount']}</td>
                <td>{$row['payment_status']}</td>
                    
              </tr>";
    }
    ?>
            
        </tbody>
    </table>


    <style>
       .admin-panel {
    /* This centers your content by giving it a max width and auto margin */
    max-width: 1400px;
    margin: 0 auto;
    padding: 3rem 2rem 5rem 2rem; /* Adds top/bottom spacing */
}

.admin-panel h2 {
    text-align: left;
    color: #FFF;
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
}

.admin-panel .add-car-link {
    /* Styles for your "ADD NEW CAR" button */
    margin-bottom: 2rem;
    font-size: 1rem;
    font-weight: 600;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
    color: var(--text-color);
    background-color: var(--card-bg); /* Use your existing card color */
    border-radius: 8px;
    overflow: hidden; /* This makes the rounded corners work */
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.admin-table th, 
.admin-table td {
    border: 1px solid #333;
    padding: 1rem; /* Adds comfortable spacing */
    text-align: left;
    vertical-align: middle; /* Aligns text and images nicely */
}

.admin-table th {
    background-color: #333; /* Darker header */
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.admin-table td img {
    /* Styles for the car image in the table */
    width: 150px;
    height: auto;
    border-radius: 5px;
    display: block;
}

.admin-table .action-cell a {
    /* Styles for Edit/Delete links */
    color: var(--primary-color);
    font-weight: 600;
    text-decoration: none;
    margin: 0 4px;
    transition: all 0.2s ease;
}

.admin-table .action-cell a:hover {
    text-decoration: underline;
    color: #FFF; /* Make it light up on hover */
}

/* This styles your new "Return" button */
.admin-table .action-cell .btn-return {
    background-color: var(--primary-color);
    color: #FFF;
    padding: 8px 12px;
    border-radius: 5px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    display: inline-block;
}
.admin-table .action-cell .btn-return:hover {
    background-color: #FFF;
    color: var(--primary-color);
    text-decoration: none;
} 
    </style>
</div> <?php 
include 'footer.php'; 
?>