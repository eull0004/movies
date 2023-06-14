<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;
use Entity\Movie;
use Html\AppWebPage;
use Html\Form\MovieForm;

try {
    $movie = null;
    if (isset($_GET["movieId"])) {
        if(!ctype_digit($_GET["movieId"])) {
            throw new ParameterException('movie Id not a int');
        }
        $movie = Movie::findById((int)$_GET["movieId"]);
    }
    $movieForm = new MovieForm($movie);

    $webPage = new AppWebPage('Ajouter/Modifier un film');
    $webPage->appendContent($movieForm->getHtmlForm("movie-save.php"));
    echo $webPage->toHtml();

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
