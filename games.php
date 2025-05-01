<?php
session_start();
$logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Center | EduPlay</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .game-card { transition: all 0.3s ease; }
        .game-card:hover { transform: translateY(-5px); }
        .active-filter { background-color: #3b82f6; color: white; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">

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

    <section class="text-center py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 text-blue-800">🎮 Game Center</h1>
            
            <div class="flex flex-wrap justify-center gap-2 mb-8" id="filter-buttons">
                <button class="filter-btn px-4 py-2 rounded-full border border-blue-500 text-blue-600 hover:bg-blue-100 active-filter" data-filter="all">All Games</button>
                <button class="filter-btn px-4 py-2 rounded-full border border-blue-500 text-blue-600 hover:bg-blue-100" data-filter="math">Math</button>
                <button class="filter-btn px-4 py-2 rounded-full border border-blue-500 text-blue-600 hover:bg-blue-100" data-filter="science">Science</button>
                <button class="filter-btn px-4 py-2 rounded-full border border-blue-500 text-blue-600 hover:bg-blue-100" data-filter="grammar">Grammar</button>
                <button class="filter-btn px-4 py-2 rounded-full border border-blue-500 text-blue-600 hover:bg-blue-100" data-filter="spanish">Spanish</button>
                <button class="filter-btn px-4 py-2 rounded-full border border-blue-500 text-blue-600 hover:bg-blue-100" data-filter="history">History</button>
                <button class="filter-btn px-4 py-2 rounded-full border border-blue-500 text-blue-600 hover:bg-blue-100" data-filter="puzzle">Puzzles</button>
            </div>
            
            <div class="relative w-full max-w-md mx-auto mb-8">
                <input type="text" id="search-input" placeholder="Search games..." 
                             class="w-full pl-10 pr-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500 shadow-sm">
                <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
            </div>
        </div>
    </section>

    <section class="px-6 py-8 max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-bold mb-4 sm:mb-0">
                <i class="fas fa-gamepad text-blue-500 mr-2"></i> All Games
            </h2>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600">Sort by:</span>
                <select id="sort-select" class="bg-white border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="popular">Popularity</option>
                    <option value="newest">Newest</option>
                    <option value="xp-high">XP (High to Low)</option>
                    <option value="xp-low">XP (Low to High)</option>
                </select>
            </div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="games-container">
        </div>
        
        <div id="no-results" class="text-center py-12 hidden">
            <i class="fas fa-gamepad text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-medium text-gray-500">No games found</h3>
            <p class="text-gray-400">Try adjusting your search or filters</p>
        </div>
    </section>

    <script>
        const games = [
            {
                id: 1,
                title: "Math Marathon",
                subject: "math",
                description: "Race against time to solve math problems and climb the leaderboard!",
                image: "https://img.freepik.com/free-vector/math-teacher-concept-illustration_114360-7400.jpg",
                xp: 50,
                isNew: true,
                rating: 4.5,
                dateAdded: "2023-10-15",
                type: "quiz"
            },
            {
                id: 2,
                title: "Spanish Explorer",
                subject: "spanish",
                description: "Learn vocabulary, verbs and culture through interactive games!",
                image: "https://img.freepik.com/free-vector/hand-drawn-spanish-symbols-illustration_23-2149234999.jpg",
                xp: 30,
                isPopular: true,
                rating: 4.2,
                dateAdded: "2023-11-20",
                type: "quiz"
            },
            {
                id: 3,
                title: "Grammar Master",
                subject: "grammar",
                description: "Test your language skills with timed challenges and grammar puzzles",
                image: "https://img.freepik.com/free-vector/english-grammar-book-concept-illustration_114360-7342.jpg",
                xp: 25,
                rating: 3.8,
                dateAdded: "2023-11-05",
                type: "quiz"
            },
            {
                id: 4,
                title: "Science Lab",
                subject: "science",
                description: "Conduct virtual experiments and answer science questions",
                image: "https://img.freepik.com/free-vector/science-subject-concept-illustration_114360-7319.jpg",
                xp: 35,
                isNew: true,
                rating: 4.2,
                dateAdded: "2023-11-10",
                type: "quiz"
            },
            {
                id: 5,
                title: "Time Traveler",
                subject: "history",
                description: "Answer historical questions from different eras and civilizations",
                image: "https://img.freepik.com/free-vector/history-concept-illustration_114360-1271.jpg",
                xp: 20,
                rating: 3.5,
                dateAdded: "2023-08-15",
                type: "quiz"
            },
            {
                id: 6,
                title: "Math Puzzles",
                subject: "math",
                description: "Solve visual math puzzles against the clock",
                image: "https://img.freepik.com/free-vector/math-teacher-concept-illustration_114360-7400.jpg",
                xp: 40,
                rating: 4.7,
                dateAdded: "2023-07-22",
                type: "quiz"
            },
            {
                id: 7,
                title: "Spanish Vocabulary",
                subject: "spanish",
                description: "Build your Spanish word bank with fun challenges",
                image: "https://img.freepik.com/free-vector/hand-drawn-spanish-symbols-illustration_23-2149234999.jpg",
                xp: 25,
                isNew: true,
                rating: 4.0,
                dateAdded: "2023-11-25",
                type: "quiz"
            },
            {
                id: 8,
                title: "Verb Conjugation",
                subject: "spanish",
                description: "Master Spanish verb forms through interactive exercises",
                image: "https://img.freepik.com/free-vector/hand-drawn-spanish-symbols-illustration_23-2149234999.jpg",
                xp: 35,
                rating: 3.9,
                dateAdded: "2023-10-05",
                type: "quiz"
            },
            // Word Search Puzzles
            {
                id: 9,
                title: "Math Word Search",
                subject: "math",
                description: "Find hidden math terms in this challenging puzzle",
                image: "https://img.freepik.com/free-vector/math-teacher-concept-illustration_114360-7400.jpg",
                xp: 30,
                isNew: true,
                rating: 4.3,
                dateAdded: "2023-12-01",
                type: "puzzle"
            },
            {
                id: 10,
                title: "Grammar Word Search",
                subject: "grammar",
                description: "Search for grammar terms in this word puzzle",
                image: "https://img.freepik.com/free-vector/english-grammar-book-concept-illustration_114360-7342.jpg",
                xp: 25,
                rating: 4.1,
                dateAdded: "2023-11-28",
                type: "puzzle"
            },
            {
                id: 11,
                title: "Spanish Word Search",
                subject: "spanish",
                description: "Find Spanish vocabulary words in the grid",
                image: "https://img.freepik.com/free-vector/hand-drawn-spanish-symbols-illustration_23-2149234999.jpg",
                xp: 35,
                isPopular: true,
                rating: 4.5,
                dateAdded: "2023-11-15",
                type: "puzzle"
            },
            {
                id: 12,
                title: "History Word Search",
                subject: "history",
                description: "Discover historical terms in this educational puzzle",
                image: "https://img.freepik.com/free-vector/history-concept-illustration_114360-1271.jpg",
                xp: 20,
                rating: 3.8,
                dateAdded: "2023-11-10",
                type: "puzzle"
            }
        ];

        const gamesContainer = document.getElementById('games-container');
        const filterButtons = document.querySelectorAll('.filter-btn');
        const searchInput = document.getElementById('search-input');
        const sortSelect = document.getElementById('sort-select');
        const noResults = document.getElementById('no-results');

        renderGames(games);

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => btn.classList.remove('active-filter'));
                button.classList.add('active-filter');
                const filter = button.dataset.filter;
                filterGames(filter);
            });
        });

        searchInput.addEventListener('input', () => {
            filterGames(document.querySelector('.filter-btn.active-filter').dataset.filter);
        });

        sortSelect.addEventListener('change', () => {
            filterGames(document.querySelector('.filter-btn.active-filter').dataset.filter);
        });

        function filterGames(filter) {
            let filteredGames = [...games];
            
            if (filter === 'puzzle') {
                filteredGames = filteredGames.filter(game => game.type === 'puzzle');
            } else if (filter !== 'all') {
                filteredGames = filteredGames.filter(game => game.subject === filter);
            }
            
            const searchTerm = searchInput.value.toLowerCase();
            if (searchTerm) {
                filteredGames = filteredGames.filter(game => 
                    game.title.toLowerCase().includes(searchTerm) || 
                    game.description.toLowerCase().includes(searchTerm)
                );
            }
            
            const sortOption = sortSelect.value;
            switch (sortOption) {
                case 'newest':
                    filteredGames.sort((a, b) => new Date(b.dateAdded) - new Date(a.dateAdded));
                    break;
                case 'xp-high':
                    filteredGames.sort((a, b) => b.xp - a.xp);
                    break;
                case 'xp-low':
                    filteredGames.sort((a, b) => a.xp - b.xp);
                    break;
                case 'popular':
                default:
                    filteredGames.sort((a, b) => b.rating - a.rating);
            }
            
            renderGames(filteredGames);
            noResults.classList.toggle('hidden', filteredGames.length > 0);
        }

        function renderGames(gamesToRender) {
            gamesContainer.innerHTML = '';
            gamesToRender.forEach(game => {
                const gameCard = document.createElement('div');
                gameCard.className = 'game-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg';
                
                // Determine the play link based on game type
                const playLink = game.type === 'puzzle' 
                    ? `wordsearch.php?subject=${game.subject}&id=${game.id}`
                    : `games/quiz.php?subject=${game.subject}&game=${game.id}`;
                
                gameCard.innerHTML = `
                    <div class="relative">
                        <img src="${game.image}" alt="${game.title}" class="w-full h-40 object-cover">
                        ${game.isNew ? '<div class="absolute top-2 right-2 bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded-full">NEW</div>' : ''}
                        ${game.isPopular ? '<div class="absolute top-2 right-2 bg-purple-500 text-white text-xs font-bold px-2 py-1 rounded-full">POPULAR</div>' : ''}
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-1">
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">${game.subject.charAt(0).toUpperCase() + game.subject.slice(1)}</span>
                            <span class="text-xs font-medium text-gray-600">+${game.xp} XP</span>
                        </div>
                        <h3 class="font-bold text-lg mb-2">${game.title}</h3>
                        <p class="text-gray-600 text-sm mb-3">${game.description}</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center text-yellow-500 text-sm">
                                ${renderStars(game.rating)}
                                <span class="text-gray-500 ml-1">(${game.rating.toFixed(1)})</span>
                            </div>
                            <a href="${playLink}" 
                                 class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                                Play
                            </a>
                        </div>
                    </div>
                `;
                gamesContainer.appendChild(gameCard);
            });
        }

        function renderStars(rating) {
            const fullStars = Math.floor(rating);
            const hasHalfStar = rating % 1 >= 0.5;
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= fullStars) {
                    stars += '<i class="fas fa-star"></i>';
                } else if (i === fullStars + 1 && hasHalfStar) {
                    stars += '<i class="fas fa-star-half-alt"></i>';
                } else {
                    stars += '<i class="far fa-star"></i>';
                }
            }
            return stars;
        }
    </script>

</body>
</html>