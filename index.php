<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Order Management Dashboard</title>
<style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: linear-gradient(to right, #74ebd5, #ACB6E5);
        margin: 0;
        padding: 0;
        color: #333;
    }

    .container {
        max-width: 1000px;
        margin: 80px auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        padding: 50px;
        text-align: center;
    }

    h1 {
        color: #0077b6;
        font-size: 40px;
        margin-bottom: 40px;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .steps {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 20px;
        justify-content: center;
    }

    .step {
        background: #0077b6;
        color: white;
        font-size: 22px;
        font-weight: 600;
        padding: 20px;
        border-radius: 12px;
        text-decoration: none;
        transition: 0.3s;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .step:hover {
        background: #023e8a;
        transform: translateY(-5px);
    }

    footer {
        text-align: center;
        margin-top: 40px;
        font-size: 16px;
        color: #666;
    }

    .completed {
        background: #2a9d8f;
    }

    .completed:hover {
        background: #1e7c6e;
    }
</style>
</head>
<body>

<div class="container">
    <h1>Order Management System</h1>
    <div class="steps">
        <a href="payment.php" class="step">1. Food Order/Payment</a>
        <a href="order_verification.php" class="step">2. Order Verification</a>
        <a href="received_order.php" class="step">3. Received Order</a>
        <a href="order_routing.php" class="step">4. Order Routing</a>
        <a href="sorting.php" class="step">5. Sorting</a>
        <a href="packaging.php" class="step">6. Order Packaging</a>
        <a href="pick_up.php" class="step">7. Pick-Up</a>
        <a href="delivery.php" class="step">8. Delivery</a>
        <a href="order_tracking.php" class="step">9. Order Tracking</a>
        <a href="completed_order.php" class="step completed"> 10. Completed Order</a>
    </div>
</div>

<footer>© 2025 INA - Order Process Flow</footer>

</body>
</html>
