<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>redirect('login.php');</script>";
    exit;
}
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $skills = $_POST['skills'] ?? '';
    $experience = $_POST['experience'] ?? '';
    $portfolio = $_POST['portfolio'] ?? '';
    $business_name = $_POST['business_name'] ?? '';
    $location = $_POST['location'] ?? '';
    
    $stmt = $pdo->prepare("INSERT INTO profiles (user_id, full_name, skills, experience, portfolio, business_name, location) VALUES (?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE full_name = ?, skills = ?, experience = ?, portfolio = ?, business_name = ?, location = ?");
    $stmt->execute([$user_id, $full_name, $skills, $experience, $portfolio, $business_name, $location, $full_name, $skills, $experience, $portfolio, $business_name, $location]);
}

$stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id = ?");
$stmt->execute([$user_id]);
$profile = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
        <h2><?php echo $user_type == 'freelancer' ? 'Freelancer Profile' : 'Client Profile'; ?></h2>
        <form method="POST">
            <input type="text" name="full_name" placeholder="Full Name" value="<?php echo $profile['full_name'] ?? ''; ?>" required>
            <?php if ($user_type == 'freelancer'): ?>
                <textarea name="skills" placeholder="Skills"><?php echo $profile['skills'] ?? ''; ?></textarea>
                <textarea name="experience" placeholder="Experience"><?php echo $profile['experience'] ?? ''; ?></textarea>
                <textarea name="portfolio" placeholder="Portfolio"><?php echo $profile['portfolio'] ?? ''; ?></textarea>
            <?php else: ?>
                <input type="text" name="business_name" placeholder="Business Name" value="<?php echo $profile['business_name'] ?? ''; ?>">
            <?php endif; ?>
            <input type="text" name="location" placeholder="Location" value="<?php echo $profile['location'] ?? ''; ?>">
            <button type="submit">Update Profile</button>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>
