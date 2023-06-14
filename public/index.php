<?php

declare(strict_types=1);

use Entity\Collection\GenreCollection;
use Entity\Collection\MovieCollection;
use Entity\Genre;
use Entity\Movie;
use Exception\ParameterException;
use Html\AppWebPage;

$webPage = new AppWebPage("Films");

$webPage->appendToMenu(
    <<<HTML
        <a class="movie__add" href="admin/movie-form.php"><button>Ajouter</button></a>
    HTML
);

$webPage->appendToMenu(
    <<<HTML
        <form method="post" action="index.php">
            <select id="genre" name="genre">
                <option value="" disabled selected>Choisissez un genre</option>\n     
    HTML
);

foreach (GenreCollection::findAll() as $genre) {
    $webPage->appendToMenu(
        <<<HTML
                <option value="{$genre->getId()}">{$webPage->escapeString($genre->getName())}</option>\n
        HTML
    );
}

$webPage->appendToMenu(
    <<<HTML
            </select>
            <button type="submit">Filtrer</button>
        </form>
HTML
);

if(isset($_POST['genre'])) {
    if(!ctype_digit($_POST['genre'])) {
        throw new ParameterException('movie Id not a int');
    }
    $genreId = (int)$_POST['genre'];
    $selectGenre = Genre::findById($genreId);
    $webPage->setTitle("Films - {$selectGenre->getName()}");
    foreach (Movie::findByGenreId($genreId) as $movie) {
        $webPage->appendContent(
            <<<HTML
            <a class="movie" href="/movie.php?movieId={$movie->getId()}">
                <img class="movie__poster" src="poster.php?posterId={$movie->getPosterId()}" alt="{$movie->getTitle()}">
                <div class="movie__title">{$webPage->escapeString($movie->getTitle())}</div> 
            </a>
        HTML
        );
    }

}



foreach(MovieCollection::findAll() as $movie) {
    $webPage->appendContent(
        <<<HTML
            <a class="movie" href="/movie.php?movieId={$movie->getId()}">
                <img class="movie__poster" src="poster.php?posterId={$movie->getPosterId()}" alt="{$movie->getTitle()}">
                <div class="movie__title">{$webPage->escapeString($movie->getTitle())}</div> 
            </a>
        HTML
    );
}

echo $webPage->toHtml();
