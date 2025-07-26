<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'connection.php'; 

$user_id = $_SESSION['user_id'];
$error = '';

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindWell - Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
        .form-input {
            transition: all 0.3s ease;
        }
        .form-input:hover {
            transform: scale(1.05);
        }
        body {
            font-family: 'Roboto', sans-serif;
            background: url('img/bg12.jpg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="home.php">
                <img src="img/logo.png" alt="MindWell Logo" class="h-12">
            </a>
            <div>
                <a href="home.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">Home</a>
                <a href="chatbot.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">AI Chatbot</a>
                <a href="community.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">Community</a>
                <a href="profile.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">Profile</a>
                <a href="maps.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">Maps</a>
                <a href="logout.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">Logout</a>
            </div>
        </div>
    </nav>
    
    <header class="bg-cover bg-center text-center py-12 shadow-lg">
        <h1 class="text-4xl font-semibold text-black">Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
    </header>

    <main class="container mx-auto mt-8 p-4">
        <?php if (!empty($message)): ?>
            <div class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert">
                <p class="font-bold">Success</p>
                <p class="text-sm"><?php echo htmlspecialchars($message); ?></p>
            </div>
        <?php elseif (!empty($error)): ?>
            <div class="bg-red-100 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">
                <p class="font-bold">Error</p>
                <p class="text-sm"><?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>

        <div class="card p-6 mb-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Mental Health Profile</h2>
            <form action="profile.php" method="POST" class="space-y-4">
                <div>
                    <label for="stress_level" class="block text-sm font-medium text-gray-600">Stress Level (1-10)</label>
                    <input type="number" name="stress_level" id="stress_level" class="form-input w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" min="1" max="10" value="<?php echo htmlspecialchars($profile['stress_level'] ?? ''); ?>" required>
                </div>
                <div>
                    <label for="anxiety_level" class="block text-sm font-medium text-gray-600">Anxiety Level (1-10)</label>
                    <input type="number" name="anxiety_level" id="anxiety_level" class="form-input w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" min="1" max="10" value="<?php echo htmlspecialchars($profile['anxiety_level'] ?? ''); ?>" required>
                </div>
                <div>
                    <label for="sleep_quality" class="block text-sm font-medium text-gray-600">Sleep Quality (1-10)</label>
                    <input type="number" name="sleep_quality" id="sleep_quality" class="form-input w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" min="1" max="10" value="<?php echo htmlspecialchars($profile['sleep_quality'] ?? ''); ?>" required>
                </div>
                <div>
                    <label for="exercise_frequency" class="block text-sm font-medium text-gray-600">Exercise Frequency</label>
                    <input type="text" name="exercise_frequency" id="exercise_frequency" class="form-input w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" value="<?php echo htmlspecialchars($profile['exercise_frequency'] ?? ''); ?>" required>
                </div>
                <div>
                    <label for="diet_quality" class="block text-sm font-medium text-gray-600">Diet Quality</label>
                    <input type="text" name="diet_quality" id="diet_quality" class="form-input w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" value="<?php echo htmlspecialchars($profile['diet_quality'] ?? ''); ?>" required>
                </div>
                <div>
                    <label for="social_interaction_level" class="block text-sm font-medium text-gray-600">Social Interaction Level</label>
                    <input type="text" name="social_interaction_level" id="social_interaction_level" class="form-input w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" value="<?php echo htmlspecialchars($profile['social_interaction_level'] ?? ''); ?>" required>
                </div>
                <div>
                    <label for="mental_health_status" class="block text-sm font-medium text-gray-600">Mental Health Status</label>
                    <input type="text" name="mental_health_status" id="mental_health_status" class="form-input w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" value="<?php echo htmlspecialchars($profile['mental_health_status'] ?? ''); ?>" required>
                </div>
                <div>
                    <label for="mood_level" class="block text-sm font-medium text-gray-600">Mood Level (1-10)</label>
                    <input type="number" name="mood_level" id="mood_level" class="form-input w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" min="1" max="10" value="<?php echo htmlspecialchars($profile['mood_level'] ?? ''); ?>" required>
                </div>
                <div>
                    <label for="coping_strategies" class="block text-sm font-medium text-gray-600">Coping Strategies</label>
                    <textarea name="coping_strategies" id="coping_strategies" rows="4" class="form-input w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" required><?php echo htmlspecialchars($profile['coping_strategies'] ?? ''); ?></textarea>
                </div>
                <div>
                    <label for="professional_help" class="flex items-center">
                        <input type="checkbox" name="professional_help" id="professional_help" class="form-input mr-2" <?php echo ($profile['professional_help'] === 'true') ? 'checked' : ''; ?>>
                        <span class="text-sm font-medium text-gray-600">Seeking Professional Help</span>
                    </label>
                </div>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update Profile</button>
            </form>
        </div>
        <div class="text-center mt-8 flex justify-center space-x-4">
         <button id="generate-pdf" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Generate PDF</button>
         <a href="feedback.php" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Get Your Feedback</a>
        </div>

    </main>
    <script>
        document.getElementById('generate-pdf').addEventListener('click', async function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            
            
            const backgroundImageUrl = 'https://i.postimg.cc/PfyNfMVX/White-Black-Minimal-Notes-Sheet-Us-Letter-Document.jpg';
            
           
            const img = new Image();
            img.crossOrigin = "Anonymous";
            img.src = backgroundImageUrl;

            img.onload = function () {
                const imgWidth = doc.internal.pageSize.width;
                const imgHeight = (img.naturalHeight * imgWidth) / img.naturalWidth;
                
               
                doc.addImage(img, 'JPG', 0, 0, imgWidth, imgHeight);
                
             
                const userName = '<?php echo addslashes($user_name); ?>';
                const profileData = <?php echo json_encode($profile); ?>;

                const startVertical = 60; 
                const pageWidth = doc.internal.pageSize.width;
        
                const leftMargin = 30;
                
                
                
                doc.setFontSize(17);
                doc.text('Name: ' + userName, leftMargin, startVertical + 10, { align: 'left' });
                doc.text('Date: ' + new Date().toLocaleDateString(), leftMargin, startVertical + 19, { align: 'left' });
                
                let y = startVertical + 30;
                for (const [key, value] of Object.entries(profileData)) {
                    if (value !== null && value !== '') {
                        doc.text(`${capitalizeFirstLetter(key.replace(/_/g, ' '))}: ${value}`, leftMargin, y, { align: 'left' });
                        y += 13;
                    }
                }

                doc.save('MentalHealth-report.pdf');
            };

            img.onerror = function () {
                console.error('Failed to load image.');
            };
        });

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    </script>
</body>
</html>
