<?php
require 'db.php';
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            $success = true;
        } else {
            echo "<div class='error-message'>Error: " . $stmt->error . "</div>";
        }
    }
}
?>

<link rel="stylesheet" href="style.css">

<div class="auth-container">
    <?php if ($success): ?>
        <div class="success-message">
            Registered successfully. <a href="login.php">Login</a>
        </div>
    <?php endif; ?>

    <h2 class="center-text">Register</h2>

    <form method="POST">
        <input name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>

    <p class="center-text">Already registered? <a href="login.php">Login here</a></p>
</div>
