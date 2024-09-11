<?php
session_start();
include 'db.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าผู้ใช้ล็อกอินอยู่หรือไม่
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// ตรวจสอบการส่งข้อมูลจากฟอร์ม
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_username = $_SESSION['user_id'];
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];

    // การป้องกันการเปลี่ยนชื่อผู้ใช้เป็นชื่อที่มีอยู่แล้ว
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->bind_param("s", $new_username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    if ($count > 0 && $new_username !== $current_username) {
        echo "Username already exists. Please choose a different username.";
    } else {
        // อัปเดตข้อมูลในฐานข้อมูล
        $sql = "UPDATE users SET username = ?, password = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $new_username, $new_password, $current_username);
        
        if ($stmt->execute()) {
            // อัปเดตข้อมูลในเซสชัน
            $_SESSION['user_id'] = $new_username;
            header('Location: quiz.php'); // เปลี่ยนเส้นทางไปยังหน้า quiz.php
            exit();
        } else {
            echo "Error updating account: " . $stmt->error;
        }
        
        $stmt->close();
    }
} else {
    echo "Invalid request.";
}
?>
