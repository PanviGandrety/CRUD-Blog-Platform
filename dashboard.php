<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title'], $_POST['content'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $content);
    $stmt->execute();
}

$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
?>

<link rel="stylesheet" href="style.css">
<div class="container">
    <a href="logout.php" class="logout-btn">Logout</a>
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Post title" required>
        <textarea name="content" placeholder="Your content..." required></textarea>
        <button type="submit">Post</button>
    </form>

    <h3>Recent Posts</h3>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="post">
        <h4><?php echo htmlspecialchars($row['title']); ?></h4>
        <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
        <small><?php echo $row['created_at']; ?></small>
        <form method="POST" action="delete.php" style="margin-top:10px;">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <button type="submit" class="delete-btn">Delete</button>
        </form>
    </div>
    <?php endwhile; ?>
</div>
