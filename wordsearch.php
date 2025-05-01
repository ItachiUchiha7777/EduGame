<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'eduplay';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$subject = $_GET['subject'] ?? 'general';
$puzzle_id = $_GET['id'] ?? null;

// Function to get words by subject
function getWordsBySubject($subject) {
    $wordLists = [
        'math' => ['addition', 'subtract', 'multiply', 'divide', 'fraction', 'decimal', 'percent', 'algebra', 'geometry', 'calculus'],
        'grammar' => ['noun', 'verb', 'adjective', 'adverb', 'pronoun', 'preposition', 'conjunction', 'sentence', 'clause', 'paragraph'],
        'science' => ['physics', 'chemistry', 'biology', 'element', 'molecule', 'organism', 'energy', 'force', 'matter', 'experiment'],
        'spanish' => ['hola', 'adios', 'gracias', 'porfavor', 'amigo', 'familia', 'casa', 'escuela', 'comida', 'tiempo'],
        'history' => ['ancient', 'medieval', 'renaissance', 'revolution', 'empire', 'democracy', 'monarchy', 'war', 'peace', 'treaty'],
        'general' => ['puzzle', 'search', 'find', 'word', 'letter', 'grid', 'horizontal', 'vertical', 'diagonal', 'reverse']
    ];
    
    return $wordLists[$subject] ?? $wordLists['general'];
}

// Function to generate word search grid
function generateWordSearch($size, $words) {
    $grid = array_fill(0, $size, array_fill(0, $size, ''));
    $placedWords = [];
    
    foreach ($words as $word) {
        $word = strtoupper($word);
        $placed = false;
        $attempts = 0;
        
        while (!$placed && $attempts < 100) {
            $direction = rand(0, 3); // 0=horizontal, 1=vertical, 2=diagonal down, 3=diagonal up
            $reverse = rand(0, 1);
            $wordToPlace = $reverse ? strrev($word) : $word;
            $length = strlen($wordToPlace);
            
            if ($direction === 0) { // horizontal
                $row = rand(0, $size - 1);
                $col = rand(0, $size - $length);
                $canPlace = true;
                
                for ($i = 0; $i < $length; $i++) {
                    if ($grid[$row][$col + $i] !== '' && $grid[$row][$col + $i] !== $wordToPlace[$i]) {
                        $canPlace = false;
                        break;
                    }
                }
                
                if ($canPlace) {
                    for ($i = 0; $i < $length; $i++) {
                        $grid[$row][$col + $i] = $wordToPlace[$i];
                    }
                    $placedWords[] = [
                        'word' => $word,
                        'start' => [$row, $col],
                        'end' => [$row, $col + $length - 1],
                        'reversed' => $reverse
                    ];
                    $placed = true;
                }
            } elseif ($direction === 1) { // vertical
                $row = rand(0, $size - $length);
                $col = rand(0, $size - 1);
                $canPlace = true;
                
                for ($i = 0; $i < $length; $i++) {
                    if ($grid[$row + $i][$col] !== '' && $grid[$row + $i][$col] !== $wordToPlace[$i]) {
                        $canPlace = false;
                        break;
                    }
                }
                
                if ($canPlace) {
                    for ($i = 0; $i < $length; $i++) {
                        $grid[$row + $i][$col] = $wordToPlace[$i];
                    }
                    $placedWords[] = [
                        'word' => $word,
                        'start' => [$row, $col],
                        'end' => [$row + $length - 1, $col],
                        'reversed' => $reverse
                    ];
                    $placed = true;
                }
            } elseif ($direction === 2) { // diagonal down
                $row = rand(0, $size - $length);
                $col = rand(0, $size - $length);
                $canPlace = true;
                
                for ($i = 0; $i < $length; $i++) {
                    if ($grid[$row + $i][$col + $i] !== '' && $grid[$row + $i][$col + $i] !== $wordToPlace[$i]) {
                        $canPlace = false;
                        break;
                    }
                }
                
                if ($canPlace) {
                    for ($i = 0; $i < $length; $i++) {
                        $grid[$row + $i][$col + $i] = $wordToPlace[$i];
                    }
                    $placedWords[] = [
                        'word' => $word,
                        'start' => [$row, $col],
                        'end' => [$row + $length - 1, $col + $length - 1],
                        'reversed' => $reverse
                    ];
                    $placed = true;
                }
            } else { // diagonal up
                $row = rand($length - 1, $size - 1);
                $col = rand(0, $size - $length);
                $canPlace = true;
                
                for ($i = 0; $i < $length; $i++) {
                    if ($grid[$row - $i][$col + $i] !== '' && $grid[$row - $i][$col + $i] !== $wordToPlace[$i]) {
                        $canPlace = false;
                        break;
                    }
                }
                
                if ($canPlace) {
                    for ($i = 0; $i < $length; $i++) {
                        $grid[$row - $i][$col + $i] = $wordToPlace[$i];
                    }
                    $placedWords[] = [
                        'word' => $word,
                        'start' => [$row, $col],
                        'end' => [$row - $length + 1, $col + $length - 1],
                        'reversed' => $reverse
                    ];
                    $placed = true;
                }
            }
            
            $attempts++;
        }
    }
    
    // Fill empty spaces with random letters
    $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i < $size; $i++) {
        for ($j = 0; $j < $size; $j++) {
            if ($grid[$i][$j] === '') {
                $grid[$i][$j] = $letters[rand(0, 25)];
            }
        }
    }
    
    return [
        'grid' => $grid,
        'words' => $placedWords,
        'wordList' => array_map(function($w) { return $w['word']; }, $placedWords)
    ];
}

// Handle puzzle completion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['found_words'])) {
    $found_words = json_decode($_POST['found_words'], true);
    $time_taken = intval($_POST['time_taken']);
    $total_words = intval($_POST['total_words']);
    $found_count = count($found_words);
    
    // Save score
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("INSERT INTO wordsearch_scores (user_id, puzzle_id, time_taken, found_words, total_words) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $puzzle_id, $time_taken, $found_count, $total_words]);
    
    // Return success response
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'found' => $found_count, 'total' => $total_words]);
    exit();
}

// Fetch or generate puzzle
if ($puzzle_id) {
    // Load existing puzzle
    $stmt = $conn->prepare("SELECT * FROM wordsearch_puzzles WHERE id = ?");
    $stmt->execute([$puzzle_id]);
    $puzzle = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$puzzle) {
        header("Location: wordsearch.php?subject=$subject");
        exit();
    }
    
    $words = json_decode($puzzle['words'], true);
    $gridData = json_decode($puzzle['grid_data'], true);
    
    $grid = [
        'grid' => $gridData,
        'words' => $words,
        'wordList' => array_map('strtoupper', $words) // Make sure wordList is uppercase
    ];
} else {
    // Generate new puzzle
    $words = getWordsBySubject($subject);
    $generatedGrid = generateWordSearch(15, $words);
    
    $grid = [
        'grid' => $generatedGrid['grid'],
        'words' => $generatedGrid['words'],
        'wordList' => array_map('strtoupper', $words) // Make sure wordList is uppercase
    ];
    
    $gridData = json_encode($grid['grid']);
    $wordsData = json_encode($words);
    
    // Save to database
    $title = ucfirst($subject) . " Word Search";
    $stmt = $conn->prepare("INSERT INTO wordsearch_puzzles (title, subject, grid_size, words, grid_data) VALUES (?, ?, ?, ?, ?)");
    $grid_size = 15;
    $stmt->execute([$title, $subject, $grid_size, $wordsData, $gridData]);
    $puzzle_id = $conn->lastInsertId();
    
    // Reload to get the full puzzle data
    header("Location: wordsearch.php?subject=$subject&id=$puzzle_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Word Search | EduPlay</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .wave-bg {
      background: linear-gradient(120deg, #f0f4ff 0%, #f4e8ff 100%);
    }
    .glass {
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .wordsearch-cell {
      width: 30px;
      height: 30px;
      display: flex;
      align-items: center;  
      justify-content: center;
      font-weight: bold;
      cursor: pointer;
      user-select: none;
    }
    .wordsearch-cell.selected {
      background-color: #93c5fd;
    }
    .wordsearch-cell.found {
      background-color: #86efac;
    }
    .word-list-item.found {
      text-decoration: line-through;
      color: #10b981;
    }
    #timer {
      font-family: monospace;
    }
  </style>
</head>

<body class="wave-bg text-gray-800 font-sans scroll-smooth min-h-screen">
  <!-- Navbar -->
  <nav class="bg-blue-700 p-5 text-white flex justify-between items-center shadow-lg fixed top-0 w-full z-50">
    <h1 class="text-3xl font-extrabold tracking-wide">EduPlay</h1>
    <div class="space-x-6 flex items-center">
      <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
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

  <main class="pt-28 pb-16 px-4 max-w-6xl mx-auto">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden glass backdrop-blur-sm">
      <!-- Puzzle header -->
      <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 text-white">
        <h1 class="text-3xl font-bold"><?= ucfirst($subject) ?> Word Search</h1>
        <div class="flex justify-between items-center mt-2">
          <p>Find all the hidden words!</p>
          <div class="flex items-center space-x-4">
            <div id="timer" class="text-xl font-mono">00:00</div>
            <div id="progress" class="text-sm">
              <span id="found-count">0</span>/<span id="total-words"><?= count($words) ?></span> words found
            </div>
          </div>
        </div>
      </div>
      
      <div class="p-6 md:p-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Word list -->
        <div class="lg:col-span-1">
          <h2 class="text-xl font-bold mb-4 text-blue-700">Words to Find</h2>
          <div class="grid grid-cols-2 gap-2">
            <?php foreach ($words as $word): ?>
              <div class="word-list-item p-2 bg-gray-100 rounded" data-word="<?= strtoupper($word) ?>">
                <?= ucfirst(strtolower($word)) ?>
              </div>
            <?php endforeach; ?>
          </div>
          
          <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <h3 class="font-semibold text-blue-800 mb-2">How to Play</h3>
            <ul class="list-disc pl-5 text-sm text-gray-700 space-y-1">
              <li>Click and drag to select letters</li>
              <li>Words can be horizontal, vertical, or diagonal</li>
              <li>Words may be forwards or backwards</li>
              <li>Find all words to complete the puzzle</li>
            </ul>
          </div>
          
          <!-- Close button to save progress and return to index -->
          <div class="mt-6">
            <button id="close-button" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg w-full flex items-center justify-center">
              <i class="fas fa-times-circle mr-2"></i> Close & Save Progress
            </button>
          </div>
        </div>
        
        <!-- Puzzle grid -->
        <div class="lg:col-span-2">
          <div class="flex justify-center">
            <div id="wordsearch-grid" class="grid gap-px bg-gray-300 p-px">
              <?php if (isset($grid['grid']) && is_array($grid['grid'])): ?>
                <?php foreach ($grid['grid'] as $rowIdx => $row): ?>
                  <div class="flex">
                    <?php foreach ($row as $colIdx => $cell): ?>
                      <div class="wordsearch-cell bg-white" data-row="<?= $rowIdx ?>" data-col="<?= $colIdx ?>">
                        <?= htmlspecialchars($cell) ?>
                      </div>
                    <?php endforeach; ?>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <div class="col-span-full text-center py-8 text-red-500">
                  Error: Puzzle grid could not be loaded
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Completion modal (hidden initially) -->
    <div id="completion-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
      <div class="bg-white rounded-xl p-8 max-w-md w-full text-center animate__animated animate__bounceIn">
        <div class="text-5xl mb-4">🎉</div>
        <h2 class="text-3xl font-bold text-blue-600 mb-2">Puzzle Complete!</h2>
        <p class="text-xl mb-4">You found all <span id="completed-total"><?= count($words) ?></span> words!</p>
        <p class="text-lg mb-6">Time: <span id="completed-time">00:00</span></p>
        <div class="flex justify-center space-x-4">
          <a href="wordsearch.php?subject=<?= $subject ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
            Play Again
          </a>
          <a href="games.php" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg">
            More Games
          </a>
          <a href="index.php" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
            Home
          </a>
        </div>
      </div>
    </div>
  </main>

  <script>
    $(document).ready(function() {
      const puzzleId = <?= $puzzle_id ?>;
      const wordList = <?= json_encode(array_map('strtoupper', $words)) ?>; // Make sure wordList is uppercase
      const gridSize = <?= count($grid['grid']) ?>;
      let selectedCells = [];
      let foundWords = [];
      let startTime = new Date();
      let timerInterval;
      
      // Start timer
      function startTimer() {
        updateTimer();
        timerInterval = setInterval(updateTimer, 1000);
      }
      
      function updateTimer() {
        const now = new Date();
        const diff = Math.floor((now - startTime) / 1000);
        const minutes = Math.floor(diff / 60).toString().padStart(2, '0');
        const seconds = (diff % 60).toString().padStart(2, '0');
        $('#timer').text(`${minutes}:${seconds}`);
      }
      
      // Word search grid interaction
      let isMouseDown = false;
      let startCell = null;
      
      $('#wordsearch-grid .wordsearch-cell')
        .on('mousedown', function(e) {
          isMouseDown = true;
          startCell = $(this);
          clearSelection();
          $(this).addClass('selected');
          selectedCells = [$(this)];
          e.preventDefault(); // Prevent text selection
        })
        .on('mouseenter', function() {
          if (isMouseDown && startCell) {
            clearSelection();
            selectCellsBetween(startCell, $(this));
          }
        });
      
      $(document)
        .on('mouseup', function() {
          if (isMouseDown) {
            isMouseDown = false;
            checkSelectedWord();
          }
        })
        .on('selectstart', function(e) {
          if (isMouseDown) e.preventDefault();
        });
      
      // Handle touch events for mobile
      $('#wordsearch-grid .wordsearch-cell')
        .on('touchstart', function(e) {
          isMouseDown = true;
          startCell = $(this);
          clearSelection();
          $(this).addClass('selected');
          selectedCells = [$(this)];
          e.preventDefault();
        })
        .on('touchmove', function(e) {
          if (isMouseDown && startCell) {
            const touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
            const element = document.elementFromPoint(touch.clientX, touch.clientY);
            if (element && $(element).hasClass('wordsearch-cell')) {
              clearSelection();
              selectCellsBetween(startCell, $(element));
            }
          }
          e.preventDefault();
        })
        .on('touchend', function(e) {
          isMouseDown = false;
          checkSelectedWord();
          e.preventDefault();
        });
      
      function clearSelection() {
        $('.wordsearch-cell').removeClass('selected');
        selectedCells = [];
      }
      
      function selectCellsBetween(cell1, cell2) {
        const row1 = parseInt(cell1.data('row'));
        const col1 = parseInt(cell1.data('col'));
        const row2 = parseInt(cell2.data('row'));
        const col2 = parseInt(cell2.data('col'));
        
        // Determine direction
        let rowStep = 0, colStep = 0;
        if (row1 === row2) {
          colStep = col2 > col1 ? 1 : -1; // horizontal
        } else if (col1 === col2) {
          rowStep = row2 > row1 ? 1 : -1; // vertical
        } else if (Math.abs(row2 - row1) === Math.abs(col2 - col1)) {
          rowStep = row2 > row1 ? 1 : -1; // diagonal
          colStep = col2 > col1 ? 1 : -1;
        } else {
          // Not a straight line - just select the cells in between randomly
          return;
        }
        
        // Select all cells in the line
        let r = row1, c = col1;
        selectedCells = [];
        
        while (true) {
          const cell = $(`.wordsearch-cell[data-row="${r}"][data-col="${c}"]`);
          if (cell.length === 0) break;
          
          cell.addClass('selected');
          selectedCells.push(cell);
          
          if (r === row2 && c === col2) break;
          
          r += rowStep;
          c += colStep;
        }
      }
      
      function checkSelectedWord() {
        if (selectedCells.length < 3) {
          clearSelection();
          return;
        }
        
        // Get the selected word
        let selectedWord = '';
        selectedCells.forEach(cell => {
          selectedWord += cell.text().trim();
        });
        
        // Check if it matches any word in the list (forward or backward)
        const matchedWord = wordList.find(word => {
          return selectedWord === word || selectedWord === word.split('').reverse().join('');
        });
        
        if (matchedWord && !foundWords.includes(matchedWord)) {
          // Mark as found
          foundWords.push(matchedWord);
          selectedCells.forEach(cell => cell.addClass('found').removeClass('selected'));
          
          // Update word list
          $(`.word-list-item[data-word="${matchedWord}"]`).addClass('found');
          
          // Update progress
          $('#found-count').text(foundWords.length);
          
          // Check if all words are found
          if (foundWords.length === wordList.length) {
            completePuzzle();
          }
        } else {
          clearSelection();
        }
      }
      
      function completePuzzle() {
        clearInterval(timerInterval);
        const now = new Date();
        const timeTaken = Math.floor((now - startTime) / 1000);
        
        // Show completion modal
        $('#completed-time').text($('#timer').text());
        $('#completion-modal').removeClass('hidden');
        
        // Save results to database
        saveScore(timeTaken, foundWords.length, wordList.length);
      }
      
      function saveScore(timeTaken, foundCount, totalWords) {
        $.ajax({
          url: window.location.href,
          method: 'POST',
          data: {
            found_words: JSON.stringify(foundWords),
            time_taken: timeTaken,
            total_words: totalWords
          },
          success: function(response) {
            console.log('Puzzle results saved', response);
          },
          error: function(xhr, status, error) {
            console.error('Error saving results:', error);
          }
        });
      }
      
      // Close button handler
      $('#close-button').on('click', function() {
        clearInterval(timerInterval);
        const now = new Date();
        const timeTaken = Math.floor((now - startTime) / 1000);
        
        // Save current progress
        saveScore(timeTaken, foundWords.length, wordList.length);
        
        // Redirect to index.php after saving
        setTimeout(function() {
          window.location.href = 'index.php';
        }, 500); // Short delay to ensure the AJAX request completes
      });
      
      // Start the timer when the page loads
      startTimer();
    });
  </script>
</body>
</html>