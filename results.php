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

// Get quiz results
$quiz_results = $conn->query("SELECT 
  'quiz' as activity_type,
  subject as title, 
  score, 
  total, 
  attempted_on as completion_date,
  NULL as time_taken
  FROM scores 
  WHERE user_id = $user_id");

// Get word search results
$wordsearch_results = $conn->query("SELECT 
  'wordsearch' as activity_type,
  CONCAT('Puzzle ', puzzle_id) as title, 
  found_words as score, 
  total_words as total, 
  completed_at as completion_date,
  time_taken
  FROM wordsearch_scores 
  WHERE user_id = $user_id");

// Combine results
$all_results = [];
while ($row = $quiz_results->fetch_assoc()) {
  $all_results[] = $row;
}
while ($row = $wordsearch_results->fetch_assoc()) {
  $all_results[] = $row;
}

// Sort by completion date (newest first)
usort($all_results, function($a, $b) {
  return strtotime($b['completion_date']) - strtotime($a['completion_date']);
});

// Get user stats (combined for both quiz and word search)
$stats = $conn->query("SELECT 
  (SELECT COUNT(*) FROM scores WHERE user_id = $user_id) as total_quizzes,
  (SELECT COUNT(*) FROM wordsearch_scores WHERE user_id = $user_id) as total_wordsearches,
  (SELECT SUM(score) FROM scores WHERE user_id = $user_id) as total_quiz_points,
  (SELECT SUM(found_words) FROM wordsearch_scores WHERE user_id = $user_id) as total_wordsearch_points,
  (SELECT COUNT(DISTINCT subject) FROM scores WHERE user_id = $user_id) as subjects_count
  ")->fetch_assoc();

$stats['total_activities'] = $stats['total_quizzes'] + $stats['total_wordsearches'];
$stats['total_points'] = $stats['total_quiz_points'] + $stats['total_wordsearch_points'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Your Results</title>
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
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
      <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
            <i class="fas fa-trophy text-xl"></i>
          </div>
          <div>
            <p class="text-gray-500">Total Activities</p>
            <h3 class="text-2xl font-bold"><?= $stats['total_activities'] ?></h3>
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
      
      <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-yellow-500">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
            <i class="fas fa-search text-xl"></i>
          </div>
          <div>
            <p class="text-gray-500">Word Searches</p>
            <h3 class="text-2xl font-bold"><?= $stats['total_wordsearches'] ?></h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Results Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
      <div class="p-4 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Activity History</h2>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Taken</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($all_results as $row): 
              $percentage = round(($row['score'] / $row['total']) * 100);
              $performance = getPerformanceLevel($percentage);
              $time_taken = $row['time_taken'] ? gmdate("i:s", $row['time_taken']) : 'N/A';
            ?>
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 rounded-full bg-<?= $performance['color'] ?>-100 flex items-center justify-center">
                    <?php if ($row['activity_type'] === 'quiz'): ?>
                      <i class="fas fa-<?= $row['title'] == 'math' ? 'calculator' : ($row['title'] == 'science' ? 'flask' : ($row['title'] == 'history' ? 'landmark' : 'book')) ?> text-<?= $performance['color'] ?>-600"></i>
                    <?php else: ?>
                      <i class="fas fa-search text-<?= $performance['color'] ?>-600"></i>
                    <?php endif; ?>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">
                      <?= $row['title'] ?>
                      <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        <?= $row['activity_type'] === 'quiz' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' ?>">
                        <?= ucfirst($row['activity_type']) ?>
                      </span>
                    </div>
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
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                <?= $time_taken ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <?= date('M d, Y h:i A', strtotime($row['completion_date'])) ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-<?= $performance['color'] ?>-100 text-<?= $performance['color'] ?>-800">
                  <?= $performance['text'] ?>
                </span>
              </td>
            </tr>
            <?php endforeach; ?>
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