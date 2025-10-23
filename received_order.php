<?php include 'database.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>3. Received Order</title>
<style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: linear-gradient(to right, #f8fafc, #e2ebf0);
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

    input, select {
        width: 100%;
        padding: 14px;
        font-size: 20px;
        border: 2px solid #ccc;
        border-radius: 8px;
        margin-bottom: 25px;
        transition: 0.3s;
    }

    input:focus, select:focus {
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

    a.next-btn {
        display: block;
        text-align: center;
        margin-top: 30px;
        background: #28a745;
        color: white;
        padding: 14px;
        font-size: 22px;
        border-radius: 10px;
        text-decoration: none;
        transition: 0.3s;
    }

    a.next-btn:hover {
        background: #218838;
        transform: scale(1.05);
    }
</style>
</head>

<body>
<div class="container">
    <h2>3. Received Order</h2>

    <?php
    // ✅ Get data from Order Verification redirect (via GET)
    $counter_no = $_GET['counter_no'] ?? '';
    $customer_name = $_GET['name'] ?? '';
    $order_item = $_GET['item'] ?? '';
    $order_type = $_GET['type'] ?? '';
    $amount = $_GET['amount'] ?? '';

    // ✅ When submitted (Mark as Received)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['receive'])) {
        $counter_no = $_POST['counter_no'];
        $customer_name = $_POST['customer_name'];
        $order_item = $_POST['order_item'];
        $remarks = "Received";

        // Insert into order_tracking table
        $sql = "INSERT INTO order_tracking (counter_no, customer_name, current_status, remarks, date_updated)
                VALUES (?, ?, 'Received Order', ?, NOW())";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            echo "<div class='message error'>❌ SQL Error: " . htmlspecialchars($conn->error) . "</div>";
        } else {
            $stmt->bind_param("iss", $counter_no, $customer_name, $remarks);
            if ($stmt->execute()) {
                echo "<div class='message success'>✅ Order for <b>" . htmlspecialchars($customer_name) . "</b> marked as <b>Received</b>.<br>Redirecting to Order Routing...</div>";

                // ✅ Redirect to next process (Order Routing)
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'order_routing.php?counter_no=$counter_no&name=" . urlencode($customer_name) . "&item=" . urlencode($order_item) . "&type=" . urlencode($order_type) . "&amount=" . urlencode($amount) . "';
                    }, 2000);
                </script>";
            } else {
                echo "<div class='message error'>❌ Failed to insert: " . htmlspecialchars($stmt->error) . "</div>";
            }
            $stmt->close();
        }
    }
    ?>

    <form method="post">
        <label>Counter No:</label>
        <input type="number" name="counter_no" value="<?= htmlspecialchars($counter_no) ?>" readonly>

        <label>Customer Name:</label>
        <input type="text" name="customer_name" value="<?= htmlspecialchars($customer_name) ?>" readonly>

        <label>Order Item (e.g. Chicken Inasal, Pork BBQ, etc.):</label>
        <input type="text" name="order_item" value="<?= htmlspecialchars($order_item) ?>" readonly>

        <input type="submit" name="receive" value="Mark as Received">
    </form>

    <a href="order_routing.php" class="next-btn">Next: Order Routing →</a>
</div>
</body>
</html>
