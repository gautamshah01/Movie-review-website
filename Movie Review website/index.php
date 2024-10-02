<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: landing.php");
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
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #22254b;
            color: #fff;
            margin: 0;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background-color: #373b69;
        }
        .search {
            background-color: transparent;
            border: 2px solid #22254b;
            border-radius: 50px;
            padding: 0.5rem 1rem;
            color: #fff;
        }
        .update-btn {
            background: #6c63ff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }
        .update-btn:hover {
            background: #5a54e2;
        }
        main {
            padding: 2rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        /* Your existing movie styles here */
    </style>
</head>
<body>
    <header>
        <form id="form">
            <input type="text" id="search" class="search" placeholder="Search" />
        </form>
        <button class="update-btn" onclick="window.location.href='modify.php'">Update Profile</button>
    </header>
    <main id="main"></main>

    <script>
        const API_URL = 'https://api.themoviedb.org/3/discover/movie?sort_by=popularity.desc&api_key=3fd2be6f0c70a2a598f084ddfb75487c&page=1';
        const IMG_PATH = 'https://image.tmdb.org/t/p/w1280';
        const SEARCH_API = 'https://api.themoviedb.org/3/search/movie?api_key=3fd2be6f0c70a2a598f084ddfb75487c&query="';

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

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const searchTerm = search.value;

            if (searchTerm && searchTerm !== '') {
                getMovies(SEARCH_API + searchTerm);
                search.value = '';
            } else {
                window.location.reload();
            }
        });
    </script>
</body>
</html>
