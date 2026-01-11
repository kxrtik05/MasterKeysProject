<?php

require_once 'conn.php';

// 2. DELETE the manual $featured_cars array
// (The array you had from lines 4-18 is gone)

// 3. QUERY the database to get the cars
// This creates the $featured_cars array from your SQL table
$sql = "SELECT car_name, model, price_per_day, image FROM cars LIMIT 3";
$result = $conn->query($sql); // $result is a 'mysqli_result' object

// 3. Fetch all results using the correct mysqli method
$featured_cars = [];
if ($result) {
    // This was line 13. We change fetchAll() to fetch_all(MYSQLI_ASSOC)
    $featured_cars = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // If the query fails, show an error
    echo "Error fetching cars: " . $conn->error;
}
// 4. Include the header file
include 'header.php';
?>

<section class="hero">
    <div class="hero-content">
        <h1>Luxury Car Rental in Dubai</h1>
        <p>Experience luxury cars for your journey. Comfort & performance await you.</p>
        <a href="fleet.php" class="btn btn-primary">Browse Collection</a>
    </div>
</section>

<section class="logo-bar">
    <div class="logo-slider">
        <div class="logo-track">
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/Tp2uven3h7-1.png" alt="Lamborghini"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/cdrp0674jG-1.png" alt="Bentley"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/07/ferrari-1.png" alt="Ferrari"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/cdrp0674jG-1.png" alt="Rolls Royce"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/zlj3UFz79n-1.png" alt="Porsche"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/ZfXrHr4tP6-1.png" alt="Mercedes"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/7R5C0rp0y3.png" alt="Land Rover"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/0cID35vkiB.png" alt="Audi"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/sxI5jw9d0g.png" alt="BMW"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/Mcu96Jz47.png" alt="Cadillac"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/mLF937C0hX.png" alt="Chevrolet"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/Tp2uven3h7-1.png" alt="Lamborghini"></div>
             <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/Tp2uven3h7-1.png" alt="Lamborghini"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/cdrp0674jG-1.png" alt="Bentley"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/07/ferrari-1.png" alt="Ferrari"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/cdrp0674jG-1.png" alt="Rolls Royce"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/zlj3UFz79n-1.png" alt="Porsche"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/ZfXrHr4tP6-1.png" alt="Mercedes"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/7R5C0rp0y3.png" alt="Land Rover"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/0cID35vkiB.png" alt="Audi"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/sxI5jw9d0g.png" alt="BMW"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/Mcu96Jz47.png" alt="Cadillac"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/mLF937C0hX.png" alt="Chevrolet"></div>
            <div class="slide"><img src="https://cdn.mkrentacar.com/wp-content/uploads/2025/03/Tp2uven3h7-1.png" alt="Lamborghini"></div>
        </div>
    </div>
</section>

<section id="featured" class="featured-cars">
    <div class="container">
        <h2>Our Featured Fleet</h2>
        
        <div class="car-grid"> 
            <?php
            // This loop now uses the $featured_cars array from the DATABASE
            foreach ($featured_cars as $car):
            ?>
                <div class="car-card">
                    <img src="uploads/<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['image']); ?>">
                    <div class="card-content">
                        <h3><?php echo htmlspecialchars($car['car_name']); ?></h3>
                        <h4><?php echo htmlspecialchars($car['model']); ?></h4>
                        <p class="price"><?php echo htmlspecialchars($car['price_per_day']); ?> AED / day</p>
                    
                        
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
    </div>
</section>

<section class="how-it-works">
    <div class="container">
        <h2>How It Works</h2>
        <div class="steps-grid">
            <div class="step">
                <span>1</span>
                <h3>Browse & Select</h3>
                <p>Choose your dream car from our exclusive, world-class fleet.</p>
            </div>
            <div class="step">
                <span>2</span>
                <h3>Book & Confirm</h3>
                <p>Select your dates and confirm your booking in just a few clicks.</p>
            </div>
            <div class="step">
                <span>3</span>
                <h3>Drive & Enjoy</h3>
                <p>Pick up your car and experience the thrill of the open road.</p>
            </div>
        </div>
    </div>
</section>



<?php
// Include the footer file
include 'footer.php';
?>