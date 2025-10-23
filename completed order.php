<?php include 'database.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>3. Order Routing</title>
<style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: linear-gradient(to right, #f6d365, #fda085);
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
        color: #e76f51;
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
        border-color: #e76f51;
        outline: none;
        box-shadow: 0 0 10px rgba(231,111,81,0.3);
    }

    input[type="submit"] {
        background: #e76f51;
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
        background: #d65a31;
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
        color: #457b9d;
        text-decoration: none;
        font-size: 20px;
    }

    a:hover {
        color: #1d3557;
        text-decoration: underline;
    }
</style>
</head>
<body>

<div class="container">
    <h2>3. Order Routing</h2>

    <?php
    // ✅ Get counter number if passed from previous step
    $counter_no = isset($_GET['counter_no']) ? intval($_GET['counter_no']) : '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['route'])) {
        // ✅ Safe retrieval with null coalescing (no warning)
        $counter_no = isset($_POST['counter_no']) ? intval($_POST['counter_no']) : 0;
        $kitchen_section = isset($_POST['kitchen_section']) ? trim($_POST['kitchen_section']) : '';

        if ($counter_no > 0 && $kitchen_section !== '') {
            $stmt = $conn->prepare("INSERT INTO order_routing (counter_no, kitchen_section, status, date_routed) VALUES (?, ?, 'Routed', NOW())");
            if ($stmt) {
                $stmt->bind_param("is", $counter_no, $kitchen_section);
                if ($stmt->execute()) {
                    echo "<div class='message success'>✅ Order from Counter <b>$counter_no</b> routed to <b>$kitchen_section</b> section!</div>";

                    // ✅ Redirect automatically to sorting page
                    echo "<script>
                        setTimeout(function() {
                            window.location.href = 'sorting.php?counter_no=$counter_no&section=$kitchen_section';
                        }, 1500);
                    </script>";
                } else {
                    echo "<div class='message error'>❌ Database error: " . htmlspecialchars($stmt->error) . "</div>";
                }
                $stmt->close();
            } else {
                echo "<div class='message error'>❌ SQL prepare failed: " . htmlspecialchars($conn->error) . "</div>";
            }
        } else {
            echo "<div class='message error'>⚠️ Please complete all fields before routing.</div>";
        }
    }
    ?>

    <form method="post">
        <label>Counter No:</label>
        <input type="number" name="counter_no" value="<?= htmlspecialchars($counter_no) ?>" required>

        <label>Kitchen Section:</label>
        <select name="kitchen_section" required>
            <option value="">-- Select Section --</option>
            <option value="Rice">Rice</option>
            <option value="Grill">Grill</option>
            <option value="Drinks">Drinks</option>
        </select>

        <input type="submit" name="route" value="Mark as Routed">
    </form>

    <a href="sorting.php">Next: Sorting →</a>
</div>

</body>
</html>
