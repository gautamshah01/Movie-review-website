<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Movie App</title>
</head>
<body>
    <header>
        <div class="header-left">
            <h1>Movies Overview & Ratings App</h1>
        </div>
        <div class="header-right">
            <p>Hello, <?php echo $_SESSION['username']; ?>!</p>
            <button onclick="window.location.href='manage_account.php'">Manage Account</button>
        </div>
    </header>

    <form id="form">
        <input type="text" id="search" class="search" placeholder="Search for a movie..." />
        <button type="submit">Search</button>
    </form>

    <main id="main"></main>

    <script>
        const API_URL = 'https://api.themoviedb.org/3/discover/movie?sort_by=popularity.desc&api_key=3fd2be6f0c70a2a598f084ddfb75487c&page=1';
        const IMG_PATH = 'https://image.tmdb.org/t/p/w1280';
        const SEARCH_API = 'https://api.themoviedb.org/3/search/movie?api_key=3fd2be6f0c70a2a598f084ddfb75487c&query=';

        const main = document.getElementById('main');
        const form = document.getElementById('form');
        const search = document.getElementById('search');

        // Get initial movies
        getMovies(API_URL);

        async function getMovies(url) {
            const res = await fetch(url);
            const data = await res.json();
            showMovies(data.results);
        }

        function showMovies(movies) {
            main.innerHTML = '';

            movies.forEach((movie) => {
                const { title, poster_path, vote_average, overview } = movie;

                const movieEl = document.createElement('div');
                movieEl.classList.add('movie');

                movieEl.innerHTML = `
                    <img src="${IMG_PATH + poster_path}" alt="${title}">
                    <div class="movie-info">
                        <h3>${title}</h3>
                        <span class="${getClassByRate(vote_average)}">${vote_average}</span>
                    </div>
                    <div class="overview">
                        <h3>Overview</h3>
                        ${overview}
                    </div>
                `;
                main.appendChild(movieEl);
            });
        }

        function getClassByRate(vote) {
            if (vote >= 8) {
                return 'green';
            } else if (vote >= 5) {
                return 'orange';
            } else {
                return 'red';
            }
        }

        // Add event listener for form submission
        form.addEventListener('submit', (e) => {
            e.preventDefault(); // Prevent the default form submission behavior

            const searchTerm = search.value;

            if (searchTerm && searchTerm !== '') {
                getMovies(SEARCH_API + encodeURIComponent(searchTerm)); // Ensure the search term is properly encoded
                search.value = ''; // Clear the search input
            } else {
                window.location.reload(); // Reload the page if no search term is provided
            }
        });
    </script>
</body>
</html>
