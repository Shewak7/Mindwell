<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindWell - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .dropdown {
            display: none;
        }
        .dropdown.active {
            display: block;
        }
        .transition {
            transition: all 0.3s ease;
        }
        .card {
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
        }
        .faq-header {
            cursor: pointer;
        }
        .faq-content {
            display: none;
            padding: 1rem;
            background-color: #f7fafc;
            border-left: 4px solid #3b82f6;
            border-radius: 8px;
        }
        .faq-content.active {
            display: block;
        }
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            100% {
                background-position: 100% 50%;
            }
        }
        body {
            font-family: 'Roboto', sans-serif;
            background: url('img/bg12.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }
        .logo {
            filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.7));
        }
        .chatbot-container {
            background-color: #ffffff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            height: 400px;
            margin: 0 auto;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .chatbot-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        iframe {
            width: 100%;
            height: 100%;
        }
        .example-questions {
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #3b82f6;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .example-questions:hover {
            background-color: #2563eb;
        }
        .example-questions-dropdown {
            display: none;
            margin-top: 20px;
            background-color: #f1f5f9;
            padding: 12px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        .example-questions-dropdown.active {
            display: block;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const faqHeaders = document.querySelectorAll('.faq-header');
            faqHeaders.forEach(header => {
                header.addEventListener('click', () => {
                    const dropdown = header.nextElementSibling;
                    dropdown.classList.toggle('active');
                    header.classList.toggle('font-bold');
                    dropdown.classList.toggle('transition');
                });
            });

            const exampleQuestionsButton = document.querySelector('.example-questions');
            const exampleQuestionsDropdown = document.querySelector('.example-questions-dropdown');
            
            exampleQuestionsButton.addEventListener('click', () => {
                exampleQuestionsDropdown.classList.toggle('active');
                exampleQuestionsButton.classList.toggle('bg-blue-700');
            });
        });
    </script>
</head>
<body class="bg-gray-50">
    <nav class="bg-gradient-to-r from-blue-600 to-teal-500 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="home.php">
                <img src="img/logo.png" alt="MindWell Logo" class="h-12 logo">
            </a>
            <div>
                <a href="chatbot.php" class="text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">AI Chatbot</a>
                <a href="community.php" class="text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Community</a>
                <a href="profile.php" class="text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Profile</a>
                <a href="maps.php" class="text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Maps</a>
                <a href="login.php" class="text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Logout</a>
            </div>
        </div>
    </nav>
    
    <main class="container mx-auto mt-12 p-6 text-center">
        <h1 class="text-5xl font-extrabold">Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
        <p class="text-2xl text-gray-800 mt-4">We’re here to support your mental health. Start a conversation with our AI Chatbot below.</p>

        <button class="example-questions mt-8">Need Help? Click Here for Example Questions!</button>
        
        
        <div class="example-questions-dropdown">
            <ul class="list-disc list-inside text-left text-lg text-gray-700">
                <li>What are some ways to reduce anxiety?</li>
                <li>Can you help me with stress management?</li>
                <li>How can I improve my sleep?</li>
                <li>What are the signs of burnout?</li>
                <li>How do I maintain good mental health?</li>
            </ul>
        </div>

      
        <section class="mt-16 mb-16">
            <h2 class="text-4xl font-bold text-gray-800 mb-8">MindWell AI Chatbot</h2>
            <div class="chatbot-container">
                <iframe allow="microphone;" src="https://console.dialogflow.com/api-client/demo/embedded/36ed0781-864d-4350-bace-7ba64886c6ef"></iframe>
            </div>
        </section>

     
    </main>

    <footer class="bg-gray-900 text-white text-center py-6 mt-12">
        <p>&copy; 2024 MindWell. All rights reserved.</p>
    </footer>
</body>
</html>
