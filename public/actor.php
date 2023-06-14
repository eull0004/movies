<?php

declare(strict_types=1);


use Entity\People;
use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;
use Entity\Collection\MovieCollection;
use Exception\ParameterException;

if (!isset($_GET["peopleId"]) || !ctype_digit($_GET["peopleId"])) {
    header('Location: /movie.php', true, 302);
    exit();
}

$peopleId = (int)$_GET["peopleId"];

$webPage = new AppWebPage();

try {
    $actor = People::findById($peopleId);
    $movies = MovieCollection::findAllByPeopleId($peopleId);

} catch (ParameterException) {
    http_response_code(400);
    exit();
} catch (EntityNotFoundException) {
    http_response_code(404);
    exit();
} catch (Exception) {
    http_response_code(500);
    exit();
}

$webPage->setTitle("Films - {$webPage->escapeString($actor->getName())}");

$webPage->appendContent(
    <<<HTML
    <section class="actor__info">
		<div class="actor__info__avatar">
			<img class="actor__avatar" src="poster.php?posterId={$actor->getAvatarId()}" alt="{$webPage->escapeString($actor->getName())}">
		</div>
		<div class="actor__info__definition">
			<div class="actor__name">
				{$webPage->escapeString($actor->getName())}
			</div>
			<div class="actor__birthplace">
				{$webPage->escapeString($actor->getPlaceOfBirth())}
			</div>
			<div class="actor__related__date">
				<div class="actor__birth__date">
					{$webPage->escapeString($actor->getBirthday())}
				</div>
				<div class="actor__death__date">
					{$webPage->escapeString($actor->getDeathday())}
				</div>
			</div>
			<div class="actor__biography">
				{$webPage->escapeString($actor->getBiography())}
			</div>
		</div>
    </section>\n
HTML
);

$webPage->appendContent("<section class='actor__movies__info'>");

foreach ($movies as $movie) {
    $cast = $actor->getCastByMovieId($movie->getId());
    $webPage->appendContent(
        <<<HTML
		<a class="movie" href="/movie.php?movieId={$movie->getId()}">
			<div class="actor__movie__info">
				<div class="actor__movie__poster">
					<img class="movie__poster" src="poster.php?posterId={$movie->getPosterId()}" alt="{$movie->getTitle()}">
				</div>
				<div class="actor__movie__title__and__date">
					<div class="actor__movie__title">{$webPage->escapeString($movie->getTitle())}</div>
					<div class="actor__movie__date">{$webPage->escapeString($movie->getReleaseDate())}</div>
				</div>
				<div class="actor__movie__role">{$webPage->escapeString($cast->getRole())}</div>
			</div>
		</a>\n
	HTML
    );
}

$webPage->appendContent("</section>");


echo $webPage->toHtml();
