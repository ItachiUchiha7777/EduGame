<?php
session_start();
include_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$subject = $_GET['subject'] ?? 'math';

$questions = [
    'math' => [
        ['What is 5 + 7?', ['10', '11', '12', '13'], '12'],
        ['What is 9 × 3?', ['24', '27', '28', '30'], '27'],
        ['What is 15 - 4?', ['11', '12', '13', '14'], '11'],
        ['What is 8 × 7?', ['48', '56', '64', '72'], '56'],
        ['What is 144 ÷ 12?', ['10', '11', '12', '13'], '12'],
        ['What is 3² + 4²?', ['5', '7', '9', '25'], '25'],
        ['What is 0.5 × 100?', ['5', '50', '500', '0.005'], '50'],
        ['What is the square root of 64?', ['6', '7', '8', '9'], '8'],
        ['What is 1/4 + 1/2?', ['1/6', '2/6', '3/4', '1/3'], '3/4'],
        ['What is 30% of 90?', ['18', '27', '30', '33'], '27']
    ],
    'grammar' => [
        ['Which is a noun in this sentence: "The cat sat on the mat"?', ['cat', 'sat', 'mat', 'on'], 'cat'],
        ['Choose the correct sentence:', ['She doesn\'t like apples.', 'She don\'t like apples.', 'She doesn\'t likes apples.', 'She don\'t likes apples.'], 'She doesn\'t like apples.'],
        ['Fill in the blank: He ___ to the market.', ['goes', 'went', 'going', 'gone'], 'went'],
        ['Which word is an adjective?', ['run', 'beautiful', 'quickly', 'jump'], 'beautiful'],
        ['Identify the preposition: "The book is on the table."', ['book', 'is', 'on', 'table'], 'on'],
        ['Choose the correct plural form of "child":', ['childs', 'children', 'childes', 'childern'], 'children'],
        ['Which sentence is in passive voice?', ['The dog chased the cat.', 'The cat was chased by the dog.', 'The cat chased the dog.', 'The dog was chasing the cat.'], 'The cat was chased by the dog.'],
        ['Identify the conjunction: "I like tea and coffee."', ['I', 'like', 'and', 'coffee'], 'and'],
        ['Which is the correct comparative form of "good"?', ['gooder', 'more good', 'better', 'best'], 'better'],
        ['Choose the correct spelling:', ['Accomodate', 'Acommodate', 'Accommodate', 'Acomodate'], 'Accommodate']
    ],
    'science' => [
        ['What planet is known as the Red Planet?', ['Earth', 'Mars', 'Venus', 'Jupiter'], 'Mars'],
        ['Water boils at ___ degrees Celsius.', ['90', '95', '100', '105'], '100'],
        ['What gas do plants absorb?', ['Oxygen', 'Carbon dioxide', 'Nitrogen', 'Hydrogen'], 'Carbon dioxide'],
        ['Which is the largest organ of the human body?', ['Liver', 'Brain', 'Skin', 'Heart'], 'Skin'],
        ['What is the chemical symbol for gold?', ['Go', 'Gd', 'Au', 'Ag'], 'Au'],
        ['Which force keeps planets in orbit around the sun?', ['Electromagnetism', 'Gravity', 'Nuclear force', 'Friction'], 'Gravity'],
        ['What is the main component of the sun?', ['Liquid lava', 'Hydrogen gas', 'Oxygen gas', 'Rock'], 'Hydrogen gas'],
        ['Which of these is NOT a state of matter?', ['Solid', 'Liquid', 'Gas', 'Energy'], 'Energy'],
        ['What is the pH value of pure water?', ['5', '7', '9', '11'], '7'],
        ['Which vitamin is produced when human skin is exposed to sunlight?', ['Vitamin A', 'Vitamin B', 'Vitamin C', 'Vitamin D'], 'Vitamin D']
    ],
    'spanish' => [
        ['How do you say "hello" in Spanish?', ['Hola', 'Adiós', 'Gracias', 'Por favor'], 'Hola'],
        ['What is "gracias" in English?', ['Hello', 'Goodbye', 'Thank you', 'Please'], 'Thank you'],
        ['Which word means "friend"?', ['Familia', 'Amigo', 'Casa', 'Escuela'], 'Amigo'],
        ['How do you say "good morning"?', ['Buenas noches', 'Buenas tardes', 'Buenos días', 'Hasta luego'], 'Buenos días'],
        ['What is "rojo" in English?', ['Blue', 'Green', 'Red', 'Yellow'], 'Red'],
        ['Which is the correct translation for "I eat"?', ['Yo bebo', 'Yo como', 'Yo duermo', 'Yo corro'], 'Yo como'],
        ['How do you say "water" in Spanish?', ['Pan', 'Agua', 'Leche', 'Jugo'], 'Agua'],
        ['What is "uno, dos, tres" in English?', ['First, second, third', 'One, two, three', 'Monday, Tuesday, Wednesday', 'Red, blue, green'], 'One, two, three'],
        ['Which phrase means "How are you?"', ['¿Qué tal?', '¿Cómo estás?', '¿Cuántos años tienes?', '¿Dónde vives?'], '¿Cómo estás?'],
        ['What is "biblioteca" in English?', ['Bookstore', 'Classroom', 'Library', 'Office'], 'Library']
    ],
    'history' => [
        ['In which year did World War II end?', ['1943', '1945', '1947', '1950'], '1945'],
        ['Who was the first president of the United States?', ['Thomas Jefferson', 'John Adams', 'George Washington', 'Abraham Lincoln'], 'George Washington'],
        ['The ancient Egyptian writing system is called:', ['Cuneiform', 'Hieroglyphics', 'Sanskrit', 'Latin'], 'Hieroglyphics'],
        ['Which civilization built the Machu Picchu?', ['Aztec', 'Maya', 'Inca', 'Olmec'], 'Inca'],
        ['The Industrial Revolution began in which country?', ['France', 'Germany', 'United States', 'Great Britain'], 'Great Britain'],
        ['Who painted the Mona Lisa?', ['Michelangelo', 'Vincent van Gogh', 'Leonardo da Vinci', 'Pablo Picasso'], 'Leonardo da Vinci'],
        ['The Magna Carta was signed in which century?', ['11th', '12th', '13th', '14th'], '13th'],
        ['Which empire was ruled by Julius Caesar?', ['Greek', 'Roman', 'Ottoman', 'Persian'], 'Roman'],
        ['The first human to walk on the moon was:', ['Yuri Gagarin', 'Neil Armstrong', 'Buzz Aldrin', 'John Glenn'], 'Neil Armstrong'],
        ['The Berlin Wall fell in which year?', ['1987', '1989', '1991', '1993'], '1989']
    ]
];

$quiz = $questions[$subject] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    foreach ($quiz as $index => $q) {
        $answer = $_POST['q' . $index] ?? '';
        if ($answer === $q[2]) {
            $score++;
        }
    }

    $user_id = $_SESSION['user_id'];
    $total = count($quiz);
    $stmt = $conn->prepare("INSERT INTO scores (user_id, subject, score, total, attempted_on) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("isii", $user_id, $subject, $score, $total);
    $stmt->execute();

    echo "<div class='p-8 max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden'>
            <div class='p-8 text-center'>
                <h2 class='text-3xl font-bold text-blue-600 mb-6'>Quiz Completed!</h2>
                <div class='mb-6'>
                    <div class='text-5xl font-bold text-blue-500 mb-2'>$score/$total</div>
                    <div class='text-xl text-gray-600'>in $subject quiz</div>
                </div>
                <div class='w-full bg-gray-200 rounded-full h-4 mb-6'>
                    <div class='bg-blue-600 h-4 rounded-full' style='width: " . ($score/$total*100) . "%'></div>
                </div>
                <a href='../index.php' class='inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300'>
                    Go to Home
                </a>
            </div>
        </div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ucfirst($subject); ?> Quiz | Brainy</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto animate__animated animate__fadeIn">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
          
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 text-white">
                <h1 class="text-3xl font-bold"><?php echo ucfirst($subject); ?> Quiz</h1>
                <p class="opacity-90">Test your knowledge with these 10 questions</p>
            </div>
            
           
            <form method="post" class="p-6 md:p-8">
                <?php foreach ($quiz as $index => $q): ?>
                    <div class="mb-8 p-5 bg-gray-50 rounded-lg hover:bg-blue-50 transition duration-200">
                        <div class="flex items-start mb-3">
                            <span class="bg-blue-600 text-white font-bold rounded-full w-8 h-8 flex items-center justify-center mr-3 mt-1"><?php echo $index + 1; ?></span>
                            <label class="text-xl font-semibold text-gray-800"><?php echo $q[0]; ?></label>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 ml-11">
                            <?php foreach ($q[1] as $option): ?>
                                <label class="flex items-center space-x-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-blue-400 cursor-pointer transition duration-200">
                                    <input type="radio" name="q<?php echo $index; ?>" value="<?php echo $option; ?>" class="h-5 w-5 text-blue-600" required>
                                    <span class="text-gray-700"><?php echo $option; ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div class="text-center mt-8">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-300 transform hover:scale-105 shadow-lg">
                        Submit Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>