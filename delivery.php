<?php include 'database.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>6. Packaging</title>
<style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: linear-gradient(to right, #c9ffbf, #ffafbd);
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
        color: #2b9348;
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
        border-color: #2b9348;
        outline: none;
        box-shadow: 0 0 10px rgba(43,147,72,0.3);
    }

    input[type="submit"] {
        background: #2b9348;
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
        background: #1b7034;
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
        background: #0077b6;
        color: white;
        padding: 14px;
        font-size: 22px;
        border-radius: 10px;
        text-decoration: none;
        transition: 0.3s;
    }

    a.next-btn:hover {
        background: #023e8a;
        transform: scale(1.05);
    }
</style>
</head>
<body>

<div class="container">
    <h2>6. PACKAGING</h2>

    <?php
    // ✅ Get data from previous page (Sorting)
    $counter_no = $_GET['counter_no'] ?? '';
    $customer_name = $_GET['name'] ?? '';

    // ✅ When user clicks “Mark as Packaged”
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['package'])) {
        $counter_no = $_POST['counter_no'];
        $customer_name = $_POST['customer_name'];
        $status = "Packaged";

        // ✅ Insert into packaging table
        $sql = "INSERT INTO packaging (counter_no, customer_name, status, date_packaged)
                VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            echo "<div class='message error'>❌ SQL Error: " . htmlspecialchars($conn->error) . "</div>";
        } else {
            $stmt->bind_param("iss", $counter_no, $customer_name, $status);
            if ($stmt->execute()) {
                echo "<div class='message success'>✅ Order for <b>" . htmlspecialchars($customer_name) . "</b> has been <b>Packaged</b>.<br>Redirecting to Delivery Order...</div>";

                // ✅ Redirect to Delivery Order page
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'delivery.php?counter_no=$counter_no&name=" . urlencode($customer_name) . "';
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

        <input type="submit" name="package" value="Mark as Packaged">
    </form>

    <a href="delivery.php" class="next-btn">Next: Delivery Order →</a>
</div>

</body>
</html>
