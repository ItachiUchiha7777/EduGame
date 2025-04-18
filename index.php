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

  <!-- Animate on Scroll (AOS) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet" />


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Lottie -->
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

  <style>
    .wave-bg {
      background: linear-gradient(120deg, #f0f4ff 0%, #f4e8ff 100%);
    }
    .glass {
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
  </style>
</head>

<body class="wave-bg text-gray-800 font-sans scroll-smooth">

  <!-- Navbar -->
  <nav class="bg-blue-700 p-5 text-white flex justify-between items-center shadow-lg fixed top-0 w-full z-50">
    <h1 class="text-3xl font-extrabold tracking-wide">EduPlay</h1>
    <div class="space-x-6 flex items-center">
      <?php if ($logged_in): ?>
        <span class="text-blue-100">Welcome, <?= htmlspecialchars($_SESSION['name']) ?></span>
        <a href="results.php" class="hover:underline text-lg flex items-center transition-transform transform hover:scale-110">
          <i class="fas fa-chart-line mr-1"></i> Results
        </a>
        <a href="logout.php" class="hover:underline text-lg flex items-center transition-transform transform hover:scale-110">
          <i class="fas fa-sign-out-alt mr-1"></i> Logout
        </a>
      <?php else: ?>
        <a href="login.php" class="hover:underline text-lg transition-transform transform hover:scale-110">Login</a>
        <a href="signup.php" class="hover:underline text-lg transition-transform transform hover:scale-110">Sign Up</a>
      <?php endif; ?>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="pt-28 pb-16 px-4 text-center" id="hero">
    <div class="max-w-4xl mx-auto" data-aos="fade-up">
      <h2 class="text-5xl md:text-6xl font-bold mb-4 leading-tight text-purple-700">🎮 Learn Through Play</h2>
      <p class="text-xl mb-8 text-gray-700">Grammar, Math, Science, Spanish & more—discover joy in learning!</p>
      <a href="games.php" class="bg-blue-600 hover:bg-blue-800 text-white px-8 py-3 rounded-full text-lg font-semibold shadow-lg transition-all duration-300 inline-block">Explore Games</a>
    </div>
    <div class="mt-10">
      <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_kyu7xb1v.json" background="transparent" speed="1" style="width: 300px; height: 300px; margin: auto;" loop autoplay></lottie-player>
    </div>
  </section>

  <!-- Game Categories -->
  <section id="categories" class="px-6 py-16 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10 max-w-7xl mx-auto" data-aos="fade-up">
    <?php
      $games = [
        ["Grammar", "grammar", "Sharpen your grammar through fun challenges.", "https://img.freepik.com/free-vector/english-grammar-book-concept-illustration_114360-7342.jpg"],
        ["Math", "math", "Solve puzzles to boost math skills.", "https://img.freepik.com/free-vector/math-teacher-concept-illustration_114360-7400.jpg"],
        // ["Science", "science", "Explore science with quizzes & fun facts.", "https://img.freepik.com/free-vector/science-subject-concept-illustration_114360-7319.jpg"],
        ["Spanish", "spanish", "Learn Spanish through vocabulary games.", "https://img.freepik.com/free-vector/hand-drawn-spanish-symbols-illustration_23-2149234999.jpg"],
        ["History", "history", "Journey through time with historical quizzes.", "https://img.freepik.com/free-vector/history-concept-illustration_114360-1271.jpg"]
      ];

      foreach ($games as $game) {
        echo '
        <div class="bg-white rounded-xl shadow-xl p-4 transform hover:scale-105 transition-all duration-300 cursor-pointer flex flex-col h-full glass backdrop-blur-sm" data-aos="zoom-in">
          <img src="'.$game[3].'" alt="'.$game[0].'" class="rounded-lg h-40 w-full object-cover mb-4">
          <div class="flex-grow">
            <h3 class="text-xl font-bold mb-2 text-blue-700">'.$game[0].'</h3>
            <p class="text-gray-700 mb-4">'.$game[2].'</p>
          </div>
          <a href="games/quiz.php?subject='.$game[1].'" class="text-blue-600 hover:underline font-semibold mt-auto">Play '.$game[0].' Quiz</a>
        </div>';
      }
    ?>
  </section>

  <!-- Platform Features -->
  <section class="bg-white px-6 py-20" data-aos="fade-up">
    <h2 class="text-center text-4xl font-bold mb-12 text-blue-800">✨ Why EduPlay?</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto text-center">
      <div class="p-6 rounded-xl shadow-md bg-gradient-to-br from-blue-100 to-blue-50">
        <h3 class="text-xl font-semibold mb-2">🎯 Personalized Learning</h3>
        <p>Quizzes adapt to your strengths and needs.</p>
      </div>
      <div class="p-6 rounded-xl shadow-md bg-gradient-to-br from-purple-100 to-purple-50">
        <h3 class="text-xl font-semibold mb-2">📈 Track Progress</h3>
        <p>Visualize how you're improving over time.</p>
      </div>
      <div class="p-6 rounded-xl shadow-md bg-gradient-to-br from-green-100 to-green-50">
        <h3 class="text-xl font-semibold mb-2">🧠 Multiple Subjects</h3>
        <p>Enjoy diverse topics to keep learning fun.</p>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-700 text-white text-center p-5 mt-12">
    <p class="text-sm">&copy; 2025 EduPlay. All rights reserved.</p>
  </footer>

  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      once: true,
    });

    // jQuery smooth scroll
    $('a[href^="#"]').on('click', function(event) {
      const target = $(this.getAttribute('href'));
      if (target.length) {
        event.preventDefault();
        $('html, body').animate({ scrollTop: target.offset().top - 60 }, 1000);
      }
    });
  </script>
</body>
</html>
