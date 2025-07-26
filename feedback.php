<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'connection.php'; 

$user_id = $_SESSION['user_id'];
$error = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stress_level = $_POST['stress_level'];
    $anxiety_level = $_POST['anxiety_level'];
    $sleep_quality = $_POST['sleep_quality'];
    $exercise_frequency = $_POST['exercise_frequency'];
    $diet_quality = $_POST['diet_quality'];
    $social_interaction_level = $_POST['social_interaction_level'];
    $mental_health_status = $_POST['mental_health_status'];
    $mood_level = $_POST['mood_level'];
    $coping_strategies = $_POST['coping_strategies'];
    $professional_help = isset($_POST['professional_help']) ? 'true' : 'false';

    $query = "SELECT * FROM profile WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($profile) {
        $query = "UPDATE profile SET 
                    stress_level = :stress_level, 
                    anxiety_level = :anxiety_level, 
                    sleep_quality = :sleep_quality, 
                    exercise_frequency = :exercise_frequency, 
                    diet_quality = :diet_quality, 
                    social_interaction_level = :social_interaction_level, 
                    mental_health_status = :mental_health_status, 
                    mood_level = :mood_level, 
                    coping_strategies = :coping_strategies, 
                    professional_help = :professional_help, 
                    updated_at = NOW()
                  WHERE user_id = :user_id";
        $stmt = $pdo->prepare($query);
    } else {
        $query = "INSERT INTO profile (user_id, stress_level, anxiety_level, sleep_quality, exercise_frequency, diet_quality, social_interaction_level, mental_health_status, mood_level, coping_strategies, professional_help) 
                  VALUES (:user_id, :stress_level, :anxiety_level, :sleep_quality, :exercise_frequency, :diet_quality, :social_interaction_level, :mental_health_status, :mood_level, :coping_strategies, :professional_help)";
        $stmt = $pdo->prepare($query);
    }

    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':stress_level', $stress_level, PDO::PARAM_INT);
    $stmt->bindParam(':anxiety_level', $anxiety_level, PDO::PARAM_INT);
    $stmt->bindParam(':sleep_quality', $sleep_quality, PDO::PARAM_INT);
    $stmt->bindParam(':exercise_frequency', $exercise_frequency, PDO::PARAM_STR);
    $stmt->bindParam(':diet_quality', $diet_quality, PDO::PARAM_STR);
    $stmt->bindParam(':social_interaction_level', $social_interaction_level, PDO::PARAM_STR);
    $stmt->bindParam(':mental_health_status', $mental_health_status, PDO::PARAM_STR);
    $stmt->bindParam(':mood_level', $mood_level, PDO::PARAM_INT);
    $stmt->bindParam(':coping_strategies', $coping_strategies, PDO::PARAM_STR);
    $stmt->bindParam(':professional_help', $professional_help, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $message = "Profile updated successfully.";
    } else {
        $error = "Failed to update profile.";
    }
}

$query = "SELECT * FROM profile WHERE user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

$user_name = $_SESSION['user_name'];

function generateFeedback($profile) {
    $feedback = [];

    if ($profile['stress_level'] <= 3) {
        $feedback['stress_level'] = "Your stress level seems manageable. Keep practicing stress-relieving activities like meditation or hobbies.";
    } elseif ($profile['stress_level'] <= 6) {
        $feedback['stress_level'] = "You're experiencing moderate stress. Consider adding more relaxation activities to your routine.";
    } else {
        $feedback['stress_level'] = "Your stress level is high. It may be beneficial to seek professional support or engage in stress-reducing exercises.";
    }

    if ($profile['anxiety_level'] <= 3) {
        $feedback['anxiety_level'] = "Your anxiety level is low. Keep up with what you are doing, and maintain this balance.";
    } elseif ($profile['anxiety_level'] <= 6) {
        $feedback['anxiety_level'] = "You seem to have moderate anxiety. Practices like mindfulness can help in managing it.";
    } else {
        $feedback['anxiety_level'] = "Your anxiety level is high. It may be helpful to talk to a professional for better strategies.";
    }

    if ($profile['sleep_quality'] >= 7) {
        $feedback['sleep_quality'] = "You're getting good quality sleep. Keep maintaining a healthy sleep schedule.";
    } else {
        $feedback['sleep_quality'] = "Your sleep quality could be improved. Try establishing a regular bedtime routine and reducing screen time before sleep.";
    }

    if ($profile['exercise_frequency'] == 'Daily') {
        $feedback['exercise_frequency'] = "You're exercising daily, which is excellent for both mental and physical health.";
    } elseif ($profile['exercise_frequency'] == 'A few times a week') {
        $feedback['exercise_frequency'] = "You're exercising a few times a week. Try to aim for more consistency for better mental health benefits.";
    } else {
        $feedback['exercise_frequency'] = "You might benefit from more frequent exercise. Try incorporating light activities like walking into your routine.";
    }

    if ($profile['diet_quality'] == 'Healthy') {
        $feedback['diet_quality'] = "You're maintaining a healthy diet, which is great for your overall well-being.";
    } else {
        $feedback['diet_quality'] = "Improving your diet by including more balanced and nutritious meals could positively impact your mental health.";

    }

    if ($profile['social_interaction_level'] == 'High') {
        $feedback['social_interaction_level'] = "You're socially active, which helps in maintaining mental health.";
    } elseif ($profile['social_interaction_level'] == 'Moderate') {
        $feedback['social_interaction_level'] = "You have a moderate level of social interaction. Consider engaging more in social activities to boost your mood.";
    } else {
        $feedback['social_interaction_level'] = "Low social interaction may affect your mental well-being. Try to connect with others, even if it's in small ways.";
    }

    if ($profile['mood_level'] >= 7) {
        $feedback['mood_level'] = "Your mood seems generally positive. Keep up the activities that contribute to your well-being.";
    } elseif ($profile['mood_level'] >= 4) {
        $feedback['mood_level'] = "Your mood fluctuates, which is normal. Reflect on activities that elevate your mood and try to focus on them.";
    } else {
        $feedback['mood_level'] = "It seems you're feeling down often. Consider talking to someone or engaging in activities that help lift your mood.";
    }

    return $feedback;
}

$feedback = generateFeedback($profile);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindWell - Profile Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="home.php">
                <img src="img/logo.png" alt="MindWell Logo" class="h-12">
            </a>
            <div>
                <a href="home.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">Home</a>
                <a href="profile.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">Profile</a>
                <a href="logout.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">Logout</a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-8">
        <div class="bg-white p-8 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Hello, <?php echo htmlspecialchars($user_name); ?></h2>
            <h3 class="text-xl font-semibold mb-6">Your Mental Health Feedback</h3>

            <?php if ($message): ?>
                <div class="bg-green-100 text-green-800 p-4 rounded mb-4"><?php echo $message; ?></div>
            <?php elseif ($error): ?>
                <div class="bg-red-100 text-red-800 p-4 rounded mb-4"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <strong>Stress Level:</strong>
                    <p><?php echo $feedback['stress_level']; ?></p>
                </div>
                <div>
                    <strong>Anxiety Level:</strong>
                    <p><?php echo $feedback['anxiety_level']; ?></p>
                </div>
                <div>
                    <strong>Sleep Quality:</strong>
                    <p><?php echo $feedback['sleep_quality']; ?></p>
                </div>
                <div>
                    <strong>Exercise Frequency:</strong>
                    <p><?php echo $feedback['exercise_frequency']; ?></p>
                </div>
                <div>
                    <strong>Diet Quality:</strong>
                    <p><?php echo $feedback['diet_quality']; ?></p>
                </div>
                <div>
                    <strong>Social Interaction Level:</strong>
                    <p><?php echo $feedback['social_interaction_level']; ?></p>
                </div>
                <div>
                    <strong>Mood Level:</strong>
                    <p><?php echo $feedback['mood_level']; ?></p>
                </div>
            </div>

            <?php if ($profile['professional_help'] == 'true'): ?>
                <div class="mt-6">
                    <p class="text-lg text-blue-700 font-semibold">Based on your responses, seeking professional support might be beneficial. We recommend checking our mental health centers.</p>
                    <a href="maps.php" class="mt-4 inline-block bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition-all">Go to Maps</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
