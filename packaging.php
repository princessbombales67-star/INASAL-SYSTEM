<?php include 'database.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>6. Packaging</title>
<style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: linear-gradient(to right, #11998e, #38ef7d);
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
        color: #11998e;
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
    input {
        width: 100%;
        padding: 14px;
        font-size: 20px;
        border: 2px solid #ccc;
        border-radius: 8px;
        margin-bottom: 25px;
    }
    input[type="submit"] {
        background: #27ae60;
        color: white;
        font-size: 22px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        width: 100%;
        transition: 0.3s;
        padding: 14px;
    }
    input[type="submit"]:hover {
        background: #1e874b;
        transform: scale(1.05);
    }
</style>
</head>
<body>

<div class="container">
    <h2>6. Packaging</h2>

    <?php
    $counter_no = isset($_GET['counter_no']) ? intval($_GET['counter_no']) : '';
    $customer_name = isset($_GET['name']) ? $_GET['name'] : '';
    $order_item = isset($_GET['item']) ? $_GET['item'] : '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['package'])) {
        $counter_no = intval($_POST['counter_no']);
        $customer_name = $_POST['customer_name'];
        $order_item = $_POST['order_item'];

        $stmt = $conn->prepare("INSERT INTO packaging (counter_no, customer_name, order_item, status, date_packaged)
                                VALUES (?, ?, ?, 'Packaged', NOW())");
        if ($stmt) {
            $stmt->bind_param("iss", $counter_no, $customer_name, $order_item);
            $stmt->execute();
            echo "<div class='message success'>✅ Order packaged successfully!</div>";
        }
    }
    ?>

    <form method="post">
        <label>Counter No:</label>
        <input type="number" name="counter_no" value="<?= htmlspecialchars($counter_no) ?>" readonly>

        <label>Customer Name:</label>
        <input type="text" name="customer_name" value="<?= htmlspecialchars($customer_name) ?>" readonly>

        <label>Order Item:</label>
        <input type="text" name="order_item" value="<?= htmlspecialchars($order_item) ?>" readonly>

        <input type="submit" name="package" value="Mark as Packaged">
    </form>

    <a href="delivery.php?counter_no=<?= htmlspecialchars($counter_no) ?>&name=<?= urlencode($customer_name) ?>&item=<?= urlencode($order_item) ?>">Next: Delivery order →</a>
</div>

</body>
</html>
