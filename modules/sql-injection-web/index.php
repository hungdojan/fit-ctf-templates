<?php
$db_host = getenv('MYSQL_HOST') ?: 'db';
$db_user = getenv('MYSQL_USER') ?: 'ctf';
$db_pass = getenv('MYSQL_PASSWORD') ?: 'ctfpass';
$db_name = getenv('MYSQL_DATABASE') ?: 'ctfdb';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
$logged_in = false;
$user_data = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // vulnerable
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        $logged_in = true;
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CTF Login</title>
</head>
<body>
    <h1>Login</h1>

    <?php if (!$logged_in): ?>
        <form method="POST">
            <div>
                <label>Username:</label>
                <input type="text" name="username" required>
            </div>
            <div>
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <?php if ($error): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    <?php else: ?>
        <h2>Welcome, <?php echo htmlspecialchars($user_data['username']); ?>!</h2>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($user_data['description']); ?></p>
    <?php endif; ?>
</body>
</html>

