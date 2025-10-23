<?php include 'database.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment (Dine-In / Take-Out)</title>
<style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: linear-gradient(to right, #ffecd2, #fcb69f);
        color: #333;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 950px;
        margin: 70px auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        padding: 50px;
    }

    h2 {
        color: #e63946;
        text-align: center;
        font-size: 40px;
        margin-bottom: 30px;
        text-transform: uppercase;
    }

    label {
        display: block;
        font-weight: bold;
        font-size: 20px;
        margin-bottom: 8px;
        color: #222;
    }

    input, select, textarea {
        width: 100%;
        padding: 14px;
        font-size: 18px;
        border: 2px solid #ccc;
        border-radius: 8px;
        margin-bottom: 20px;
        transition: 0.3s;
    }

    input:focus, select:focus, textarea:focus {
        border-color: #e63946;
        outline: none;
        box-shadow: 0 0 10px rgba(230,57,70,0.3);
    }

    input[type="submit"] {
        background: #e63946;
        color: white;
        font-size: 22px;
        border: none;
        cursor: pointer;
        transition: 0.3s;
    }

    input[type="submit"]:hover {
        background: #d62828;
        transform: scale(1.05);
    }

    .success {
        background-color:#d4edda;
        color:#155724;
        padding:10px;
        border-radius:8px;
        margin-top:15px;
    }

    .error {
        background-color:#f8d7da;
        color:#721c24;
        padding:10px;
        border-radius:8px;
        margin-top:15px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 40px;
        font-size: 16px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }

    th {
        background: #e63946;
        color: white;
    }

    tr:nth-child(even) {
        background: #f9f9f9;
    }

    .next-btn {
        display: inline-block;
        margin-top: 30px;
        padding: 14px 25px;
        background-color: #28a745;
        color: white;
        font-size: 22px;
        border-radius: 10px;
        text-decoration: none;
        transition: 0.3s;
    }

    .next-btn:hover {
        background-color: #218838;
        transform: scale(1.05);
    }
</style>

<script>
function updatePrice() {
    const prices = {
        "Chicken Inasal": 150,
        "Pork BBQ": 120,
        "Sisig": 180,
        "Liempo": 200,
        "Paa with Rice": 160,
        "Pecho with Rice": 170
    };
    const item = document.getElementById("order_item").value;
    document.getElementById("total_amount").value = prices[item] || 0;
}

function computeChange() {
    const total = parseFloat(document.getElementById("total_amount").value) || 0;
    const paid = parseFloat(document.getElementById("amount_paid").value) || 0;
    document.getElementById("change_amount").value = (paid - total).toFixed(2);
}

function toggleDeliveryFields() {
    const type = document.getElementById("order_type").value;
    const deliveryFields = document.getElementById("delivery_fields");
    deliveryFields.style.display = type === "Take-Out" ? "block" : "none";
}
</script>
</head>

<body>
<div class="container">
    <h2>💸Order Food / Payment — Dine-In / Take-Out</h2>

    <form method="post">
        <label>Counter No:</label>
        <input type="number" name="counter_no" required>

        <label>Customer Name:</label>
        <input type="text" name="customer_name" required>

        <label>Order Type:</label>
        <select name="order_type" id="order_type" onchange="toggleDeliveryFields()" required>
            <option value="">Select Type</option>
            <option value="Dine-In">Dine-In</option>
            <option value="Take-Out">Take-Out / Delivery</option>
        </select>

        <div id="delivery_fields" style="display:none;">
            <label>Delivery Address:</label>
            <input type="text" name="delivery_address">

            <label>Contact Number:</label>
            <input type="text" name="contact_number">
        </div>

        <label>Order Item:</label>
        <select name="order_item" id="order_item" onchange="updatePrice()" required>
            <option value="">Select Item</option>
            <option value="Chicken Inasal">Chicken Inasal - ₱150</option>
            <option value="Pork BBQ">Pork BBQ - ₱120</option>
            <option value="Sisig">Sisig - ₱180</option>
            <option value="Liempo">Liempo - ₱200</option>
            <option value="Paa with Rice">Paa with Rice - ₱160</option>
            <option value="Pecho with Rice">Pecho with Rice - ₱170</option>
        </select>

        <label>Total Amount (₱):</label>
        <input type="number" id="total_amount" name="total_amount" readonly>

        <label>Amount Paid (₱):</label>
        <input type="number" id="amount_paid" name="amount_paid" oninput="computeChange()" required>

        <label>Change (₱):</label>
        <input type="number" id="change_amount" name="change_amount" readonly>

        <label>Payment Method:</label>
        <select name="payment_method" required>
            <option value="">Select Method</option>
            <option value="Cash">Cash</option>
            <option value="GCash">GCash</option>
            <option value="Card">Card</option>
        </select>

        <label>Customer Feedback:</label>
        <textarea name="feedback" rows="3" placeholder="How was your food or service?"></textarea>

        <input type="submit" name="pay" value="Submit Payment">
    </form>

    <?php
    if (isset($_POST['pay'])) {
        $counter_no = $_POST['counter_no'];
        $customer_name = $_POST['customer_name'];
        $order_type = $_POST['order_type'];
        $delivery_address = $_POST['delivery_address'] ?? '';
        $contact_number = $_POST['contact_number'] ?? '';
        $order_item = $_POST['order_item'];
        $total_amount = $_POST['total_amount'];
        $amount_paid = $_POST['amount_paid'];
        $change_amount = $_POST['change_amount'];
        $payment_method = $_POST['payment_method'];
        $feedback = $_POST['feedback'] ?? '';

        $sql = "INSERT INTO payment (counter_no, customer_name, order_type, delivery_address, contact_number, order_item, total_amount, amount_paid, change_amount, payment_method, feedback, status)
                VALUES ('$counter_no', '$customer_name', '$order_type', '$delivery_address', '$contact_number', '$order_item', '$total_amount', '$amount_paid', '$change_amount', '$payment_method', '$feedback', 'Paid')";

        if (mysqli_query($conn, $sql)) {
            echo "<div class='success'>✅ Payment successfully recorded for <b>$customer_name</b> (<i>$order_item</i>).</div>";
        } else {
            echo "<div class='error'>❌ Error: " . mysqli_error($conn) . "</div>";
        }
    }
    ?>
<h2>📋 Payment Records</h2>
<table>
<tr>
    <th>ID</th>
    <th>Counter No</th>
    <th>Name</th>
    <th>Type</th>
    <th>Item</th>
    <th>Address</th>
    <th>Contact</th>
    <th>Amount</th>
    <th>Paid</th>
    <th>Change</th>
    <th>Method</th>
    <th>Feedback</th>
    <th>Date</th>
</tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM payment ORDER BY payment_date DESC");
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        // Encode data to be passed to order_verification.php
        $params = http_build_query([
            'id' => $row['id'],
            'counter_no' => $row['counter_no'],
            'name' => $row['customer_name'],
            'type' => $row['order_type'],
            'item' => $row['order_item'],
            'address' => $row['delivery_address'],
            'contact' => $row['contact_number'],
            'amount' => $row['total_amount'],
            'paid' => $row['amount_paid'],
            'change' => $row['change_amount'],
            'method' => $row['payment_method'],
            'feedback' => $row['feedback']
        ]);

        echo "<tr style='cursor:pointer;' 
                onclick=\"window.location.href='order_verification.php?$params'\">";
        echo "
            <td>{$row['id']}</td>
            <td>{$row['counter_no']}</td>
            <td>{$row['customer_name']}</td>
            <td>{$row['order_type']}</td>
            <td>{$row['order_item']}</td>
            <td>{$row['delivery_address']}</td>
            <td>{$row['contact_number']}</td>
            <td>₱{$row['total_amount']}</td>
            <td>₱{$row['amount_paid']}</td>
            <td>₱{$row['change_amount']}</td>
            <td>{$row['payment_method']}</td>
            <td>{$row['feedback']}</td>
            <td>{$row['payment_date']}</td>
        ";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='13'>No payments yet.</td></tr>";
}
?>
</table>

    <!-- ✅ Next Step Button -->
    <div style="text-align:center;">
        <a href="order_verification.php" class="next-btn">Next: Order Verification →</a>
    </div>
</div>
</body>
</html>
