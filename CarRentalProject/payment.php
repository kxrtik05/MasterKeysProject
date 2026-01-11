

<style>
    .payment-section {
        padding: 5rem 0;
        color: var(--text-color);
    }
    .payment-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 3rem;
        max-width: 900px;
        margin: 0 auto;
    }
    /* This is the box on the right */
    .booking-summary {
        background-color: var(--card-bg);
        border-radius: 10px;
        padding: 2rem;
        border: 1px solid #333;
    }
    .booking-summary h3 {
        color: #FFF;
        font-size: 1.5rem;
        border-bottom: 1px solid #444;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }
    .booking-summary p {
        color: var(--text-muted);
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }
    .booking-summary p span {
        font-weight: 600;
        color: var(--text-color);
        display: block;
        font-size: 1rem;
    }
    .booking-summary .price {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    /* This is the form on the left */
    .payment-form {
        background-color: var(--card-bg);
        border-radius: 10px;
        padding: 2rem;
        border: 1px solid #333;
    }
    .payment-form h2 {
        text-align: left;
        margin-bottom: 2rem;
    }
    .payment-form label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    .payment-form input[type="text"] {
        width: 100%;
        padding: 0.8rem;
        margin-bottom: 1.5rem;
        border-radius: 5px;
        border: 1px solid #555;
        background-color: var(--dark-bg);
        color: var(--text-color);
        font-size: 1rem;
    }
    .payment-row {
        display: flex;
        gap: 1rem;
    }
    .payment-row > div {
        flex: 1;
    }

    /* Make it 2 columns on desktop */
    @media (min-width: 900px) {
        .payment-grid {
            grid-template-columns: 1.5fr 1fr;
        }
    }
</style>

<?php
// 1. Include connection and header
require_once 'conn.php';
include 'header.php';

// 2. Check if data was POSTed
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: fleet.php");
    exit;
}

// 3. Get all the booking details from the PREVIOUS form
$car_id = $_POST['car_id'];
$user_name = $_POST['user_name'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

// 4. Get the car's details from the DB
$sql = "SELECT car_name, model, price_per_day FROM cars WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $car_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result->num_rows == 1) {
        $car = $result->fetch_assoc();
        
        // --- ADD THIS CALCULATION ---
        $price_per_day = $car['price_per_day'];
        $date1 = new DateTime($start_date);
        $date2 = new DateTime($end_date);
        $interval = $date1->diff($date2);
        $days = $interval->days;

        if ($days == 0) { $days = 1; } // Min 1 day rental

        $total_amount = $days * $price_per_day;
        // --- END OF CALCULATION ---

    } else {
        echo "<p class='container'>Car not found.</p>";
        include 'footer.php';
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "<p class'container'>Error preparing database query.</p>";
    include 'footer.php';
    exit;
}
?>

<section class="payment-section">
    <div class="container">
        
        <form action="process_booking.php" method="POST">
        
            <div class="payment-grid">
            
                <div class="payment-form">
                    <h2>Confirm Your Payment</h2>
                    <p style="color: var(--primary-color); margin-bottom: 2rem;">
                        Note: This is a demo. Do not enter real credit card details.
                    </p>

                    <label for="cc-name">Name on Card</label>
                    <input type="text" id="cc-name" value="<?php echo htmlspecialchars($user_name); ?>" required>
                    
                    <label for="cc-num">Card Number</label>
                    <input type="text" id="cc-num" placeholder="**** **** **** ****" required>
                    
                    <div class="payment-row">
                        <div>
                            <label for="cc-expiry">Expiry Date</label>
                            <input type="text" id="cc-expiry" placeholder="MM / YY" required>
                        </div>
                        <div>
                            <label for="cc-cvv">CVV</label>
                            <input type="text" id="cc-cvv" placeholder="123" required>
                        </div>
                    </div>
                </div>
                
                <div class="booking-summary">
                    <h3>Booking Summary</h3>
                    <p><span>Vehicle</span><?php echo htmlspecialchars($car['car_name'] . ' - ' . $car['model']); ?></p>
                    <p><span>Your Name</span><?php echo htmlspecialchars($user_name); ?></p>
                    <p><span>Start Date</span><?php echo htmlspecialchars($start_date); ?></p>
                    <p><span>End Date</span><?php echo htmlspecialchars($end_date); ?></p>
                    
                    <p class="price" style="margin-top: 1rem; border-top: 1px solid #444; padding-top: 1rem;">
                        <span>Total Price (<?php echo $days; ?> days)</span>
                        $<?php echo number_format($total_amount, 2); ?>
                    </p>
                </div>

            </div> <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car_id); ?>">
            <input type="hidden" name="user_name" value="<?php echo htmlspecialchars($user_name); ?>">
            <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
            <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
            <input type="hidden" name="total_amount" value="<?php echo htmlspecialchars($total_amount); ?>">
            
            <button type="submit" class="btn btn-primary" style="width: 100%; max-width: 900px; margin: 2rem auto 0; display: block; font-size: 1.2rem;">
                Confirm & Pay
            </button>

        </form>
    </div>
</section>

<?php
// 5. Include the footer
include 'footer.php';
?>