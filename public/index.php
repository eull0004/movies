<?php

declare(strict_types=1);

use Entity\Collection\MovieCollection;
use Html\AppWebPage;

$webPage = new AppWebPage("Films");

foreach(MovieCollection::findAll() as $movie) {
    $webPage->appendContent(
        <<<HTML
            <a class="movie" href="/movie.php?movieId={$movie->getId()}">
                <img class="movie__poster" src="image.php?posterId={$movie->getPosterId()}">
                <div class="movie__title">{$movie->getTitle()}</div> 
            </a>
        HTML
    );
}

echo $webPage->toHtml();
