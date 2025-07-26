<?php
session_start();
require 'connection.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $mobile = htmlspecialchars($_POST['mobile']);

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    if ($stmt->rowCount() > 0) {
        $error = "Email already exists.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, mobile) VALUES (:name, :email, :password, :mobile)");
        if ($stmt->execute([':name' => $name, ':email' => $email, ':password' => $password, ':mobile' => $mobile])) {
            header('Location: login.php');
            exit;
        } else {
            $error = "Failed to register. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindWell - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('img/bg3.jpeg'); /* Ensure this path is correct */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-opacity-75">
    <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-lg shadow-lg transform transition duration-500 hover:scale-105 bg-opacity-90">
        <h2 class="text-3xl font-bold text-center text-blue-700">MindWell - Register</h2>
        <?php if ($error): ?>
            <p class="text-red-500 text-center"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form class="mt-6 space-y-6" action="register.php" method="POST">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-600" for="name">Name</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 transition duration-500 ease-in-out transform hover:scale-105" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-600" for="email">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 transition duration-500 ease-in-out transform hover:scale-105" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-600" for="password">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 transition duration-500 ease-in-out transform hover:scale-105" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-600" for="mobile">Mobile Number</label>
                <input type="text" name="mobile" id="mobile" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 transition duration-500 ease-in-out transform hover:scale-105" required>
            </div>
            <div class="flex items-center justify-between">
                <button class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50 transition duration-500 ease-in-out transform hover:scale-105">Register</button>
            </div>
            <div class="text-center mt-6">
                <a href="login.php" class="text-blue-600 hover:underline transition duration-500 ease-in-out transform hover:scale-105">Already have an account? Login here</a>
            </div>
        </form>
    </div>
</body>
</html>
