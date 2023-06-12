<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Poster extends Image
{
    public static function findById(int $posterId): Poster
    {
        $posterRequest = MyPdo::getInstance()->prepare(
            <<<'SQL'
			SELECT id, jpeg 
			FROM image
			WHERE id = ?
			SQL
        );
        $posterRequest->execute([$posterId]);
        $poster = $posterRequest->fetchObject(Poster::class);
        if (!$poster) {
            throw new EntityNotFoundException('Poster not found');
        }
        return $poster;
    }
}
