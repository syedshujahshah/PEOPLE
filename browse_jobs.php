<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>redirect('login.php');</script>";
    exit;
}
$jobs = $pdo->query("SELECT * FROM jobs WHERE status = 'open'")->fetchAll();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['user_type'] == 'freelancer') {
    $job_id = $_POST['job_id'];
    $amount = $_POST['amount'];
    $proposal = $_POST['proposal'];
    $freelancer_id = $_SESSION['user_id'];
    
    $stmt = $pdo->prepare("INSERT INTO bids (job_id, freelancer_id, amount, proposal) VALUES (?, ?, ?, ?)");
    $stmt->execute([$job_id, $freelancer_id, $amount, $proposal]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Jobs</title>
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
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
        }
        .job-card {
            background: white;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .job-card h3 {
            color: #2c3e50;
            margin-top: 0;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 1rem;
        }
        input, textarea {
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
            width: 200px;
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
        <h2>Browse Jobs</h2>
        <?php foreach ($jobs as $job): ?>
            <div class="job-card">
                <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                <p><?php echo htmlspecialchars($job['description']); ?></p>
                <p>Category: <?php echo htmlspecialchars($job['category']); ?></p>
                <p>Budget: $<?php echo $job['budget']; ?></p>
                <p>Deadline: <?php echo $job['deadline']; ?></p>
                <?php if ($_SESSION['user_type'] == 'freelancer'): ?>
                    <form method="POST">
                        <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                        <input type="number" name="amount" placeholder="Your Bid ($)" required>
                        <textarea name="proposal" placeholder="Your Proposal" required></textarea>
                        <button type="submit">Place Bid</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <script src="script.js"></script>
</body>
</html>
