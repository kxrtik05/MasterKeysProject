<?php
// 1. Include connection and header
require_once 'conn.php';
include 'header.php';

// 2. Get the Car ID from the URL
// We use (int) to make sure it's a number, which helps prevent SQL injection
$car_id = 0;
if (isset($_GET['id'])) {
    $car_id = (int)$_GET['id'];
}



if ($car_id <= 0) {
    echo "<p class='container'>Invalid car ID.</p>";
    include 'footer.php';
    exit; // Stop the script
}

// 3. Securely fetch the car's details using a PREPARED STATEMENT
// This is critical for security
$sql = "SELECT car_name, model, price_per_day, image FROM cars WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // "i" means the parameter is an integer
    mysqli_stmt_bind_param($stmt, "i", $car_id);
    
    // Execute the statement
    mysqli_stmt_execute($stmt);
    
    // Get the result
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result->num_rows == 1) {
        $car = $result->fetch_assoc();
    } else {
        echo "<p class='container'>Car not found.</p>";
        include 'footer.php';
        exit; // Stop the script
    }
    mysqli_stmt_close($stmt);
} else {
    echo "<p class'container'>Error preparing database query.</p>";
    include 'footer.php';
    exit; // Stop the script
}
?>

<!-- This <style> block adds new CSS just for this page -->
<!-- It won't affect any other page -->
<style>
    .car-detail-section {
        padding: 5rem 0;
        color: var(--text-color);
    }
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr; /* 1 column on mobile */
        gap: 3rem;
        align-items: center;
    }
    .detail-image img {
        width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .detail-info h1 {
        font-size: 3rem;
        color: #FFF;
        margin-bottom: 0.5rem;
    }
    .detail-info h2 {
        font-size: 1.5rem;
        color: var(--text-muted);
        margin-top: 0;
        margin-bottom: 2rem;
        font-weight: 400;
    }
    .detail-info .price {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 2rem;
    }
    .detail-info .description {
        font-size: 1.1rem;
        line-height: 1.7;
        margin-bottom: 2.5rem;
        color: var(--text-muted);
    }

    /* On tablets and desktops, switch to 2 columns */
    @media (min-width: 768px) {
        .detail-grid {
            /* 1fr 1fr means 2 equal columns */
            grid-template-columns: 1fr 1fr;
        }
    }
</style>

<section class="car-detail-section">
    <div class="container">
        <div class="detail-grid">
            
            <!-- Column 1: Image -->
            <div class="detail-image">
                <img src="uploads/<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['car_name']); ?>">
            </div>
            
            <!-- Column 2: Info -->
            <div class="detail-info">
                <h1><?php echo htmlspecialchars($car['car_name']); ?></h1>
                <h2><?php echo htmlspecialchars($car['model']); ?></h2>
                
                <p class="price"><?php echo htmlspecialchars($car['price_per_day']); ?> AED / day</p>
                
                <p class="description">
                    Experience the thrill of driving this exceptional vehicle. Its stunning design and powerful performance make it the perfect choice for a memorable journey.
                </p>
                
                <form action="payment.php" method="POST" class="booking-form">
    
                    <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">
                    
                    <label for="user_name">Your Name:</label>
                    <input type="text" name="user_name" id="user_name" required>
                    
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" id="start_date" required>
                    
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" id="end_date" required>
                    
                    <button type="submit" class="btn btn-primary">Proceed to Payment</button>
                </form>

            <style>
            .booking-form {
                background-color: var(--card-bg);
                padding: 2rem;
                border-radius: 10px;
                margin-top: 2rem;
            }
            .booking-form label {
                display: block;
                margin-bottom: 0.5rem;
                font-weight: 600;
            }
            .booking-form input[type="text"],
            .booking-form input[type="date"] {
                width: 100%;
                padding: 0.8rem;
                margin-bottom: 1.5rem;
                border-radius: 5px;
                border: 1px solid #555;
                background-color: var(--dark-bg);
                color: var(--text-color);
                font-size: 1rem;
                font-family: var(--font-family);
            }
            </style>

            <a href="fleet.php" class="btn btn-primary">Back</a>
            </div>
            
        </div>
    </div>
</section>

<?php
// 5. Include the footer
include 'footer.php';
?>