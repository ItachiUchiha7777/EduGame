<?php
session_start();
$logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us | EduPlay</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
  <style>
    .hero-pattern {
      background-color: #e0e7ff;
      background-image: radial-gradient(at 80% 0%, hsla(189,100%,56%,0.2) 0px, transparent 50%),
                      radial-gradient(at 0% 50%, hsla(355,100%,93%,0.2) 0px, transparent 50%);
    }
    .team-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .gradient-text {
      background: linear-gradient(45deg, #3b82f6, #8b5cf6);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
  </style>
</head>
<body class="font-sans">

  <!-- Navbar -->
  <nav class="bg-blue-700 p-5 text-white flex justify-between items-center shadow-lg fixed top-0 w-full z-50">
    <a href="index.php" class="text-3xl font-extrabold tracking-wide">EduPlay</a>
    <div class="space-x-6 flex items-center">
      <?php if ($logged_in): ?>
        <a href="results.php" class="hover:underline text-lg flex items-center">
          <i class="fas fa-chart-line mr-1"></i> Results
        </a>
        <a href="logout.php" class="hover:underline text-lg flex items-center">
          <i class="fas fa-sign-out-alt mr-1"></i> Logout
        </a>
      <?php else: ?>
        <a href="login.php" class="hover:underline text-lg">Login</a>
        <a href="signup.php" class="hover:underline text-lg">Sign Up</a>
      <?php endif; ?>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="pt-28 pb-16 px-4 hero-pattern">
    <div class="max-w-6xl mx-auto text-center">
      <h1 class="text-4xl md:text-5xl font-bold mb-6 gradient-text">Our Story</h1>
      <p class="text-xl md:text-2xl max-w-3xl mx-auto text-gray-700">
        Transforming education through the power of play and interactive learning.
      </p>
    </div>
  </section>

  <!-- Mission Section -->
  <section class="py-20 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div data-aos="fade-right">
          <h2 class="text-3xl font-bold mb-6 text-blue-800">Our Mission</h2>
          <p class="text-lg mb-6 text-gray-700">
            At EduPlay, we believe learning should be joyful, engaging, and accessible to everyone. 
            Our mission is to break down the barriers of traditional education by creating interactive 
            games that make mastering academic concepts as fun as playing your favorite video game.
          </p>
          <p class="text-lg text-gray-700">
            Founded in 2025 by a team of educators and game developers, we've helped over 100,000 
            students worldwide discover the joy of learning.
          </p>
        </div>
        <div data-aos="fade-left" class="relative">
          <img src="https://img.freepik.com/free-vector/happy-diverse-kids-learning-together_74855-5235.jpg" 
               alt="Students learning" 
               class="rounded-xl shadow-xl w-full">
          <div class="absolute -bottom-6 -right-6 bg-yellow-400 text-black px-6 py-2 rounded-lg shadow-lg font-bold text-lg">
            <i class="fas fa-graduation-cap mr-2"></i> 100,000+ Learners
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Core Values -->
  <section class="py-20 px-4 bg-gray-50">
    <div class="max-w-6xl mx-auto">
      <h2 class="text-center text-3xl font-bold mb-16 text-blue-800">Our Core Values</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-xl shadow-md" data-aos="fade-up">
          <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-smile text-3xl text-blue-600"></i>
          </div>
          <h3 class="text-xl font-bold mb-3">Joyful Learning</h3>
          <p class="text-gray-700">
            We design experiences that spark curiosity and make learning genuinely enjoyable. 
            When students have fun, they engage more deeply and retain knowledge longer.
          </p>
        </div>
        
        <div class="bg-white p-8 rounded-xl shadow-md" data-aos="fade-up" data-aos-delay="100">
          <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-bullseye text-3xl text-purple-600"></i>
          </div>
          <h3 class="text-xl font-bold mb-3">Proven Results</h3>
          <p class="text-gray-700">
            Our games are built on solid pedagogical research. 92% of teachers report 
            noticeable improvement in students who use EduPlay regularly.
          </p>
        </div>
        
        <div class="bg-white p-8 rounded-xl shadow-md" data-aos="fade-up" data-aos-delay="200">
          <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-globe text-3xl text-green-600"></i>
          </div>
          <h3 class="text-xl font-bold mb-3">Accessibility</h3>
          <p class="text-gray-700">
            We're committed to making quality education accessible to all, regardless of 
            location, background, or learning style. Our platform works on any device.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Team Section -->
  <section class="py-20 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
      <h2 class="text-center text-3xl font-bold mb-16 text-blue-800">Meet Our Team</h2>
      
      
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

      <div class="team-card bg-white p-6 rounded-xl shadow-md text-center transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQh9-eZU2PZk89Uc0vNa_-fMGzXDPeMJmwcRw&s" 
               alt="Maria Gonzalez" 
               class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
          <h3 class="text-xl font-bold">Narendra Modi Ji</h3>
          <p class="text-blue-600 mb-2">CEO</p>
          <p class="text-gray-700 text-sm">
            Learning specialist focused on engagement strategies.
          </p>
        </div>
        <div class="team-card bg-white p-6 rounded-xl shadow-md text-center transition-all duration-300" data-aos="fade-up">
          <img src="https://yt3.googleusercontent.com/ATJuCH36wHPiFwumVBm423ouLVGQtq2pkPMOlSCclqqXErazOWyl4n07MRmbFnSJTL5P02Fq=s900-c-k-c0x00ffffff-no-rj" 
               alt="Dr. Sarah Chen" 
               class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
          <h3 class="text-xl font-bold">Dr. Dhruv rathee</h3>
          <p class="text-blue-600 mb-2">Founder & Co-CEO</p>
          <p class="text-gray-700 text-sm">
            Former education professor with 15 years of classroom experience.
          </p>
        </div>
        
       

        <div class="team-card bg-white p-6 rounded-xl shadow-md text-center transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
          <img src="https://m.economictimes.com/thumb/msid-117262639,width-1200,height-900,resizemode-4,imgsize-33986/rahul-gandhi.jpg" 
               alt="Jamal Williams" 
               class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
          <h3 class="text-xl font-bold">Rahul Gandhi</h3>
          <p class="text-blue-600 mb-2">CTO</p>
          <p class="text-gray-700 text-sm">
            Game developer passionate about educational technology.
          </p>
        </div>
        
        
        
        <div class="team-card bg-white p-6 rounded-xl shadow-md text-center transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
          <img src="https://bharatiyavishwa.com/wp-content/uploads/2020/06/Arvind-Kejriwal-with-party-leaders-during-Aam-Aadmi-Partys-victory-rally-e1622554054535.jpg" 
               alt="David Kim" 
               class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
          <h3 class="text-xl font-bold">David Kim</h3>
          <p class="text-blue-600 mb-2">Art Director</p>
          <p class="text-gray-700 text-sm">
            Creates the vibrant worlds that make learning magical.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Impact Stats -->
  <section class="py-20 px-4 bg-blue-700 text-white">
    <div class="max-w-6xl mx-auto">
      <h2 class="text-center text-3xl font-bold mb-16">Our Impact</h2>
      
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
        <div data-aos="fade-up">
          <div class="text-4xl font-bold mb-2">50+</div>
          <p>Interactive Games</p>
        </div>
        <div data-aos="fade-up" data-aos-delay="100">
          <div class="text-4xl font-bold mb-2">10K+</div>
          <p>Classrooms Using EduPlay</p>
        </div>
        <div data-aos="fade-up" data-aos-delay="200">
          <div class="text-4xl font-bold mb-2">92%</div>
          <p>Teachers Report Improvement</p>
        </div>
        <div data-aos="fade-up" data-aos-delay="300">
          <div class="text-4xl font-bold mb-2">5M+</div>
          <p>Problems Solved Monthly</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="py-20 px-4 bg-white">
    <div class="max-w-2xl mx-auto text-center">
      <h2 class="text-3xl font-bold mb-6 text-blue-800">Join the EduPlay Movement</h2>
      <p class="text-xl mb-8 text-gray-700">
        Whether you're a student, parent, or educator, we'd love to have you 
        be part of our learning community.
      </p>
      <div class="flex flex-col sm:flex-row justify-center gap-4">
        <a href="signup.php" class="bg-blue-600 hover:bg-blue-800 text-white px-8 py-3 rounded-full text-lg font-semibold shadow-lg transition-all">
          Sign Up Free
        </a>
        <a href="contact.php" class="bg-white border-2 border-blue-600 text-blue-600 px-8 py-3 rounded-full text-lg font-semibold shadow-lg transition-all hover:bg-blue-50">
          Contact Us
        </a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-800 text-white py-12 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
      <div>
        <h3 class="text-2xl font-bold mb-4">EduPlay</h3>
        <p>Making learning fun through interactive games and adventures.</p>
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
        </ul>
      </div>
      <div>
        <h4 class="font-bold mb-4">Connect</h4>
        <div class="flex space-x-4">
          <a href="#" class="text-2xl hover:text-blue-300"><i class="fab fa-facebook"></i></a>
          <a href="#" class="text-2xl hover:text-blue-300"><i class="fab fa-twitter"></i></a>
          <a href="#" class="text-2xl hover:text-blue-300"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
    </div>
    <div class="border-t border-blue-700 mt-8 pt-8 text-center text-sm">
      <p>&copy; 2025 EduPlay. All rights reserved. | <a href="#" class="hover:underline">Privacy Policy</a> | <a href="#" class="hover:underline">Terms of Service</a></p>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
      duration: 800,
      once: true
    });
  </script>
</body>
</html>