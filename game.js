const game = document.querySelector('.game');
let arrFactory = [];
let arrTree = [];
let newFactory;
let interval = 500; // Initial interval (factory generation speed)
let level = 1; // Starting level
let timerStart;
let timerEnd;
let elapsedTime;
let gameActive = false; // Flag to track if the game is active

// Function to start the game
function startGame() {
    const init = document.querySelector('.init');
    init.style.animation = 'start .5s ease-in';
    init.style.top = '100%';

    // Reset gameActive flag
    gameActive = true;

    // Start the timer when the game begins
    timerStart = performance.now();
    newFactory = setInterval(randomFactory, interval); // Generate factories at the defined interval
}

// Function to create the game grid
function createGame() {
    const a = document.querySelector('.game');
    // Create 30 boxes (cells) for the game grid
    for (let i = 0; i < 30; i++) {
        const b = document.createElement('div');
        b.classList.add('box');
        b.setAttribute('data-value', i);
        a.appendChild(b);
    }

    // After all boxes are created, attach event listeners to them
    const boxes = document.querySelectorAll('.box');
    boxes.forEach(function (box) {
        // Add the click event listener to each box for planting trees
        box.addEventListener('click', addTree);
    });
}

// Function to track the tree planting and check for winning condition
function addTree(e) {
    let c = e.target;

    // Prevent adding the tree to the same square twice
    if (arrTree.indexOf(c.dataset.value) === -1) {
        arrTree.push(c.dataset.value);
        c.classList.remove('red');
        c.classList.remove('factory');
        c.classList.add('green');
        c.classList.add('tree');
    }

    // If all trees are planted, the level is completed
    if (arrTree.length === 30) {
        clearInterval(newFactory);
        timerEnd = performance.now(); // Stop the timer
        elapsedTime = ((timerEnd - timerStart) / 1000).toFixed(2); // Time in seconds

        // Update time taken in the UI
        document.getElementById('time').textContent = elapsedTime + ' seconds';

        // Mark the game as inactive (level won)
        gameActive = false;

        // Submit the score for the completed level
        submitGameScore(level, elapsedTime);

        // Increment level and proceed to the next one
        updateLevel();

        // Start the next level
        replay(); 
    }
}

// Function to generate random factories
function randomFactory() {
    let e = Math.random() * 30;
    let g = Math.floor(e);

    const boxes = document.querySelectorAll('.box');

    // Only add a factory if it's not already a factory or a tree
    if (arrFactory.indexOf(boxes[g].dataset.value) === -1 && arrTree.indexOf(boxes[g].dataset.value) === -1) {
        arrFactory.push(boxes[g].dataset.value);
        boxes[g].classList.add('red');
        boxes[g].classList.remove('green');
        boxes[g].classList.add('factory');
    }

    // Check if all boxes have turned into factories and player hasn't finished
    if (arrFactory.length === 30 && arrTree.length !== 30) {
        gameOver();
    }
}

// Function to update level and display the level-up message
function updateLevel() {
    level++;
    interval = Math.max(400, interval - 50); // Reduce the interval by 50ms each level, but don't go below 400ms
    document.querySelector('.counter').innerHTML = 'Level: ' + level;

    // Show level-up message
    let levelUpMessage = document.getElementById('level-up-message');
    levelUpMessage.textContent = `Level ${level} - Increased Velocity!`;

    // Hide level-up message after a short duration (1.5s)
    setTimeout(() => {
        levelUpMessage.textContent = '';
    }, 1500);
}

// Function to display the "YOU LOST!" message
function gameOver() {
    clearInterval(newFactory); // Stop the factory generation
    timerEnd = performance.now(); // Stop the timer
    elapsedTime = ((timerEnd - timerStart) / 1000).toFixed(2); // Time in seconds

    // Mark the game as inactive (lost)
    gameActive = false;

    // Display the "YOU LOST!" message
    let lostMessage = document.querySelector('.lost');
    lostMessage.style.animation = 'won .6s ease-in-out';
    lostMessage.style.top = '30%';

    // Show the elapsed time
    document.getElementById('time').textContent = 'Time: ' + elapsedTime + ' seconds';

    // Fetch the leaderboard one last time
    fetchLeaderboard();
}

// Function to submit the game score to the server
function submitGameScore(level, time) {
    const userId = document.getElementById('userId').dataset.userId;

    const formData = new FormData();
    formData.append('user_id', userId);
    formData.append('level', level);
    formData.append('time', time);

    fetch('submit_score.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log('Game score submitted successfully');
                fetchLeaderboard(); // Fetch and display leaderboard after score submission
            } else {
                console.log('Failed to submit game score', data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Function to fetch leaderboard data and display it
function fetchLeaderboard() {
    fetch('leaderboard.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            document.querySelector('.leaderboard-container').innerHTML = data;
        })
        .catch(error => {
            console.error('Error fetching leaderboard:', error);
        });
}

// Function to replay the game
function replay() {
    arrFactory = [];
    arrTree = [];
    const boxes = document.querySelectorAll('.box');
    boxes.forEach(function (box) {
        box.classList.remove('green');
        box.classList.remove('tree');
        box.classList.remove('red');
        box.classList.remove('factory');
    });

    // Reset the level-up animation
    document.querySelector('.hidden').classList.add('levelUp');

    let bang = document.querySelector('.won');
    bang.style.animation = 'start .6s ease-in-out';
    bang.style.top = '100%';

    // Start the next level
    setTimeout(startGame, 1000); // Delay before starting the next level
}

// Add event listener for the start button
var startButton = document.querySelector('.floating');
startButton.addEventListener('click', startGame);

function tryAgain() {
    location.reload();  // Reloads the current page
}

// Initial game setup
createGame();
