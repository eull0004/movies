<?php

declare(strict_types=1);

use Entity\Movie;
use Entity\Exception\EntityNotFoundException;
use Entity\People;
use Html\AppWebPage;
use Entity\Collection\CastCollection;

if (!isset($_GET["movieId"]) || !ctype_digit($_GET["movieId"])) {
    header('Location: /index.php', true, 302);
    exit();
}

$movieId = (int)$_GET["movieId"];

$webPage = new AppWebPage();

try {
    $movie = Movie::findById($movieId);

} catch (EntityNotFoundException $e) {
    http_response_code(404);
    echo $e->getMessage();
}

$webPage->setTitle("Films - {$movie->getTitle()}");

$webPage->appendContent(
    <<<HTML
    <div class="movie__info">
        <img class="movie__poster" src="image.php?posterId={$movie->getPosterId()}">
        <div class="movie__text">
            <div class="main__text">{$webPage->escapeString($movie->getTitle())} {$movie->getReleaseDate()}</div>
            <div class="second__text">
                <p>{$webPage->escapeString($movie->getOriginalTitle())}</p>
                <p>{$webPage->escapeString($movie->getTagline())}</p>
                <p>{$webPage->escapeString($movie->getOverview())}</p>
            </div>
        </div>
    </div>\n
HTML
);

$webPage->appendContent("<li class='cast'>");

foreach(CastCollection::findByMovieId($movieId) as $actors) {
    $people = People::findById($actors->getPeopleId());
    $webPage->appendContent(
        <<<HTML
        <ul class="actor">
            <img class="actor__avatar" src="image.php?avatarId={$people->getAvatarId()}" alt="{$people->getName()}">
            <div class="actor__info">
                <div class="actor__role">{$webPage->escapeString($actors->getRole())}</div> 
                <div class="actor__name">{$webPage->escapeString($people->getName())}</div>
            </div>
        </ul>\n
        HTML
    );
}

$webPage->appendContent("</li>");

echo $webPage->toHTML();
