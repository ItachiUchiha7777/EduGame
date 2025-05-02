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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    .gradient-text {
      background: linear-gradient(45deg, #3b82f6, #8b5cf6);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    .floating { 
      animation: floating 3s ease-in-out infinite;
    }
    @keyframes floating {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-15px); }
      100% { transform: translateY(0px); }
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
      <h2 class="text-5xl md:text-6xl font-bold mb-4 leading-tight gradient-text">🎮 Learn Through Play</h2>
      <p class="text-xl mb-8 text-gray-700">Grammar, Math, Science, Spanish & more—discover joy in learning!</p>
      <a href="games.php" class="bg-blue-600 hover:bg-blue-800 text-white px-8 py-3 rounded-full text-lg font-semibold shadow-lg transition-all duration-300 inline-block transform hover:scale-105">
        Explore Games
      </a>
    </div>
    <div class="mt-10">
      <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_kyu7xb1v.json" background="transparent" speed="1" style="width: 300px; height: 300px; margin: auto;" loop autoplay></lottie-player>
    </div>
  </section>

  <!-- Stats Section -->
  <section class="py-12 bg-white bg-opacity-50 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
        <div class="p-6 rounded-xl glass" data-aos="fade-up" data-aos-delay="100">
          <h3 class="text-4xl font-bold text-blue-600 mb-2">10,000+</h3>
          <p class="text-gray-700">Active Learners</p>
        </div>
        <div class="p-6 rounded-xl glass" data-aos="fade-up" data-aos-delay="200">
          <h3 class="text-4xl font-bold text-purple-600 mb-2">50+</h3>
          <p class="text-gray-700">Interactive Games</p>
        </div>
        <div class="p-6 rounded-xl glass" data-aos="fade-up" data-aos-delay="300">
          <h3 class="text-4xl font-bold text-green-600 mb-2">95%</h3>
          <p class="text-gray-700">Report Better Grades</p>
        </div>
        <div class="p-6 rounded-xl glass" data-aos="fade-up" data-aos-delay="400">
          <h3 class="text-4xl font-bold text-yellow-600 mb-2">4.9/5</h3>
          <p class="text-gray-7 00">User Satisfaction</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Game Categories -->
  <section id="categories" class="px-6 py-16 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10 max-w-7xl mx-auto">
    <?php
      $games = [
        ["Grammar", "grammar", "Sharpen your grammar through fun challenges.", "https://img.freepik.com/free-vector/english-grammar-book-concept-illustration_114360-7342.jpg"],
        ["Math", "math", "Solve puzzles to boost math skills.", "https://img.freepik.com/free-vector/math-teacher-concept-illustration_114360-7400.jpg"],
        ["Science", "science", "Explore science with quizzes & fun facts.", "https://img.freepik.com/free-vector/science-subject-concept-illustration_114360-7319.jpg"],
        ["Spanish", "spanish", "Learn Spanish through vocabulary games.", "https://img.freepik.com/free-vector/hand-drawn-spanish-symbols-illustration_23-2149234999.jpg"],
        ["History", "history", "Journey through time with historical quizzes.", "https://img.freepik.com/free-vector/history-concept-illustration_114360-1271.jpg"],
        ["Geography", "geography", "Discover the world through maps and trivia.", "https://img.freepik.com/free-vector/world-map-concept-illustration_114360-7403.jpg"],
        ["Coding", "coding", "Learn programming basics with fun puzzles.", "https://img.freepik.com/free-vector/hand-drawn-web-developers_23-2148819604.jpg"],
        ["Art", "art", "Explore art history and creativity.", "https://img.freepik.com/free-vector/art-concept-illustration_114360-8393.jpg"]
      ];

      foreach ($games as $index => $game) {
        echo '
        <div class="bg-white rounded-xl shadow-xl p-4 transform hover:scale-105 transition-all duration-300 cursor-pointer flex flex-col h-full glass backdrop-blur-sm" data-aos="zoom-in" data-aos-delay="'.($index*100).'">
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

  <!-- Testimonials -->
  <section class="py-20 bg-gradient-to-r from-blue-50 to-purple-50">
    <div class="max-w-6xl mx-auto px-4">
      <h2 class="text-center text-4xl font-bold mb-16 text-blue-800" data-aos="fade-up">What Our Learners Say</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-xl shadow-lg" data-aos="fade-up" data-aos-delay="100">
          <div class="flex items-center mb-4">
            <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Sarah" class="w-12 h-12 rounded-full mr-4">
            <div>
              <h4 class="font-bold">Sarah K.</h4>
              <div class="flex text-yellow-400">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
            </div>
          </div>
          <p class="text-gray-700">"EduPlay made learning Spanish so much fun! I went from struggling to now having conversations after just 2 months."</p>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-lg" data-aos="fade-up" data-aos-delay="200">
          <div class="flex items-center mb-4">
            <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="David" class="w-12 h-12 rounded-full mr-4">
            <div>
              <h4 class="font-bold">David M.</h4>
              <div class="flex text-yellow-400">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
            </div>
          </div>
          <p class="text-gray-700">"The math games helped my son improve his grades from C to A. He actually asks to play them after school!"</p>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-lg" data-aos="fade-up" data-aos-delay="300">
          <div class="flex items-center mb-4">
            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Priya" class="w-12 h-12 rounded-full mr-4">
            <div>
              <h4 class="font-bold">Priya R.</h4>
              <div class="flex text-yellow-400">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
              </div>
            </div>
          </div>
          <p class="text-gray-700">"As a teacher, I recommend EduPlay to all my students. The grammar games are especially effective for ESL learners."</p>
        </div>
      </div>
    </div>
  </section>

  <!-- How It Works -->
  <section class="py-20 px-4">
    <div class="max-w-6xl mx-auto">
      <h2 class="text-center text-4xl font-bold mb-16 text-blue-800" data-aos="fade-up">How EduPlay Works</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center" data-aos="fade-up" data-aos-delay="100">
          <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-user-plus text-3xl text-blue-600"></i>
          </div>
          <h3 class="text-xl font-bold mb-2">1. Create Your Account</h3>
          <p class="text-gray-700">Sign up in seconds to track your progress and unlock all features.</p>
        </div>
        <div class="text-center" data-aos="fade-up" data-aos-delay="200">
          <div class="bg-purple-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-gamepad text-3xl text-purple-600"></i>
          </div>
          <h3 class="text-xl font-bold mb-2">2. Choose Your Game</h3>
          <p class="text-gray-700">Select from dozens of educational games across multiple subjects.</p>
        </div>
        <div class="text-center" data-aos="fade-up" data-aos-delay="300">
          <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-trophy text-3xl text-green-600"></i>
          </div>
          <h3 class="text-xl font-bold mb-2">3. Learn & Earn Rewards</h3>
          <p class="text-gray-700">Play, learn, and collect badges as you master new concepts.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Game -->
  <section class="py-20 bg-gradient-to-br from-blue-600 to-purple-600 text-white">
    <div class="max-w-6xl mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div data-aos="fade-right">
          <h2 class="text-3xl font-bold mb-4">Explore MCQs for Various Subjects</h2>
          <p class="text-lg mb-6">Dive into our extensive collection of multiple-choice questions designed to make learning engaging and effective. Perfect for students of all ages!</p>
          <ul class="space-y-3 mb-8">
            <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-green-300"></i> Covers subjects like Math, Science, Grammar, and more</li>
            <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-green-300"></i> Tailored difficulty levels for every learner</li>
            <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-green-300"></i> Instant feedback to track your progress</li>
          </ul>
          <a href="games.php" class="bg-white text-blue-600 px-6 py-3 rounded-full font-bold inline-block hover:bg-blue-100 transition-all">Start Practicing</a>
        </div>
        <div data-aos="fade-left" class="relative">
          <img src="https://img.freepik.com/free-vector/online-quiz-concept-illustration_114360-747.jpg" alt="MCQ Practice" class="rounded-xl shadow-2xl w-full max-w-md mx-auto floating">
          <!-- <div class="absolute -bottom-6 -right-6 bg-yellow-400 text-black px-4 py-2 rounded-lg shadow-lg font-bold"> -->
            <!-- <i class="fas fa-star mr-1"></i> Learn & Excel! -->
          <!-- </div> -->
        </div>
      </div>
    </div>
  </section>

  <!-- Platform Features -->
  <section class="bg-white px-6 py-20">
    <h2 class="text-center text-4xl font-bold mb-12 text-blue-800">✨ Why EduPlay?</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto text-center">
      <div class="p-6 rounded-xl shadow-md bg-gradient-to-br from-blue-100 to-blue-50" data-aos="fade-up">
        <h3 class="text-xl font-semibold mb-2">🎯 Personalized Learning</h3>
        <p>Quizzes adapt to your strengths and needs.</p>
      </div>
      <div class="p-6 rounded-xl shadow-md bg-gradient-to-br from-purple-100 to-purple-50" data-aos="fade-up" data-aos-delay="100">
        <h3 class="text-xl font-semibold mb-2">📈 Track Progress</h3>
        <p>Visualize how you're improving over time.</p>
      </div>
      <div class="p-6 rounded-xl shadow-md bg-gradient-to-br from-green-100 to-green-50" data-aos="fade-up" data-aos-delay="200">
        <h3 class="text-xl font-semibold mb-2">🧠 Multiple Subjects</h3>
        <p>Enjoy diverse topics to keep learning fun.</p>
      </div>
      <div class="p-6 rounded-xl shadow-md bg-gradient-to-br from-yellow-100 to-yellow-50" data-aos="fade-up">
        <h3 class="text-xl font-semibold mb-2">🏆 Reward System</h3>
        <p>Earn badges and unlock achievements.</p>
      </div>
      <div class="p-6 rounded-xl shadow-md bg-gradient-to-br from-pink-100 to-pink-50" data-aos="fade-up" data-aos-delay="100">
        <h3 class="text-xl font-semibold mb-2">👨‍👩‍👧‍👦 Family Plan</h3>
        <p>Share one account with up to 5 family members.</p>
      </div>
      <div class="p-6 rounded-xl shadow-md bg-gradient-to-br from-indigo-100 to-indigo-50" data-aos="fade-up" data-aos-delay="200">
        <h3 class="text-xl font-semibold mb-2">📱 Mobile Friendly</h3>
        <p>Learn anywhere, anytime on any device.</p>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="py-20 px-4 text-center bg-gradient-to-r from-purple-600 to-blue-600 text-white">
    <div class="max-w-4xl mx-auto" data-aos="zoom-in">
      <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Transform Learning?</h2>
      <p class="text-xl mb-8">Join thousands of learners who are making education fun and effective.</p>
      <div class="flex flex-col sm:flex-row justify-center gap-4">
        <a href="games.php" class="bg-white text-blue-600 px-8 py-3 rounded-full font-bold text-lg hover:bg-blue-100 transition-all transform hover:scale-105">
        Browse Games
        </a>
        <!-- <a href="games.php" class="bg-transparent border-2 border-white px-8 py-3 rounded-full font-bold text-lg hover:bg-white hover:text-blue-600 transition-all transform hover:scale-105">
          Browse Games
        </a> -->
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="py-20 px-4 bg-gray-50">
    <div class="max-w-4xl mx-auto">
      <h2 class="text-center text-4xl font-bold mb-12 text-blue-800">Frequently Asked Questions</h2>
      <div class="space-y-4">
        <div class="bg-white p-6 rounded-xl shadow-md" data-aos="fade-up">
          <h3 class="text-xl font-bold mb-2 flex justify-between items-center cursor-pointer">
            <span>Is EduPlay really free to use?</span>
            <i class="fas fa-chevron-down text-blue-600"></i>
          </h3>
          <p class="text-gray-700 mt-2 hidden">Yes! EduPlay offers a completely free tier with access to all basic games and features. We also offer a premium subscription with additional content and features for those who want even more learning opportunities.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md" data-aos="fade-up">
          <h3 class="text-xl font-bold mb-2 flex justify-between items-center cursor-pointer">
            <span>What age groups is EduPlay suitable for?</span>
            <i class="fas fa-chevron-down text-blue-600"></i>
          </h3>
          <p class="text-gray-700 mt-2 hidden">Our games are designed for learners aged 6-16, with content tailored to different grade levels and skill sets. Many adults also enjoy our language learning and trivia games!</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md" data-aos="fade-up">
          <h3 class="text-xl font-bold mb-2 flex justify-between items-center cursor-pointer">
            <span>Can teachers use EduPlay in classrooms?</span>
            <i class="fas fa-chevron-down text-blue-600"></i>
          </h3>
          <p class="text-gray-700 mt-2 hidden">Absolutely! We offer special classroom accounts with progress tracking for up to 40 students. Many teachers use EduPlay as a supplemental learning tool or for homework assignments.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-800 text-white">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
      <div>
        <h3 class="text-2xl font-bold mb-4">EduPlay</h3>
        <p>Making learning fun and effective through interactive games since 2020.</p>
      </div>
      <div>
        <h4 class="font-bold mb-4">Quick Links</h4>
        <ul class="space-y-2">
          <li><a href="games.php" class="hover:underline">All Games</a></li>
          <li><a href="about.php" class="hover:underline">About Us</a></li>
          <li><a href="blog.php" class="hover:underline">Blog</a></li>
          <li><a href="contact.php" class="hover:underline">Contact</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold mb-4">Subjects</h4>
        <ul class="space-y-2">
          <li><a href="games/math.php" class="hover:underline">Math</a></li>
          <li><a href="games/grammar.php" class="hover:underline">Grammar</a></li>
          <li><a href="games/science.php" class="hover:underline">Science</a></li>
          <li><a href="games/languages.php" class="hover:underline">Languages</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold mb-4">Connect With Us</h4>
        <div class="flex space-x-4 mb-4">
          <a href="#" class="text-2xl hover:text-blue-300"><i class="fab fa-facebook"></i></a>
          <a href="#" class="text-2xl hover:text-blue-300"><i class="fab fa-twitter"></i></a>
          <a href="#" class="text-2xl hover:text-blue-300"><i class="fab fa-instagram"></i></a>
          <a href="#" class="text-2xl hover:text-blue-300"><i class="fab fa-youtube"></i></a>
        </div>
        <p>Subscribe to our newsletter for updates</p>
        <div class="mt-2 flex">
          <input type="email" placeholder="Your email" class="px-3 py-2 rounded-l text-gray-800 w-full">
          <button class="bg-blue-600 px-4 py-2 rounded-r hover:bg-blue-700">Join</button>
        </div>
      </div>
    </div>
    <div class="border-t border-blue-700 pt-6 pb-4 text-center">
      <p class="text-sm">&copy; 2025 EduPlay. All rights reserved. | <a href="#" class="hover:underline">Privacy Policy</a> | <a href="#" class="hover:underline">Terms of Service</a></p>
    </div>
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

    // FAQ toggle
    $('.bg-white h3').on('click', function() {
      $(this).next('p').slideToggle();
      $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
    });
  </script>
</body>
</html>