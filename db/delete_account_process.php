<?php
session_start();
include 'db.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าผู้ใช้ล็อกอินอยู่หรือไม่
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// ตรวจสอบการส่งข้อมูลจากฟอร์ม
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    $username = $_POST['username'];

    // ตรวจสอบว่าผู้ใช้ที่ส่งคำขอเป็นผู้ใช้ที่ล็อกอินอยู่หรือไม่
    if ($username === $_SESSION['user_id']) {
        // ลบข้อมูลผู้ใช้
        $sql = "DELETE FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            // ออกจากระบบและเปลี่ยนเส้นทางไปที่หน้า login
            session_destroy();
            header('Location: login.php'); // เปลี่ยนเส้นทางไปยังหน้า login
            exit();
        } else {
            echo "Error deleting account: " . $stmt->error;
        }
    } else {
        echo "Invalid request.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
?>
