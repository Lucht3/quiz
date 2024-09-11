<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Please login first!";
    exit;
}

$sql = "SELECT * FROM questions";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<form method="POST" action="result.php">';
    while ($row = $result->fetch_assoc()) {
        echo "<p>" . $row['question'] . "</p>";
        echo "<input type='radio' name='question_" . $row['id'] . "' value='1'>" . $row['option1'] . "<br>";
        echo "<input type='radio' name='question_" . $row['id'] . "' value='2'>" . $row['option2'] . "<br>";
        echo "<input type='radio' name='question_" . $row['id'] . "' value='3'>" . $row['option3'] . "<br>";
        echo "<input type='radio' name='question_" . $row['id'] . "' value='4'>" . $row['option4'] . "<br>";
    }
    echo '<button type="submit">Submit</button>';
    echo '</form>';

    // เพิ่มปุ่มจัดการบัญชีผู้ใช้
    echo '<br><a href="edit_account.php"><button>Edit Account</button></a>';
    echo '<a href="delete_account.php"><button>Delete Account</button></a>';
} else {
    echo "No questions found!";
}

$conn->close();
?>
