<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

require 'connection.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = $_POST['comment'];

    if (!empty($comment)) {
        $stmt = $pdo->prepare("INSERT INTO community (user_id, user_name, comment) VALUES (:user_id, :user_name, :comment)");
        $stmt->execute([
            ':user_id' => $user_id,
            ':user_name' => $user_name,
            ':comment' => htmlspecialchars($comment),
        ]);
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_id']) && isset($_POST['edit_comment'])) {
    $comment_id = $_POST['comment_id'];
    $comment = $_POST['edit_comment'];

    if (!empty($comment)) {
        $stmt = $pdo->prepare("UPDATE community SET comment = :comment WHERE id = :comment_id AND user_id = :user_id");
        $stmt->execute([
            ':comment' => htmlspecialchars($comment),
            ':comment_id' => $comment_id,
            ':user_id' => $user_id,
        ]);
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment_id'])) {
    $comment_id = $_POST['delete_comment_id'];

  
    $stmt = $pdo->prepare("DELETE FROM likes WHERE comment_id = :comment_id");
    $stmt->execute([':comment_id' => $comment_id]);

  
    $stmt = $pdo->prepare("DELETE FROM community WHERE id = :comment_id AND user_id = :user_id");
    $stmt->execute([
        ':comment_id' => $comment_id,
        ':user_id' => $user_id,
    ]);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['like_comment_id'])) {
    $comment_id = $_POST['like_comment_id'];

   
    $stmt = $pdo->prepare("SELECT * FROM likes WHERE comment_id = :comment_id AND user_id = :user_id");
    $stmt->execute([
        ':comment_id' => $comment_id,
        ':user_id' => $user_id,
    ]);
    $like = $stmt->fetch();

    if (!$like) {
        $stmt = $pdo->prepare("INSERT INTO likes (comment_id, user_id) VALUES (:comment_id, :user_id)");
        $stmt->execute([
            ':comment_id' => $comment_id,
            ':user_id' => $user_id,
        ]);
    } else {
  
        $stmt = $pdo->prepare("DELETE FROM likes WHERE comment_id = :comment_id AND user_id = :user_id");
        $stmt->execute([
            ':comment_id' => $comment_id,
            ':user_id' => $user_id,
        ]);
    }
}


$stmt = $pdo->prepare("SELECT id, user_name, comment, user_id FROM community ORDER BY created_at DESC");
$stmt->execute();
$comments = $stmt->fetchAll();

$like_stmt = $pdo->prepare("SELECT comment_id, COUNT(*) AS like_count FROM likes GROUP BY comment_id");
$like_stmt->execute();
$likes = $like_stmt->fetchAll(PDO::FETCH_KEY_PAIR);


$user_like_stmt = $pdo->prepare("SELECT comment_id FROM likes WHERE user_id = :user_id");
$user_like_stmt->execute([':user_id' => $user_id]);
$user_likes = $user_like_stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindWell - Community</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: url('img/bg12.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        .slide-in {
            animation: slideIn 0.5s ease-in-out;
        }
        @keyframes slideIn {
            0% { transform: translateY(20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        .liked {
            background-color: seagreen;
            color: white;
        }
        .unliked {
            background-color: seagreen;
            color: white;
        }
        h1, h2, p {
            color: #333; 
        }
        .bg-overlay {
            background-color: rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body>
    <nav class="bg-blue-600 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php" class="text-white text-xl font-bold">MindWell</a>
            <div>
                <a href="chatbot.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">AI Chatbot</a>
                <a href="community.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">Community</a>
                <a href="profile.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">Profile</a>
                <a href="maps.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">Maps</a>
                <a href="login.php" class="text-white px-4 hover:bg-blue-700 rounded py-2">Logout</a>
            </div>
        </div>
    </nav>
    
    <header class="bg-white text-center py-12 shadow-lg">
        <h1 class="text-4xl font-semibold text-blue-600">Welcome to the Community, <?php echo htmlspecialchars($user_name); ?>!</h1>
    </header>

    <main class="container mx-auto mt-8 p-4">
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 fade-in">Community Comments</h2>
            <div class="space-y-4">
                <?php foreach ($comments as $comment): ?>
                    <div class="card p-6 slide-in">
                        <h3 class="text-lg font-bold text-gray-800"><?php echo htmlspecialchars($comment['user_name']); ?></h3>
                        <p class="text-gray-700 mt-2"><?php echo htmlspecialchars($comment['comment']); ?></p>
                        <?php if ($comment['user_id'] == $user_id): ?>
                            <form method="POST" class="mt-4">
                                <textarea name="edit_comment" rows="2" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600"><?php echo htmlspecialchars($comment['comment']); ?></textarea>
                                <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mt-2">Edit Comment</button>
                            </form>
                            <form method="POST" class="mt-2">
                                <input type="hidden" name="delete_comment_id" value="<?php echo $comment['id']; ?>">
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete Comment</button>
                            </form>
                        <?php endif; ?>
                        <div class="mt-4 flex items-center space-x-4">
                            <form method="POST" class="flex items-center">
                                <input type="hidden" name="like_comment_id" value="<?php echo $comment['id']; ?>">
                                <button type="submit" class="px-4 py-2 rounded <?php echo in_array($comment['id'], $user_likes) ? 'liked' : 'unliked'; ?>">
                                    <?php echo in_array($comment['id'], $user_likes) ? 'Unlike' : 'Like'; ?>
                                </button>
                            </form>
                            <span><?php echo isset($likes[$comment['id']]) ? $likes[$comment['id']] : 0; ?> Likes</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="mt-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Add a Comment</h2>
            <form method="POST" class="space-y-4">
                <textarea name="comment" rows="3" class="w-full p-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Share your thoughts..."></textarea>
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">Post Comment</button>
            </form>
        </section>
    </main>
</body>
</html>
