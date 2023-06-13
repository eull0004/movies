<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Poster extends Image
{
    /**
     * find the poster's using an poster id
     * @param int $posterId
     * @return Poster
     * @throws EntityNotFoundException if poster not found in database
     *
     */
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
