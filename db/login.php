<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ตรวจสอบผู้ใช้งานในฐานข้อมูล
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['user_id'] = $username;
        header("Location: quiz.php");
        exit();
    } else {
        echo "Invalid username or password!";
    }
}
?>

<form method="POST" action="login.php">
    <h2>Login</h2>
    <label>Username:</label>
    <input type="text" name="username" required><br>
    <label>Password:</label>
    <input type="password" name="password" required><br>
    <button type="submit" name="login">Login</button>
</form>

<a href="register.php">Register</a>
