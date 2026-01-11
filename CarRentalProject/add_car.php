<?php include 'conn.php'; ?>
<?php include 'header.php'; ?>

    <style>
        /* --- Color Variables --- */
        :root {
            --bg-body: #0a0a0a;       /* Very dark background */
            --bg-card: #141414;       /* Slightly lighter card background */
            --text-main: #ffffff;
            --text-muted: #a1a1a1;
            --accent: #e0b041;        /* Gold accent */
            --accent-hover: #c99b2e;
            --border: #333333;
            --input-bg: #222222;
        }

        /* --- Global Layout --- */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- Header Styling --- */
        header {
            background-color: var(--bg-card);
            padding: 20px 40px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 { margin: 0; font-size: 24px; font-weight: bold; }
        header .nav-links a { color: var(--text-muted); text-decoration: none; margin-left: 20px; transition: 0.3s; }
        header .nav-links a:hover { color: var(--accent); }

        /* --- Main Container (Centers the content) --- */
        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 60px 20px;
            width: 100%;
            box-sizing: border-box;
        }

        /* --- Card Styling --- */
        .card {
            background-color: var(--bg-card);
            width: 100%;
            max-width: 600px;
            padding: 40px;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 20px 40px rgba(0,0,0,0.6);
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-header h2 { margin: 0 0 10px 0; font-size: 32px; }
        .form-header p { color: var(--text-muted); margin: 0; }

        /* --- Form Elements --- */
        .form-group { margin-bottom: 25px; }

        label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 600;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 14px;
            background-color: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: white;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input:focus {
            outline: none;
            border-color: var(--accent);
        }

        /* Input Row Layout */
        .row { display: flex; gap: 20px; }
        .col { flex: 1; }
        @media (max-width: 600px) { .row { flex-direction: column; gap: 0; } }

        /* File Input */
        input[type="file"] {
            background: var(--input-bg);
            padding: 10px;
            border-radius: 8px;
            width: 100%;
            box-sizing: border-box;
            color: var(--text-muted);
        }

        /* --- Button --- */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background-color: var(--accent);
            color: #000;
            font-weight: 800;
            font-size: 16px;
            text-transform: uppercase;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s, background-color 0.2s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: var(--accent-hover);
            transform: translateY(-2px);
        }

        /* --- Footer --- */
        footer {
            text-align: center;
            padding: 30px;
            background-color: var(--bg-card);
            border-top: 1px solid var(--border);
            color: var(--text-muted);
            font-size: 14px;
        }
    </style>

    <div class="container">
        <div class="card">
            
            <div class="form-header">
                <h2>Add New Car</h2>
                <p>Enter the details to add a vehicle to the fleet.</p>
            </div>

            <form action="" method="POST" enctype="multipart/form-data">
                
                <!-- Row 1: Name & Model -->
                <div class="row">
                    <div class="col form-group">
                        <label>Car Name:</label>
                        <input type="text" name="car_name" required>
                    </div>

                    <div class="col form-group">
                        <label>Model:</label>
                        <input type="text" name="model" required>
                    </div>
                </div>

                <!-- Row 2: Price & Image -->
                <div class="row">
                    <div class="col form-group">
                        <label>Price per Day:</label>
                        <input type="number" step="0.01" name="price_per_day" required>
                    </div>
                    
                    <div class="col form-group">
                        <label>Image:</label>
                        <input type="file" name="image" accept="image/*" required>
                    </div>
                </div>

                <!-- Submit Button -->
                <input type="submit" name="submit" value="Add Car" class="btn-submit">

            </form>
        </div>
    </div>

<?php include 'footer.php'; ?>

<?php
if (isset($_POST['submit'])) {
    $car_name = $_POST['car_name'];
    $model = $_POST['model'];
    $price = $_POST['price_per_day'];
    
    // Check if image is selected
    if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ""){
        $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        
        // Ensure uploads folder exists
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        move_uploaded_file($tmp_name, "uploads/" . $image);

        $sql = "INSERT INTO cars (car_name, model, price_per_day, image) 
                VALUES ('$car_name', '$model', '$price', '$image')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Car added successfully!'); window.location='index.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
         echo "<script>alert('Please select an image.');</script>";
    }
}
?>