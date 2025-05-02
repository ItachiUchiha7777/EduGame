<?php
session_start();
$logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us | EduPlay</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
  <style>
    .contact-pattern {
      background-color: #f0f4ff;
      background-image: radial-gradient(at 80% 50%, hsla(189,100%,56%,0.1) 0px, transparent 50%),
                      radial-gradient(at 0% 100%, hsla(355,100%,93%,0.1) 0px, transparent 50%);
    }
    .contact-card {
      transition: all 0.3s ease;
    }
    .contact-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .gradient-text {
      background: linear-gradient(45deg, #3b82f6, #8b5cf6);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    #contact-form {
      box-shadow: 0 10px 30px -5px rgba(59, 130, 246, 0.2);
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
  <section class="pt-28 pb-16 px-4 contact-pattern">
    <div class="max-w-6xl mx-auto text-center">
      <h1 class="text-4xl md:text-5xl font-bold mb-6 gradient-text">Contact Us</h1>
      <p class="text-xl md:text-2xl max-w-3xl mx-auto text-gray-700">
        We'd love to hear from you! Reach out with questions, feedback, or partnership opportunities.
      </p>
    </div>
  </section>

  <!-- Contact Options -->
  <section class="py-16 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="contact-card bg-blue-50 p-8 rounded-xl text-center" data-aos="fade-up">
          <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-envelope text-2xl text-blue-600"></i>
          </div>
          <h3 class="text-xl font-bold mb-2">Email Us</h3>
          <p class="text-gray-700 mb-4">For general inquiries</p>
          <a href="mailto:hello@eduplay.com" class="text-blue-600 font-semibold hover:underline">
            hello@eduplay.com
          </a>
        </div>
        
        <div class="contact-card bg-purple-50 p-8 rounded-xl text-center" data-aos="fade-up" data-aos-delay="100">
          <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-headset text-2xl text-purple-600"></i>
          </div>
          <h3 class="text-xl font-bold mb-2">Support</h3>
          <p class="text-gray-700 mb-4">Technical help and account questions</p>
          <a href="mailto:support@eduplay.com" class="text-purple-600 font-semibold hover:underline">
            support@eduplay.com
          </a>
        </div>
        
        <div class="contact-card bg-green-50 p-8 rounded-xl text-center" data-aos="fade-up" data-aos-delay="200">
          <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-school text-2xl text-green-600"></i>
          </div>
          <h3 class="text-xl font-bold mb-2">Schools</h3>
          <p class="text-gray-700 mb-4">For educational institutions</p>
          <a href="mailto:schools@eduplay.com" class="text-green-600 font-semibold hover:underline">
            schools@eduplay.com
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Form -->
  <section class="py-16 px-4 bg-gray-50">
    <div class="max-w-4xl mx-auto">
      <div id="contact-form" class="bg-white rounded-xl p-8 md:p-12">
        <h2 class="text-3xl font-bold mb-8 text-center text-blue-800">Send Us a Message</h2>
        
        <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
          <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            Thank you for your message! We'll get back to you soon.
          </div>
        <?php endif; ?>
        
        <form action="process-contact.php" method="POST">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
              <input type="text" id="name" name="name" required
                     class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none">
            </div>
            <div>
              <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
              <input type="email" id="email" name="email" required
                     class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none">
            </div>
          </div>
          
          <div class="mb-6">
            <label for="subject" class="block text-gray-700 font-medium mb-2">Subject</label>
            <select id="subject" name="subject" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none">
              <option value="">Select a subject</option>
              <option value="General Inquiry">General Inquiry</option>
              <option value="Technical Support">Technical Support</option>
              <option value="School Partnership">School Partnership</option>
              <option value="Feedback">Feedback</option>
              <option value="Other">Other</option>
            </select>
          </div>
          
          <div class="mb-6">
            <label for="message" class="block text-gray-700 font-medium mb-2">Message</label>
            <textarea id="message" name="message" rows="5" required
                      class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none"></textarea>
          </div>
          
          <div class="text-center">
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-800 text-white px-8 py-3 rounded-full text-lg font-semibold shadow-lg transition-all">
              Send Message
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="py-16 px-4 bg-white">
    <div class="max-w-4xl mx-auto">
      <h2 class="text-center text-3xl font-bold mb-12 text-blue-800">Frequently Asked Questions</h2>
      
      <div class="space-y-4">
        <div class="faq-item bg-gray-50 p-6 rounded-xl cursor-pointer">
          <h3 class="text-xl font-bold mb-2 flex justify-between items-center">
            <span>How long does it take to get a response?</span>
            <i class="fas fa-chevron-down text-blue-600"></i>
          </h3>
          <p class="text-gray-700 mt-2 hidden">
            We typically respond to all inquiries within 24-48 hours. For urgent matters, please include "URGENT" in your subject line.
          </p>
        </div>
        
        <div class="faq-item bg-gray-50 p-6 rounded-xl cursor-pointer">
          <h3 class="text-xl font-bold mb-2 flex justify-between items-center">
            <span>Do you offer discounts for schools?</span>
            <i class="fas fa-chevron-down text-blue-600"></i>
          </h3>
          <p class="text-gray-700 mt-2 hidden">
            Yes! We offer special pricing for schools and educational institutions. Please contact our schools team at schools@eduplay.com for more information.
          </p>
        </div>
        
        <div class="faq-item bg-gray-50 p-6 rounded-xl cursor-pointer">
          <h3 class="text-xl font-bold mb-2 flex justify-between items-center">
            <span>Can I suggest a new game or feature?</span>
            <i class="fas fa-chevron-down text-blue-600"></i>
          </h3>
          <p class="text-gray-700 mt-2 hidden">
            Absolutely! We love hearing ideas from our community. Use the "Feedback" option in the contact form or email us directly at feedback@eduplay.com.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Location -->
  <section class="py-16 px-4 bg-gray-50">
    <div class="max-w-6xl mx-auto">
      <h2 class="text-center text-3xl font-bold mb-12 text-blue-800">Our Headquarters</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div data-aos="fade-right">
          <h3 class="text-2xl font-bold mb-4">EduPlay Learning Technologies</h3>
          <address class="not-italic text-gray-700 mb-6">
            123 Education Way<br>
            San Francisco, CA 94107<br>
            United States
          </address>
          
          <div class="space-y-2">
            <p class="flex items-center">
              <i class="fas fa-phone-alt text-blue-600 mr-2"></i>
              <span>+1 (800) 555-EDU</span>
            </p>
            <p class="flex items-center">
              <i class="fas fa-clock text-blue-600 mr-2"></i>
              <span>Monday-Friday: 9am-5pm PST</span>
            </p>
          </div>
        </div>
        
        <div data-aos="fade-left" class="h-80 bg-gray-200 rounded-xl overflow-hidden">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.222656786703!2d-122.4194!3d37.7749!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzfCsDQ2JzI5LjYiTiAxMjLCsDI1JzA5LjkiVw!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus" 
                  width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
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
        </ul>
      </div>
      <div>
        <h4 class="font-bold mb-4">Support</h4>
        <ul class="space-y-2">
          <li><a href="faq.php" class="hover:underline">FAQ</a></li>
          <li><a href="contact.php" class="hover:underline">Contact</a></li>
          <li><a href="privacy.php" class="hover:underline">Privacy Policy</a></li>
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
      <p>&copy; 2025 EduPlay. All rights reserved.</p>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
      duration: 800,
      once: true
    });
    
    // FAQ toggle functionality
    $('.faq-item h3').click(function() {
      $(this).next('p').slideToggle();
      $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
    });
  </script>
</body>
</html>