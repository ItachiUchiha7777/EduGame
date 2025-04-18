<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$subject = $_POST['subject'];
$score = 0;

for ($i = 0; isset($_POST["q$i"]); $i++) {
  if ($_POST["q$i"] === $_POST["ans$i"]) {
    $score++;
  }
}

$conn = new mysqli('localhost', 'root', '', 'eduplay');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$stmt = $conn->prepare("INSERT INTO scores (user_id, subject, score, total, attempted_on) VALUES (?, ?, ?, ?, NOW())");
$total = $i;
$stmt->bind_param("isii", $user_id, $subject, $score, $total);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: results.php");
exit();
r