<?php
session_start();
include 'db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_type = $_POST['user_type'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (email, password, user_type) VALUES (?, ?, ?)");
        $stmt->execute([$email, $password, $user_type]);
        header("Location: login.php");
        exit;
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
        error_log("Signup error: " . $e->getMessage(), 3, 'logs/db_errors.log');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #3498db, #8e44ad);
        }
        .signup-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }
        input, select {
            width: 100%;
            padding: 0.8rem;
            margin: 0.5rem 0;
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
            width: 100%;
        }
        button:hover {
            background-color: #2980b9;
        }
        .error {
            color: red;
            margin-top: 1rem;
        }
        a {
            color: #3498db;
            text-decoration: none;
            cursor: pointer;
        }
        a:hover {
            text-decoration: underline;
        }
        @media (max-width: 480px) {
            .signup-container {
                margin: 1rem;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Signup</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="user_type" required>
                <option value="freelancer">Freelancer</option>
                <option value="client">Client</option>
            </select>
            <button type="submit">Signup</button>
        </form>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <p>Already have an account? <a href="redirect.php?page=login.php">Login</a></p>
    </div>
</body>
</html>
