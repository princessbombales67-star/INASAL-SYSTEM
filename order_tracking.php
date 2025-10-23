<?php include 'database.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>3. Order Tracking</title>
<style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: linear-gradient(to right, #fbc2eb, #a6c1ee);
        margin: 0;
        padding: 0;
        color: #333;
    }

    .container {
        max-width: 800px;
        margin: 70px auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        padding: 50px;
    }

    h2 {
        color: #0077b6;
        text-align: center;
        font-size: 40px;
        margin-bottom: 30px;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    label {
        display: block;
        font-weight: bold;
        font-size: 20px;
        margin-bottom: 8px;
        color: #222;
    }

    input[type="number"],
    input[type="text"],
    select,
    textarea {
        width: 100%;
        padding: 14px;
        font-size: 20px;
        border: 2px solid #ccc;
        border-radius: 8px;
        margin-bottom: 25px;
        transition: 0.3s;
    }

    input:focus, select:focus, textarea:focus {
        border-color: #0077b6;
        outline: none;
        box-shadow: 0 0 10px rgba(0,119,182,0.3);
    }

    input[type="submit"] {
        background: #0077b6;
        color: white;
        font-size: 22px;
        padding: 14px 25px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        width: 100%;
        transition: 0.3s;
    }

    input[type="submit"]:hover {
        background: #023e8a;
        transform: scale(1.05);
    }

    .message {
        text-align: center;
        font-size: 20px;
        margin-top: 20px;
        padding: 10px;
        border-radius: 10px;
    }

    .success {
        background-color: #d4edda;
        color: #155724;
    }

    .error {
        background-color: #f8d7da;
        color: #721c24;
    }

    a {
        display: inline-block;
        margin-top: 20px;
        color: #0077b6;
        text-decoration: none;
        font-size: 20px;
    }

    a:hover {
        color: #023e8a;
        text-decoration: underline;
    }

    footer {
        text-align: center;
        margin-top: 40px;
        font-size: 16px;
        color: #666;
    }
</style>
</head>
<body>

<div class="container">
    <h2>3. Order Tracking</h2>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['track'])) {
        $counter_no = isset($_POST['counter_no']) ? intval($_POST['counter_no']) : 0;
        $customer_name = isset($_POST['customer_name']) ? trim($_POST['customer_name']) : '';
        $current_status = isset($_POST['current_status']) ? trim($_POST['current_status']) : '';
        $remarks = isset($_POST['remarks']) ? trim($_POST['remarks']) : '';

        $errors = [];
        if ($counter_no <= 0) $errors[] = "Counter No is required.";
        if ($customer_name === '') $errors[] = "Customer Name is required.";
        if ($current_status === '') $errors[] = "Current Status is required.";

        if (empty($errors)) {
            $stmt = $conn->prepare("INSERT INTO order_tracking (counter_no, customer_name, current_status, remarks, date_updated) VALUES (?, ?, ?, ?, NOW())");
            if ($stmt) {
                $stmt->bind_param("isss", $counter_no, $customer_name, $current_status, $remarks);
                if ($stmt->execute()) {
                    echo "<div class='message success'>✅ Order for <b>" . htmlspecialchars($customer_name) . "</b> updated to <i>" . htmlspecialchars($current_status) . "</i>.</div>";
                } else {
                    echo "<div class='message error'>❌ Insert failed: " . htmlspecialchars($stmt->error) . "</div>";
                }
                $stmt->close();
            } else {
                echo "<div class='message error'>❌ Prepare failed: " . htmlspecialchars($conn->error) . "</div>";
            }
        } else {
            echo "<div class='message error'>" . implode("<br>", array_map('htmlspecialchars', $errors)) . "</div>";
        }
    }
    ?>

    <form method="post" novalidate>
        <label>Counter No:</label>
        <input type="number" name="counter_no" min="1" required>

        <label>Customer Name:</label>
        <input type="text" name="customer_name" required>

        <label>Current Status:</label>
        <select name="current_status" required>
            <option value="">-- Select Status --</option>
            <option value="Preparing">Preparing</option>
            <option value="Cooking">Cooking</option>
            <option value="Ready for Pickup">Ready for Pickup</option>
            <option value="Completed">Completed</option>
        </select>

        <label>Remarks:</label>
        <textarea name="remarks" rows="3" placeholder="Optional remarks..."></textarea>

        <input type="submit" name="track" value="Update Order Status">
    </form>

    <a href="sorting.php">Next: Sorting →</a>
</div>

<footer>© 2025 INA</footer>

</body>
</html>
