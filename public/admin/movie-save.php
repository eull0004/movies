<?php

declare(strict_types=1);

use Html\Form\MovieForm;
use Exception\ParameterException;

try {
    if(!isset($_POST["originalLanguage"])) {
        throw new ParameterException("Original Language is missing");
    }

    if(!isset($_POST["originalTitle"])) {
        throw new ParameterException("Original Title is missing");
    }

    if(!isset($_POST["overview"])) {
        throw new ParameterException("Overview is missing");
    }

    if(!isset($_POST["releaseDate"])) {
        throw new ParameterException("Release Date is missing");
    }

    if(!isset($_POST["runtime"])) {
        throw new ParameterException("Runtime is missing");
    }

    if(!isset($_POST["tagline"])) {
        throw new ParameterException("Tagline is missing");
    }

    if(!isset($_POST["title"])) {
        throw new ParameterException("Title is missing");
    }
    $movieForm = new MovieForm();
    $movieForm->setEntityFromQueryString();
    $movieForm->getMovie()->save();
    header('Location: /index.php', true, 302);
    exit();

} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);

}
