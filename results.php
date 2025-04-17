<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$conn = new mysqli('localhost', 'root', '', 'eduplay');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT subject, score, total, attempted_on FROM scores WHERE user_id = $user_id ORDER BY attempted_on DESC");

// Get user stats
$stats = $conn->query("SELECT 
  COUNT(*) as total_quizzes,
  SUM(score) as total_points,
  (SELECT COUNT(DISTINCT subject) FROM scores WHERE user_id = $user_id) as subjects_count
  FROM scores WHERE user_id = $user_id")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Quiz Results</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
  <div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-12">
      <h1 class="text-4xl font-bold text-blue-600 mb-2">Your Learning Journey</h1>
      <p class="text-gray-600">Track your progress and achievements</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
      <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
            <i class="fas fa-trophy text-xl"></i>
          </div>
          <div>
            <p class="text-gray-500">Total Quizzes</p>
            <h3 class="text-2xl font-bold"><?= $stats['total_quizzes'] ?></h3>
          </div>
        </div>
      </div>
      
      <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
            <i class="fas fa-star text-xl"></i>
          </div>
          <div>
            <p class="text-gray-500">Total Points</p>
            <h3 class="text-2xl font-bold"><?= $stats['total_points'] ?></h3>
          </div>
        </div>
      </div>
      
      <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-purple-500">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
            <i class="fas fa-book-open text-xl"></i>
          </div>
          <div>
            <p class="text-gray-500">Subjects Mastered</p>
            <h3 class="text-2xl font-bold"><?= $stats['subjects_count'] ?></h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Results Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
      <div class="p-4 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Quiz History</h2>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php while ($row = $result->fetch_assoc()): 
              $percentage = round(($row['score'] / $row['total']) * 100);
              $performance = getPerformanceLevel($percentage);
            ?>
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 rounded-full bg-<?= $performance['color'] ?>-100 flex items-center justify-center">
                    <i class="fas fa-<?= $row['subject'] == 'math' ? 'calculator' : ($row['subject'] == 'science' ? 'flask' : ($row['subject'] == 'history' ? 'landmark' : 'book')) ?> text-<?= $performance['color'] ?>-600"></i>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900"><?= ucfirst($row['subject']) ?></div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900"><?= $row['score'] ?>/<?= $row['total'] ?></div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="w-24 bg-gray-200 rounded-full h-2.5 mr-2">
                    <div class="bg-<?= $performance['color'] ?>-600 h-2.5 rounded-full" style="width: <?= $percentage ?>%"></div>
                  </div>
                  <span class="text-sm font-medium"><?= $percentage ?>%</span>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <?= date('M d, Y h:i A', strtotime($row['attempted_on'])) ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-<?= $performance['color'] ?>-100 text-<?= $performance['color'] ?>-800">
                  <?= $performance['text'] ?>
                </span>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>

<?php
function getPerformanceLevel($percentage) {
  if ($percentage >= 90) return ['text' => 'Excellent', 'color' => 'green', 'icon' => 'award'];
  if ($percentage >= 70) return ['text' => 'Good', 'color' => 'blue', 'icon' => 'thumbs-up'];
  if ($percentage >= 50) return ['text' => 'Average', 'color' => 'yellow', 'icon' => 'check'];
  return ['text' => 'Needs Work', 'color' => 'red', 'icon' => 'exclamation'];
}
?>