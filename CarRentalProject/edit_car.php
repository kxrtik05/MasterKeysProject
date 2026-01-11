<?php
include 'conn.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM cars WHERE id=$id");
    $row = mysqli_fetch_assoc($result);
} else {
    // Fallback values if no ID provided
    $row = ['car_name' => '', 'model' => '', 'price_per_day' => '', 'status' => 'Available'];
    $id = 0;
}
?>

<?php include 'header.php'; ?>

    <style>
        /* --- Color Variables --- */
        :root {
            --bg-body: #0a0a0a;       /* Very dark background */
            --bg-card: #141414;       /* Slightly lighter card background */
            --text-main: #ffffff;
            --text-muted: #a1a1a1;
            --accent: #e63946;        /* Gold accent */
            --accent-hover: #fc1a2dff;
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
            min-height: 100vh; /* Forces footer to bottom */
        }

        /* --- Main Container (Centers the form) --- */
        .container {
            flex: 1; /* Pushes footer down */
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: flex-start; /* Align to top (with margin) */
            padding: 60px 20px;
            width: 100%;
            box-sizing: border-box;
        }

        /* --- Form Card --- */
        .card {
            background-color: var(--bg-card);
            width: 100%;
            max-width: 600px; /* Limits width to look good */
            padding: 40px;
            border-radius: 12px; /* Smooth corners */
            border: 1px solid var(--border);
            box-shadow: 0 20px 40px rgba(0,0,0,0.6); /* Nice drop shadow */
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-header h2 { margin: 0 0 10px 0; font-size: 32px; }
        .form-header p { color: var(--text-muted); margin: 0; }

        /* --- Input Styling --- */
        .form-group { margin-bottom: 25px; }

        label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 600;
        }

        /* Force inputs to be distinct and full width */
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
            box-sizing: border-box; /* Ensures padding doesn't break layout */
            transition: border-color 0.3s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--accent);
        }

        /* Row logic for side-by-side inputs */
        .row { display: flex; gap: 20px; }
        .col { flex: 1; }
        @media (max-width: 600px) { .row { flex-direction: column; gap: 0; } }

        /* File Upload Styling */
        input[type="file"] {
            background: var(--input-bg);
            padding: 10px;
            border-radius: 8px;
            width: 100%;
            box-sizing: border-box;
            color: var(--text-muted);
        }

        /* --- Button Styling --- */
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

    </style>

    <div class="container">
        <div class="card">
            
            <div class="form-header">
                <h2>Edit Car Details</h2>
                <p>Update the vehicle information below.</p>
            </div>

            <form method="POST" enctype="multipart/form-data">
                
                <!-- Row 1 -->
                <div class="row">
                    <div class="col form-group">
                        <label>Car Name:</label>
                        <input type="text" name="car_name" value="<?= htmlspecialchars($row['car_name'] ?? '') ?>" required>
                    </div>

                    <div class="col form-group">
                        <label>Model:</label>
                        <input type="text" name="model" value="<?= htmlspecialchars($row['model'] ?? '') ?>" required>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="row">
                    <div class="col form-group">
                        <label>Price per Day:</label>
                        <input type="number" step="0.01" name="price_per_day" value="<?= htmlspecialchars($row['price_per_day'] ?? '') ?>" required>
                    </div>

                    <div class="col form-group">
                        <label>Status:</label>
                        <select name="status">
                            <option value="Available" <?= (isset($row['status']) && $row['status'] == 'Available') ? 'selected' : '' ?>>Available</option>
                            <option value="Rented" <?= (isset($row['status']) && $row['status'] == 'Rented') ? 'selected' : '' ?>>Rented</option>
                        </select>
                    </div>
                </div>

                <!-- File Upload -->
                <div class="form-group">
                    <label>Change Image:</label>
                    <input type="file" name="image">
                    <div style="font-size: 13px; color: #666; margin-top: 8px;">Leave empty to keep current image.</div>
                </div>

                <!-- Button -->
                <input type="submit" name="update" value="Update Car" class="btn-submit">

            </form>
        </div>
    </div>

<?php include 'footer.php'; ?>

<?php
if (isset($_POST['update'])) {
    $car_name = $_POST['car_name'];
    $model = $_POST['model'];
    $price = $_POST['price_per_day'];
    $status = $_POST['status'];

    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "uploads/" . $image);
        $update_image = ", image='$image'";
    } else {
        $update_image = "";
    }

    $sql = "UPDATE cars SET car_name='$car_name', model='$model', price_per_day='$price', status='$status' $update_image WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "<script> window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>