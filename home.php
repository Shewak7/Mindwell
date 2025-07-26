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
            border-radius: 8px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .faq-header {
            cursor: pointer;
        }
        .faq-content {
            display: none;
            padding-left: 1rem;
            padding-right: 1rem;
            padding-bottom: 0.5rem;
            background-color: #f7fafc;
            border-left: 4px solid #3b82f6;
        }
        .faq-content.active {
            display: block;
        }
        .welcome-text {
            color: #333333; 
        }
        body {
            font-family: 'Roboto', sans-serif;
            background: url('img/bg12.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .logo {
            filter: drop-shadow(0 0 5px rgba(0, 0, 0, 0.5));
        }
        .text-darker {
            color: #333333; 
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
        });
    </script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="home.php">
                <img src="img/logo.png" alt="MindWell Logo" class="h-12 logo">
            </a>
            <div>
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
        <h1 class="text-4xl font-semibold welcome-text animate-bounce">Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
    </header>

    <main class="container mx-auto mt-8 p-4">
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-darker mb-6">Mental Health Benefits</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="card p-6">
                    <p class="text-darker mb-4">Maintaining good mental health is essential for leading a balanced and fulfilling life. It improves your overall well-being, helps you manage stress, and enhances your quality of life.</p>
                    <p class="text-darker">Regular mental health care can lead to better relationships, increased productivity, and a greater sense of purpose. Good mental health enables you to better cope with daily challenges and promotes a more positive outlook.</p>
                </div>
                <div class="card p-6">
                    <h3 class="text-2xl font-bold text-darker mb-4">Emotional Well-being</h3>
                    <p class="text-darker">Emotional well-being is a key component of overall mental health. It involves managing your emotions in a healthy way, developing resilience, and having the ability to cope with stress effectively.</p>
                    <p class="text-darker">Focusing on emotional well-being can enhance your relationships, improve your mood, and increase your ability to handle life’s ups and downs with a positive mindset.</p>
                </div>
            </div>
        </section>
        
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-darker mb-6">Tips for Maintaining Mental Health</h2>
            <ul class="list-disc pl-5 text-darker space-y-2">
                <li>Practice mindfulness and meditation regularly to reduce stress.</li>
                <li>Engage in physical activity and maintain a healthy diet.</li>
                <li>Stay connected with friends and family for support.</li>
                <li>Set realistic goals and break tasks into manageable steps.</li>
                <li>Seek professional help when needed and talk openly about your feelings.</li>
                <li>Prioritize self-care and make time for activities you enjoy.</li>
                <li>Limit exposure to negative news and social media.</li>
                <li>Establish a regular sleep routine and practice relaxation techniques.</li>
            </ul>
        </section>
        
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-darker mb-6">Mental Health Myths</h2>
            <div class="space-y-4">
                <div>
                    <div class="bg-white p-4 rounded shadow cursor-pointer faq-header">
                        <h3 class="text-lg font-medium text-darker">Myth: Mental health issues are rare.</h3>
                    </div>
                    <div class="faq-content">
                        <p class="text-darker">Fact: Mental health issues are quite common. Many people experience mental health challenges at some point in their lives. It is important to seek help and support, regardless of how common or uncommon it may seem.</p>
                    </div>
                </div>
                <div>
                    <div class="bg-white p-4 rounded shadow cursor-pointer faq-header">
                        <h3 class="text-lg font-medium text-darker">Myth: Therapy is only for people with serious mental health problems.</h3>
                    </div>
                    <div class="faq-content">
                        <p class="text-darker">Fact: Therapy can benefit anyone, not just those with serious mental health issues. It can help with everyday stress, personal growth, and improving overall well-being.</p>
                    </div>
                </div>
                <div>
                    <div class="bg-white p-4 rounded shadow cursor-pointer faq-header">
                        <h3 class="text-lg font-medium text-darker">Myth: You should be able to 'snap out of it' without help.</h3>
                    </div>
                    <div class="faq-content">
                        <p class="text-darker">Fact: Mental health issues are not something you can simply 'snap out of.' Professional help and support are often necessary to manage and overcome mental health challenges effectively.</p>
                    </div>
                </div>
                <div>
                    <div class="bg-white p-4 rounded shadow cursor-pointer faq-header">
                        <h3 class="text-lg font-medium text-darker">Myth: Mental health problems are a sign of weakness.</h3>
                    </div>
                    <div class="faq-content">
                        <p class="text-darker">Fact: Seeking help for mental health issues is a sign of strength, not weakness. It takes courage to acknowledge and address mental health challenges, and doing so can lead to significant personal growth and improved well-being.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-12">
            <h2 class="text-3xl font-bold text-darker mb-6">Self-Care Strategies</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="card p-6">
                    <h3 class="text-2xl font-bold text-darker mb-4">Exercise Regularly</h3>
                    <p class="text-darker">Engaging in physical activity is one of the best ways to boost your mood and reduce stress. Aim for at least 30 minutes of exercise most days of the week.</p>
                </div>
                <div class="card p-6">
                    <h3 class="text-2xl font-bold text-darker mb-4">Practice Mindfulness</h3>
                    <p class="text-darker">Mindfulness involves being present in the moment and paying attention to your thoughts and feelings without judgment. It can help you manage stress and improve your overall mental health.</p>
                </div>
                <div class="card p-6">
                    <h3 class="text-2xl font-bold text-darker mb-4">Get Enough Sleep</h3>
                    <p class="text-darker">Quality sleep is crucial for mental health. Try to establish a regular sleep routine and ensure you get 7-9 hours of sleep each night.</p>
                </div>
                <div class="card p-6">
                    <h3 class="text-2xl font-bold text-darker mb-4">Connect with Others</h3>
                    <p class="text-darker">Building and maintaining strong relationships can provide emotional support and help you feel more connected. Make time to nurture these connections regularly.</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white p-4 text-center mt-12">
        <p class="text-sm">© 2024 MindWell. All Rights Reserved.</p>
    </footer>
</body>
</html>
