<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>redirect('login.php');</script>";
    exit;
}
$user_id = $_SESSION['user_id'];
$messages = $pdo->query("SELECT m.*, u.email FROM messages m JOIN users u ON m.sender_id = u.id WHERE m.receiver_id = $user_id OR m.sender_id = $user_id ORDER BY m.sent_at DESC")->fetchAll();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $receiver_id = $_POST['receiver_id'];
    $job_id = $_POST['job_id'] ?? null;
    $message = $_POST['message'];
    // File upload handling
    $file_path = '';
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $file_path = $upload_dir . basename($_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], $file_path);
    }
    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, job_id, message, file_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $receiver_id, $job_id, $message, $file_path]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messaging</title>
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
        .message {
            border-bottom: 1px solid #ccc;
            padding: 1rem 0;
        }
        .message p {
            margin: 0.5rem 0;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2rem;
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
        <h2>Messages</h2>
        <?php foreach ($messages as $msg): ?>
            <div class="message">
                <p><strong>From:</strong> <?php echo htmlspecialchars($msg['email']); ?></p>
                <p><?php echo htmlspecialchars($msg['message']); ?></p>
                <?php if ($msg['file_path']): ?>
                    <p><a href="<?php echo $msg['file_path']; ?>" download>Download File</a></p>
                <?php endif; ?>
                <p><em><?php echo $msg['sent_at']; ?></em></p>
            </div>
        <?php endforeach; ?>
        <h3>Send Message</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="number" name="receiver_id" placeholder="Receiver ID" required>
            <input type="number" name="job_id" placeholder="Job ID (optional)">
            <textarea name="message" placeholder="Message" required></textarea>
            <input type="file" name="file">
            <button type="submit">Send</button>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>
