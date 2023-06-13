<?php

declare(strict_types=1);

use Entity\Collection\MovieCollection;
use Html\AppWebPage;

$webPage = new AppWebPage("Films");

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
