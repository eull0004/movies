<?php

declare(strict_types=1);

use Entity\Poster;
use Entity\Exception\EntityNotFoundException;

if (!Poster::findById((int)$_GET['posterId'])) {
    echo "img\movie.png";
} else {
    $poster = Poster::findById((int)$_GET['posterId']);
    echo $poster->getJpeg();
}
