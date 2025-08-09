<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'client') {
    echo "<script>redirect('login.php');</script>";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $job_id = $_POST['job_id'];
    $freelancer_id = $_POST['freelancer_id'];
    $amount = $_POST['amount'];
    $payment_type = $_POST['payment_type'];
    $client_id = $_SESSION['user_id'];
    
    $stmt = $pdo->prepare("INSERT INTO payments (job_id, client_id, freelancer_id, amount, payment_type, status) VALUES (?, ?, ?, ?, ?, 'completed')");
    $stmt->execute([$job_id, $client_id, $freelancer_id, $amount, $payment_type]);
    echo "<p>Payment processed successfully!</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        nav a {
            color: white;
            margin: 0 1rem;
            text-decoration: none;
        }
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h2 {
            color: #2c3e50;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        input, select {
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }
        button {
            background-color: #3498db;
            color: white;
            padding: 0.8rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }
        button:hover {
            background-color: #2980b9;
        }
        @media (max-width: 768px) {
            .container {
                margin: 1rem;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Freelance Marketplace</h1>
        <nav>
            <a href="#" onclick="redirect('index.php')">Home</a>
            <a href="#" onclick="redirect('profile.php')">Profile</a>
            <a href="#" onclick="redirect('logout.php')">Logout</a>
        </nav>
    </header>
    <div class="container">
        <h2>Make Payment</h2>
        <form method="POST">
            <input type="number" name="job_id" placeholder="Job ID" required>
            <input type="number" name="freelancer_id" placeholder="Freelancer ID" required>
            <input type="number" name="amount" placeholder="Amount ($)" required>
            <select name="payment_type" required>
                <option value="cod">Cash on Delivery</option>
                <option value="online">Online Payment (Dummy)</option>
            </select>
            <button type="submit">Process Payment</button>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>
