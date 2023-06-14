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
    exit();
}

$webPage->setTitle("Films - {$movie->getTitle()}");

$webPage->appendContent(
    <<<HTML
    <div class="movie__info">
        <img class="movie__poster" src="poster.php?posterId={$movie->getPosterId()}" alt="{$movie->getTitle()}">
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

$webPage->appendToMenu(
    <<<HTML
        <a class="movie__modify" href="admin/movie-form.php?movieId={$movieId}"><button>Modifier</button></a>
        <a class="movie__delete" href="admin/movie-delete.php?movieId={$movieId}"><button>Supprimer</button></a>
        <a class="back__menu" href="/index.php"><button>Menu</button></a>
HTML
);

$webPage->appendContent("<section class='casts__info'>");

foreach(CastCollection::findByMovieId($movieId) as $cast) {
    $people = $cast->getPeople();
    $webPage->appendContent(
        <<<HTML
		<div class="cast">
			<a class="cast__link" href="/actor.php?peopleId={$people->getId()}">
				<img class="cast__avatar" src="avatar.php?avatarId={$people->getAvatarId()}" alt="{$people->getName()}">
				<div class="cast__info">
					<div class="cast__role">{$webPage->escapeString($cast->getRole())}</div> 
					<div class="cast__name">{$webPage->escapeString($people->getName())}</div>
				</div>
			</a>
		</div>\n
		HTML
    );
}

$webPage->appendContent("</section>");

echo $webPage->toHTML();
