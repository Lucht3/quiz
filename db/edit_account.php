<?php
session_start();
include 'db.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าผู้ใช้ล็อกอินอยู่หรือไม่
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// ดึงข้อมูลปัจจุบันของผู้ใช้
$sql = "SELECT username FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($current_username);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
</head>
<body>
    <h1>Edit Account</h1>
    <form action="edit_account_process.php" method="post">
        <label>Current Username:</label>
        <input type="text" name="current_username" value="<?php echo htmlspecialchars($current_username); ?>" disabled><br>
        
        <label>New Username:</label>
        <input type="text" name="new_username" required><br>
        
        <label>New Password:</label>
        <input type="password" name="new_password" required><br>
        
        <input type="submit" value="Update">
    </form>
    
    <a href="index.php">Cancel</a>
</body>
</html>
