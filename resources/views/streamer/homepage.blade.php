{{-- Vista: Homepage do Streamer - Lista de filmes com pesquisa autocomplete --}}
@extends('layouts.app')

@section('content')
    <style>
        {!! file_get_contents(resource_path('views/streamer/streamer.css')) !!}
    </style>

    {{-- Barra superior com pesquisa --}}
    <div class="top-bar-box">
        <div class="top-bar">
            <div class="name-topbar"></div>
            <div class="top-bar-spacer"></div>
            {{-- Campo de pesquisa com autocomplete --}}
            <div class="search-container">
                <input
                    id="search-input"
                    type="text"
                    placeholder="Pesquisar Filmes..."
                    aria-label="Pesquisar Filmes"
                    autocomplete="off"
                />
                <div id="search-dropdown" class="search-dropdown"></div>
            </div>
        </div>
    </div>
    <div class="center-title">
        <h1>Filmes Recomendados</h1>
    </div>

    {{-- Filtros de Género e Ano --}}
    <div class="filters-container">
        <select id="genreFilter" class="filter-select">
            <option value="">Todos os Géneros</option>
        </select>
        <select id="yearFilter" class="filter-select">
            <option value="">Todos os Anos</option>
        </select>
        <button id="clearFilters" class="filter-clear-btn">Limpar Filtros</button>
    </div>

    {{-- Container onde os filmes são carregados dinamicamente --}}
    <div class="movies-container" id="moviesGrid">
        <div class="loading">A carregar filmes...</div>
    </div>

    <script>
        let searchTimeout;
        const searchInput = document.getElementById('search-input');
        const searchDropdown = document.getElementById('search-dropdown');

        // Funcionalidade de pesquisa com debounce de 300ms
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length < 1) {
                searchDropdown.classList.remove('show');
                searchDropdown.innerHTML = '';
                return;
            }
            
            searchTimeout = setTimeout(async () => {
                try {
                    // Chama API de pesquisa com query string
                    const response = await fetch(`/api/movies/search?q=${encodeURIComponent(query)}`);
                    const movies = await response.json();
                    
                    if (movies.length === 0) {
                        searchDropdown.innerHTML = '<div class="search-result-item">Nenhum filme encontrado</div>';
                        searchDropdown.classList.add('show');
                        return;
                    }
                    
                    // Constrói HTML dos resultados da pesquisa
                    const resultsHTML = movies.map(movie => {
                        const posterHTML = movie.poster_path 
                            ? `<img src="/storage/${movie.poster_path}" alt="${movie.title}" class="search-result-poster">`
                            : `<div class="search-result-poster">No Img</div>`;
                        
                        return `
                            <div class="search-result-item" onclick="window.location.href='/moviedetails?id=${movie.id}'">
                                ${posterHTML}
                                <div class="search-result-title">${movie.title}</div>
                            </div>
                        `;
                    }).join('');
                    
                    searchDropdown.innerHTML = resultsHTML;
                    searchDropdown.classList.add('show');
                    
                } catch (error) {
                    console.error('Search error:', error);
                }
            }, 300);
        });

        // Fecha dropdown ao clicar fora
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
                searchDropdown.classList.remove('show');
            }
        });

        // Variável global para armazenar todos os filmes
        let allMovies = [];

        // Carrega todos os filmes ao carregar a página
        document.addEventListener('DOMContentLoaded', async function() {
            const moviesGrid = document.getElementById('moviesGrid');
            
            try {
                // Busca lista completa de filmes da API
                const response = await fetch('/api/movies');
                
                if (!response.ok) {
                    throw new Error('Erro ao carregar filmes');
                }
                
                allMovies = await response.json();
                
                if (allMovies.length === 0) {
                    moviesGrid.innerHTML = '<div class="no-movies">Nenhum filme disponível</div>';
                    return;
                }
                
                // Carrega filtros
                await loadFilters();
                
                // Renderiza todos os filmes inicialmente
                renderMovies(allMovies);
                
            } catch (error) {
                console.error('Error:', error);
                moviesGrid.innerHTML = '<div class="error-message">Erro ao carregar filmes. Tente novamente.</div>';
            }
        });

        // Carrega opções de filtro (géneros e anos)
        async function loadFilters() {
            const genreFilter = document.getElementById('genreFilter');
            const yearFilter = document.getElementById('yearFilter');
            
            try {
                // Carrega géneros da API
                const genreResponse = await fetch('/api/genres');
                const genres = await genreResponse.json();
                
                genres.forEach(genre => {
                    const option = document.createElement('option');
                    option.value = genre.name;
                    option.textContent = genre.name;
                    genreFilter.appendChild(option);
                });
                
                // Extrai anos únicos dos filmes e ordena decrescente
                const years = [...new Set(allMovies.map(m => {
                    return m.release_date ? new Date(m.release_date).getFullYear() : null;
                }).filter(y => y !== null))].sort((a, b) => b - a);
                
                years.forEach(year => {
                    const option = document.createElement('option');
                    option.value = year;
                    option.textContent = year;
                    yearFilter.appendChild(option);
                });
                
            } catch (error) {
                console.error('Erro ao carregar filtros:', error);
            }
        }

        // Renderiza filmes no DOM
        function renderMovies(movies) {
            const moviesGrid = document.getElementById('moviesGrid');
            
            if (movies.length === 0) {
                moviesGrid.innerHTML = '<div class="no-movies">Nenhum filme encontrado com os filtros selecionados</div>';
                return;
            }
            
            // Gera HTML dos cartões de filmes
            const gridHTML = movies.map(movie => {
                const posterHTML = movie.poster_path 
                    ? `<img src="/storage/${movie.poster_path}" alt="${movie.title}">`
                    : `<div class="movie-poster-placeholder">${movie.title}</div>`;
                
                const year = movie.release_date ? new Date(movie.release_date).getFullYear() : 'N/A';
                const rating = parseFloat(movie.vote_average).toFixed(1);
                const voteAverage = parseFloat(movie.vote_average) || 0;
                
                // Cria 5 estrelas - preenchidas ou vazias baseado no rating (0-10 convertido para 0-5)
                const stars = Array.from({ length: 5 }, (_, i) => 
                    voteAverage / 2 >= i + 1 ? '★' : '☆'
                ).join('');
                
                return `
                    <div class="movie-card" onclick="window.location.href='/moviedetails?id=${movie.id}'">
                        <div class="movie-poster">
                            ${posterHTML}
                        </div>
                        <div class="movie-info">
                            <div class="movie-title">${movie.title}</div>
                            <div class="movie-meta">
                                <span class="movie-rating-stars">${stars}</span>
                                <span class="movie-rating-number">${rating}/10</span>
                            </div>
                            <div class="movie-year">${year}</div>
                            <span class="movie-genre">${movie.genre}</span>
                        </div>
                    </div>
                `;
            }).join('');
            
            moviesGrid.innerHTML = `<div class="movies-grid">${gridHTML}</div>`;
        }

        // Event listeners para os filtros
        document.getElementById('genreFilter').addEventListener('change', applyFilters);
        document.getElementById('yearFilter').addEventListener('change', applyFilters);
        document.getElementById('clearFilters').addEventListener('click', function() {
            document.getElementById('genreFilter').value = '';
            document.getElementById('yearFilter').value = '';
            renderMovies(allMovies);
        });

        // Aplica filtros selecionados
        function applyFilters() {
            const selectedGenre = document.getElementById('genreFilter').value;
            const selectedYear = document.getElementById('yearFilter').value;
            
            let filteredMovies = allMovies;
            
            // Filtra por género
            if (selectedGenre) {
                filteredMovies = filteredMovies.filter(movie => movie.genre === selectedGenre);
            }
            
            // Filtra por ano
            if (selectedYear) {
                filteredMovies = filteredMovies.filter(movie => {
                    const year = movie.release_date ? new Date(movie.release_date).getFullYear() : null;
                    return year == selectedYear;
                });
            }
            
            renderMovies(filteredMovies);
        }
    </script>
@endsection
