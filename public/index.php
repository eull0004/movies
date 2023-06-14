<?php

declare(strict_types=1);

use Entity\Collection\MovieCollection;
use Html\AppWebPage;

$webPage = new AppWebPage("Films");

$webPage->appendToMenu(
    <<<HTML
        <a class="movie__add" href="admin/movie-form.php?movieId="><button>Ajouter</button></a>
    HTML

);

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
