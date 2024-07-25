const baseUrl = "http://localhost/public_html/movie.app";
// TMDB API...
export const loadMovie  = async ()=> {
    let insertHtmlData = document.getElementById('trending-movie-container');
    try {
        const response = await fetch(`${baseUrl}/app/api/popular.php`);

        if (response.status === 200) {
            const data = await response.json();
            let movies = '';
            let countNum = 1;
            const limitResults = data.results.splice(0, 20);
            limitResults.forEach(movie => {
                let countNumResult = countNum++;
                movies += `
                <div class="trending-movie">
                    <span class="trending-movie-num">#${countNumResult}</span>
                    <img title="${movie.title}" class="trending-movie-img" src="https://image.tmdb.org/t/p/w500/${movie.poster_path}" alt="${movie.title}">
                    <h5>${movie.title}</h5>
                </div>
                `;
            });

            if (insertHtmlData !== null) {
                insertHtmlData.innerHTML = movies;
                // Count the amount of movie...
                const movieCount = document.querySelectorAll('.trending-movie');
                document.getElementById('movieCount').innerHTML = `Top ${movieCount.length} trending movies`;
            }
            
        } else if (response.status === 401) {
            console.error('ERROR:: 401');
        } else if (response.status === 404){
            console.error('ERROR:: 404');
        }else{
            console.error('ERROR::');
        }

    } catch (error) {
        console.error(error);
    }
};

// Show movie by trending rated.
export const loadTrendingMovie  = async ()=> {
    let insertHtmlData = document.getElementById('movie-trending');
    try {
        const response = await fetch(`${baseUrl}/app/api/popular.php`);

        if (response.status === 200) {
            const data = await response.json();
            let movies = '';
            const limitResults = data.results.splice(0, 20);
            limitResults.forEach(movie => {
                movies += `
                <div class="movie-inner">
                    <img title="${movie.title}" class="movie-img" src="https://image.tmdb.org/t/p/w500/${movie.poster_path}" alt="${movie.title}">
                    <h5>${movie.title}</h5>
                </div>
                `;
            });
            if (insertHtmlData !== null) {insertHtmlData.innerHTML = movies;}
            
        } else if (response.status === 401) {
            console.error('ERROR:: 401');
        } else if (response.status === 404){
            console.error('ERROR:: 404');
        }else{
            console.error('ERROR::');
        }

    } catch (error) {
        console.error(error);
    }
};

// Show movie by best rated.
export const loadToRatedMovie  = async ()=> {
    let insertHtmlData = document.getElementById('movie-topRated');
    try {
        const response = await fetch(`${baseUrl}/app/api/top_rated.php`);

        if (response.status === 200) {
            const data = await response.json();
            let movies = '';
            const limitResults = data.results.splice(0, 20);
            limitResults.forEach(movie => {
                movies += `
                <div class="movie-inner">
                    <img title="${movie.title}" class="movie-img" src="https://image.tmdb.org/t/p/w500/${movie.poster_path}" alt="${movie.title}">
                    <h5>${movie.title}</h5>
                </div>
                `;
            });
            if (insertHtmlData !== null) {insertHtmlData.innerHTML = movies;}
            
        } else if (response.status === 401) {
            console.error('ERROR:: 401');
        } else if (response.status === 404){
            console.error('ERROR:: 404');
        }else{
            console.error('ERROR::');
        }

    } catch (error) {
        console.error(error);
    }
};

// show new upcoming movie.
export const loadUpcomingMovie  = async ()=> {
    let insertHtmlData = document.getElementById('movie-upcoming');
    try {
        const response = await fetch(`${baseUrl}/app/api/upcoming.php`);

        // Verificar que la respuesta sea JSON
        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
            console.error("Error: La respuesta no es JSON");
            const text = await response.text();
            console.error(text);
            return;
        }

        if (response.status === 200) {
            const data = await response.json();
            let movies = '';
            const limitResults = data.results.splice(0, 20);
            limitResults.forEach(movie => {
                movies += `
                <div class="movie-inner">
                    <img title="${movie.title}" class="movie-img" src="https://image.tmdb.org/t/p/w500/${movie.poster_path}" alt="${movie.title}">
                    <h5>${movie.title}</h5>
                </div>
                `;
            });
            if (insertHtmlData !== null) {insertHtmlData.innerHTML = movies;}
            
        } else if (response.status === 401) {
            console.error('ERROR:: 401');
        } else if (response.status === 404){
            console.error('ERROR:: 404');
        }else{
            console.error('ERROR::');
        }

    } catch (error) {
        console.error(error);
    }
};