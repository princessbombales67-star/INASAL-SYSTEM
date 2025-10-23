<?php include 'database.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>5. Sorting</title>
<style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: linear-gradient(to right, #56ccf2, #2f80ed);
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
        color: #2f80ed;
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
        transition: 0.3s;
    }
    input:focus {
        border-color: #2f80ed;
        outline: none;
        box-shadow: 0 0 10px rgba(47,128,237,0.3);
    }
    input[type="submit"] {
        background: #2f80ed;
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
        background: #1b63c7;
        transform: scale(1.05);
    }
    a {
        display: inline-block;
        margin-top: 20px;
        color: white;
        background: #27ae60;
        padding: 14px 25px;
        text-decoration: none;
        font-size: 20px;
        border-radius: 8px;
        text-align: center;
        width: 100%;
    }
    a:hover {
        background: #1e874b;
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
</style>
</head>
<body>

<div class="container">
    <h2>5. Sorting</h2>

    <?php
    $counter_no = isset($_GET['counter_no']) ? intval($_GET['counter_no']) : '';
    $customer_name = isset($_GET['name']) ? $_GET['name'] : '';
    $order_item = isset($_GET['item']) ? $_GET['item'] : '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sort'])) {
        $counter_no = intval($_POST['counter_no']);
        $customer_name = $_POST['customer_name'];
        $order_item = $_POST['order_item'];

        $stmt = $conn->prepare("INSERT INTO sorting (counter_no, customer_name, order_item, status, date_sorted)
                                VALUES (?, ?, ?, 'Sorted', NOW())");
        if ($stmt) {
            $stmt->bind_param("iss", $counter_no, $customer_name, $order_item);
            if ($stmt->execute()) {
                echo "<div class='message success'>✅ Order from Counter <b>$counter_no</b> marked as Sorted!</div>";
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'packaging.php?counter_no=$counter_no&name=" . urlencode($customer_name) . "&item=" . urlencode($order_item) . "';
                    }, 1500);
                </script>";
            } else {
                echo "<div class='message error'>❌ Database error: " . htmlspecialchars($stmt->error) . "</div>";
            }
            $stmt->close();
        } else {
            echo "<div class='message error'>❌ SQL prepare failed: " . htmlspecialchars($conn->error) . "</div>";
        }
    }
    ?>

    <form method="post">
        <label>Counter No:</label>
        <input type="number" name="counter_no" value="<?= htmlspecialchars($counter_no) ?>" required>

        <label>Customer Name:</label>
        <input type="text" name="customer_name" value="<?= htmlspecialchars($customer_name) ?>" required>

        <label>Order Item (e.g. Chicken Inasal, Pork BBQ, etc.):</label>
        <input type="text" name="order_item" value="<?= htmlspecialchars($order_item) ?>" required>

        <input type="submit" name="sort" value="Mark as Sorted">
    </form>

    <a href="packaging.php?counter_no=<?= htmlspecialchars($counter_no) ?>&name=<?= urlencode($customer_name) ?>&item=<?= urlencode($order_item) ?>">
        Next: Packaging →
    </a>
</div>

</body>
</html>
