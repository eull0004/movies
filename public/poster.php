<?php

declare(strict_types=1);

use Entity\Poster;
use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;

try {
    if (empty($_GET['posterId'])) {
        header('Location: img/movie.png', true, 302);
    }
    if (!ctype_digit($_GET['posterId']) && !empty($_GET['posterId'])) {
        throw new ParameterException('Parameter posterId not int');
    }


} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
echo Poster::findById((int)$_GET['posterId'])->getJpeg();
