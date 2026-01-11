<?php
// 1. Include your database connection file
require_once 'conn.php';

// 2. Run a SQL query to get ALL cars
// We removed 'LIMIT 3' and added an ORDER BY
$sql = "SELECT id, car_name, price_per_day, image, status FROM cars ORDER BY car_name ASC";
$result = $conn->query($sql);

// 3. Fetch all results
$all_cars = [];
if ($result) {
    $all_cars = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Error fetching cars: " . $conn->error;
}

// 4. Include the header file
include 'header.php';
?>

<section id="fleet" class="featured-cars" style="padding-top: 5rem;">
    <div class="container">
        
        <h2>Our Full Collection</h2>
        
        <div class="car-grid">
    <?php
    // Loop through every car from the database
    foreach ($all_cars as $car):
    ?>
        <div class="car-card <?php echo ($car['status'] == 'Unavailable') ? 'card-unavailable' : ''; ?>">

            <img src="uploads/<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['car_name']); ?>">
            
            <div class="card-content">
                <h3><?php echo htmlspecialchars($car['car_name']); ?></h3> 
                <p class="price"><?php echo htmlspecialchars($car['price_per_day']); ?> AED / day</p> 
                
                <?php
                // Here is the second change:
                // We show a different button if the car is unavailable
                if ($car['status'] == 'Available'):
                ?>
                    <a href="car_details.php?id=<?php echo $car['id']; ?>" class="btn btn-secondary">Book Now</a>
                <?php else: ?>
                    <a href="#" class="btn btn-secondary">Booked</a>
                <?php endif; ?>
                
            </div>
        </div>
    <?php endforeach; ?>
    
    <?php
    if (empty($all_cars)):
    ?>
        <p style="text-align: center; grid-column: 1 / -1; color: var(--text-muted);">
            No cars are listed in our fleet.
        </p>
    <?php endif; ?>

</div>
        
    </div>
</section>

<?php
// Include the footer file
include 'footer.php';
?>