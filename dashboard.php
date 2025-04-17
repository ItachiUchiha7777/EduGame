<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-gray-100">
  <h1 class="text-2xl font-bold mb-4">Welcome, <?php echo $_SESSION["name"]; ?>!</h1>
  <a href="games.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">Start Playing Games</a>
  <a href="logout.php" class="ml-4 text-red-500 hover:underline">Logout</a>
</body>
</html>
