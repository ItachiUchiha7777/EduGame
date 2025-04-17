<?php
session_start();
$logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EduPlay - Learn with Fun</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-purple-100 text-gray-800 font-sans">

  <!-- Navbar -->
  <nav class="bg-blue-700 p-5 text-white flex justify-between items-center shadow-md">
    <h1 class="text-3xl font-extrabold cursor-pointer tracking-wide">EduPlay</h1>
    <div class="space-x-6 flex items-center">
      <?php if ($logged_in): ?>
        <span class="text-blue-100">Welcome, <?= htmlspecialchars($_SESSION['name']) ?></span>
        <a href="results.php" class="hover:underline cursor-pointer text-lg flex items-center">
          <i class="fas fa-chart-line mr-1"></i> Results
        </a>
        <a href="logout.php" class="hover:underline cursor-pointer text-lg flex items-center">
          <i class="fas fa-sign-out-alt mr-1"></i> Logout
        </a>
      <?php else: ?>
        <a href="login.php" class="hover:underline cursor-pointer text-lg">Login</a>
        <a href="signup.php" class="hover:underline cursor-pointer text-lg">Sign Up</a>
      <?php endif; ?>
      
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="text-center py-16 px-4">
    <h2 class="text-4xl md:text-6xl font-bold mb-4 leading-tight">🎮 Fun Games to Learn Faster</h2>
    <p class="text-xl mb-8 max-w-2xl mx-auto">Interactive quizzes and games on Grammar, Math, Science, Spanish & more to make learning exciting!</p>
    <a href="games.php" class="bg-blue-600 hover:bg-blue-800 text-white px-8 py-3 rounded-full text-lg font-semibold transition-all duration-300 cursor-pointer shadow-md">Start Playing</a>
  </section>

  <!-- Game Categories -->
<section class="px-6 py-12 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 max-w-7xl mx-auto">
  <!-- Grammar Card -->
  <div class="bg-white rounded-xl shadow-lg p-4 transform hover:scale-105 transition-all duration-300 cursor-pointer flex flex-col h-full">
    <img src="https://img.freepik.com/free-vector/english-grammar-book-concept-illustration_114360-7342.jpg" alt="Grammar" class="rounded-lg h-40 w-full object-cover mb-4">
    <div class="flex-grow">
      <h3 class="text-xl font-semibold mb-2">Grammar</h3>
      <p class="text-gray-700 mb-4">Sharpen your grammar through fun and interactive challenges.</p>
    </div>
    <a href="games/quiz.php?subject=grammar" class="text-blue-600 hover:underline font-medium mt-auto">Play Grammar Quiz</a>
  </div>

  <!-- Math Card -->
  <div class="bg-white rounded-xl shadow-lg p-4 transform hover:scale-105 transition-all duration-300 cursor-pointer flex flex-col h-full">
    <img src="https://img.freepik.com/free-vector/math-teacher-concept-illustration_114360-7400.jpg" alt="Math" class="rounded-lg h-40 w-full object-cover mb-4">
    <div class="flex-grow">
      <h3 class="text-xl font-semibold mb-2">Math</h3>
      <p class="text-gray-700 mb-4">Solve puzzles and problems to level up your math skills.</p>
    </div>
    <a href="games/quiz.php?subject=math" class="text-blue-600 hover:underline font-medium mt-auto">Play Math Quiz</a>
  </div>

  <!-- Science Card -->
  <div class="bg-white rounded-xl shadow-lg p-4 transform hover:scale-105 transition-all duration-300 cursor-pointer flex flex-col h-full">
    <img src="https://img.freepik.com/free-vector/science-subject-concept-illustration_114360-7319.jpg" alt="Science" class="rounded-lg h-40 w-full object-cover mb-4">
    <div class="flex-grow">
      <h3 class="text-xl font-semibold mb-2">Science</h3>
      <p class="text-gray-700 mb-4">Explore the universe with fun science quizzes and facts.</p>
    </div>
    <a href="games/quiz.php?subject=science" class="text-blue-600 hover:underline font-medium mt-auto">Play Science Quiz</a>
  </div>

  <!-- Spanish Card -->
  <div class="bg-white rounded-xl shadow-lg p-4 transform hover:scale-105 transition-all duration-300 cursor-pointer flex flex-col h-full">
    <img src="https://img.freepik.com/free-vector/hand-drawn-spanish-symbols-illustration_23-2149234999.jpg" alt="Spanish" class="rounded-lg h-40 w-full object-cover mb-4">
    <div class="flex-grow">
      <h3 class="text-xl font-semibold mb-2">Spanish</h3>
      <p class="text-gray-700 mb-4">Learn vocabulary, verbs and culture through interactive games.</p>
    </div>
    <a href="games/quiz.php?subject=spanish" class="text-blue-600 hover:underline font-medium mt-auto">Play Spanish Quiz</a>
  </div>

  <!-- History Card -->
  <div class="bg-white rounded-xl shadow-lg p-4 transform hover:scale-105 transition-all duration-300 cursor-pointer flex flex-col h-full">
    <img src="https://img.freepik.com/free-vector/history-concept-illustration_114360-1271.jpg" alt="History" class="rounded-lg h-40 w-full object-cover mb-4">
    <div class="flex-grow">
      <h3 class="text-xl font-semibold mb-2">History</h3>
      <p class="text-gray-700 mb-4">Journey through time with fascinating historical facts.</p>
    </div>
    <a href="games/quiz.php?subject=history" class="text-blue-600 hover:underline font-medium mt-auto">Play History Quiz</a>
  </div>
</section>

  <!-- Platform Features -->
  <section class="bg-white px-6 py-16">
    <h2 class="text-center text-3xl font-bold mb-10">✨ Platform Features</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center max-w-6xl mx-auto">
      <div class="p-6 rounded-xl shadow-md bg-blue-50">
        <h3 class="text-xl font-semibold mb-2">🎯 Personalized Learning</h3>
        <p>Quizzes adapt based on your strengths and areas of improvement.</p>
      </div>
      <div class="p-6 rounded-xl shadow-md bg-purple-50">
        <h3 class="text-xl font-semibold mb-2">📈 Progress Tracking</h3>
        <p>Monitor scores and improvements across all subjects easily.</p>
      </div>
      <div class="p-6 rounded-xl shadow-md bg-green-50">
        <h3 class="text-xl font-semibold mb-2">🤝 Multiplayer Games</h3>
        <p>Play and compete with friends or classmates for extra fun.</p>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-700 text-white text-center p-5 mt-12">
    <p class="text-sm">&copy; 2025 EduPlay. All rights reserved.</p>
  </footer>

</body>
</html>