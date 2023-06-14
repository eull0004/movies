<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Movie;
use Exception\ParameterException;

try {
    $movieId = null;
    if (isset($_GET["movieId"])) {
        $movieId = (int)$_GET["movieId"];
        if(!ctype_digit($_GET["movieId"])) {
            throw new ParameterException('movidId not a int');
        }
        $movie = Movie::findById($movieId);
        $movie->delete();
        header('Location: /index.php');
        exit();
    }



} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
