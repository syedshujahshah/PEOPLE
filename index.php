<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelance Marketplace</title>
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
            font-weight: bold;
            cursor: pointer;
        }
        nav a:hover {
            color: #3498db;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        .hero {
            text-align: center;
            padding: 3rem 0;
            background: linear-gradient(135deg, #3498db, #8e44ad);
            color: white;
            border-radius: 10px;
        }
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .categories, .freelancers {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card h3 {
            color: #2c3e50;
        }
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 1.8rem;
            }
            .categories, .freelancers {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Freelance Marketplace</h1>
        <nav>
            <a href="redirect.php?page=index.php">Home</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="redirect.php?page=profile.php">Profile</a>
                <a href="redirect.php?page=logout.php">Logout</a>
            <?php else: ?>
                <a href="redirect.php?page=signup.php">Signup</a>
                <a href="redirect.php?page=login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>
    <div class="container">
        <div class="hero">
            <h1>Hire Top Freelancers for Your Projects</h1>
            <p>Find the best talent for your business needs.</p>
        </div>
        <h2>Job Categories</h2>
        <div class="categories">
            <div class="card"><h3>Web Development</h3><p>Build stunning websites.</p></div>
            <div class="card"><h3>Graphic Design</h3><p>Create amazing visuals.</p></div>
            <div class="card"><h3>Content Writing</h3><p>Engage with words.</p></div>
            <div class="card"><h3>Digital Marketing</h3><p>Boost your brand.</p></div>
        </div>
        <h2>Featured Freelancers</h2>
        <div class="freelancers">
            <div class="card"><h3>John Doe</h3><p>Web Developer | 4.8 ★</p></div>
            <div class="card"><h3>Jane Smith</h3><p>Graphic Designer | 4.9 ★</p></div>
            <div class="card"><h3>Mike Johnson</h3><p>Content Writer | 4.7 ★</p></div>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 Freelance Marketplace. All rights reserved.</p>
    </footer>
</body>
</html>
