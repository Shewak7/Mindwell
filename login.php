
<?php
session_start();
require 'connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header('Location: home.php');
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindWell - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('img/bg1.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-blue-500 bg-opacity-75 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-8 space-y-8 bg-white bg-opacity-90 rounded-lg shadow-lg transform transition duration-500 hover:scale-105">
        <h2 class="text-3xl font-bold text-center text-blue-700">MindWell</h2>
        <?php if (isset($error)): ?>
            <p class="text-red-500 text-center"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form class="mt-6 space-y-6" action="login.php" method="POST">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-600" for="email">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 transition duration-500 ease-in-out transform hover:scale-105" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-600" for="password">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 transition duration-500 ease-in-out transform hover:scale-105" required>
            </div>
            <div class="flex items-center justify-between">
                <button class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50 transition duration-500 ease-in-out transform hover:scale-105">Login</button>
            </div>
            <div class="text-center mt-6">
                <a href="register.php" class="text-blue-600 hover:underline transition duration-500 ease-in-out transform hover:scale-105">Don't have an account? Register here</a>
            </div>
        </form>
    </div>
</body>
</html>
