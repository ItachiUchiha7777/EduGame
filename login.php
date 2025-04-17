<?php
session_start();
$conn = new mysqli("localhost", "root", "", "eduplay");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name, $hashed_pass);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($pass, $hashed_pass)) {
        $_SESSION["user_id"] = $id;
        $_SESSION["name"] = $name;
        $_SESSION["logged_in"] = true;
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid login!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login - EduPlay</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
  <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
    <div class="text-center mb-8">
      <i class="fas fa-user-circle text-6xl text-blue-500 mb-4"></i>
      <h2 class="text-3xl font-bold text-gray-800">Welcome Back</h2>
      <p class="text-gray-600">Login to continue your learning journey</p>
    </div>
    
    <?php if (!empty($error)): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?= $error ?>
      </div>
    <?php endif; ?>
    
    <form method="POST">
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">Email</label>
        <input name="email" type="email" required 
               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 mb-2">Password</label>
        <input name="password" type="password" required 
               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>
      <button type="submit" 
              class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
        Login
      </button>
    </form>
    
    <div class="mt-6 text-center">
      <p class="text-gray-600">Don't have an account? 
        <a href="signup.php" class="text-blue-600 hover:underline">Sign up</a>
      </p>
    </div>
  </div>
</body>
</html>