<?php
include('config/database.php');

// Kunin lahat ng orders
$query = "SELECT * FROM orders ORDER BY date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Order List</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f1f5fb;
    text-align: center;
    padding: 30px;
}
table {
    width: 95%;
    margin: auto;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}
th {
    background: #007bff;
    color: white;
}
tr {
    cursor: pointer;
    transition: 0.2s;
}
tr:hover {
    background-color: #e3f2fd;
}
</style>
<script>
// kapag na-click ang row, pupunta sa order_verification.php
function goToVerification(counterNo) {
    window.location.href = 'order_verification.php?counter_no=' + counterNo;
}
</script>
</head>
<body>

<h2>📋 Order List</h2>

<table>
    <tr>
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

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr onclick="goToVerification(<?= $row['counter_no'] ?>)">
        <td><?= htmlspecialchars($row['counter_no']) ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['type']) ?></td>
        <td><?= htmlspecialchars($row['item']) ?></td>
        <td><?= htmlspecialchars($row['address']) ?></td>
        <td><?= htmlspecialchars($row['contact']) ?></td>
        <td>₱<?= number_format($row['amount'], 2) ?></td>
        <td>₱<?= number_format($row['paid'], 2) ?></td>
        <td>₱<?= number_format($row['change_amt'], 2) ?></td>
        <td><?= htmlspecialchars($row['method']) ?></td>
        <td><?= htmlspecialchars($row['feedback']) ?></td>
        <td><?= htmlspecialchars($row['date']) ?></td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
