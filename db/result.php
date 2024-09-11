<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// เก็บคะแนน
$score = 0;

$sql = "SELECT * FROM questions LIMIT 5";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $question_id = "question_" . $row['id'];
        if (isset($_POST[$question_id]) && $_POST[$question_id] == $row['correct_answer']) {
            $score++;
        }
    }
}

echo "<h2>Your score: $score/5</h2>";
echo '<a href="quiz.php">Retake Quiz</a>';

$conn->close();
?>
