<?php

declare(strict_types=1);

use Entity\Cast;
use Entity\People;
use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;

if (!isset($_GET["peopleId"]) || !ctype_digit($_GET["peopleId"])) {
    header('Location: /movie.php', true, 302);
    exit();
}

$peopleId = (int)$_GET["peopleId"];

$webPage = new AppWebPage();

try {
    $actor = People::findById($peopleId);

} catch (EntityNotFoundException $e) {
    http_response_code(404);
    echo $e->getMessage();
}

$webPage->setTitle("Films - {$actor->getName()}");

$webPage->appendContent(
    <<<HTML
    <section class="actor__info">
		<div class="actor__info__avatar">
			<img class="actor__avatar" src="poster.php?posterId={$actor->getAvatarId()}" alt="{$actor->getName()}">
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

/** boucle foreach sur les films d'un acteur */
/** Afficher son role dans le film */
echo $webPage->toHtml();
