<?php

declare(strict_types=1);

use Entity\Avatar;
use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;

try {
    if (empty($_GET['avatarId'])) {
        header('Location: img/actor.png', true, 302);
    }
    if (!ctype_digit($_GET['avatarId']) && !empty($_GET['avatarId'])) {
        throw new ParameterException('Parameter avatarId not int');
    }


} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
echo Avatar::findById((int)$_GET['avatarId'])->getJpeg();
