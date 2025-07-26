<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_name = $_SESSION['user_name'];
require_once 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindWell - About Us</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .card {
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .welcome-text {
            color: black;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background: url('img/bg12.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .logo {
            filter: drop-shadow(0 0 5px rgba(0, 0, 0, 0.5));
        }
    </style>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="home.php">
                <img src="img/logo.png" alt="MindWell Logo" class="h-12 logo">
            </a>
            <div>
                <a href="home.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">Home</a>
                <a href="chatbot.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">AI Chatbot</a>
                <a href="community.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">Community</a>
                <a href="profile.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">Profile</a>
                <a href="maps.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">Maps</a>
                <a href="about.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">About Us</a>
                <a href="login.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">Logout</a>
            </div>
        </div>
    </nav>
    
    <header class="bg-cover bg-center text-center py-12 shadow-lg">
        <h1 class="text-4xl font-semibold welcome-text">About MindWell</h1>
    </header>

    <main class="container mx-auto mt-8 p-4">
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-white mb-6">Our Mission</h2>
            <div class="card p-6">
                <p class="text-gray-700">At MindWell, our mission is to empower individuals to take control of their mental health by providing accessible tools and resources. We believe that mental health is just as important as physical health, and our goal is to make mental health care more accessible and less stigmatized.</p>
            </div>
        </section>
        
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-white mb-6">Our Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="card p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Home</h3>
                    <p class="text-gray-700">Your gateway to all the mental health resources and tools offered by MindWell.</p>
                </div>
                <div class="card p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Maps to Nearest Center</h3>
                    <p class="text-gray-700">Locate the nearest mental health center with ease using our interactive map.</p>
                </div>
                <div class="card p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Profile Page & Report Generation</h3>
                    <p class="text-gray-700">Track your mental health journey with personalized reports and updates.</p>
                </div>
                <div class="card p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Community Page</h3>
                    <p class="text-gray-700">Connect with others, share your experiences, and find support in our community.</p>
                </div>
                <div class="card p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">AI Chatbot</h3>
                    <p class="text-gray-700">Get instant mental health support and information through our AI-powered chatbot.</p>
                </div>
                <div class="card p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Test Page</h3>
                    <p class="text-gray-700">Analyze your mental health through our comprehensive test, designed to provide insights and recommendations.</p>
                </div>
            </div>
        </section>
        
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-white mb-6">Meet the Team</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card p-6 text-center">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Sanakkian</h3>
                    <p class="text-gray-700">20222115113</p>
                </div>
                <div class="card p-6 text-center">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Shewak</h3>
                    <p class="text-gray-700">2022115087</p>
                </div>
                <div class="card p-6 text-center">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Sugadharshanan</h3>
                    <p class="text-gray-700">2022115002</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white text-center py-4 mt-8">
        <p>&copy; 2024 MindWell. All rights reserved.</p>
    </footer>
</body>
</html>
