<?php

declare(strict_types=1);

namespace Entity\Collection;

use Entity\Genre;
use Database\MyPdo;

class GenreCollection
{
    /**
     * find all the movie's genres in the database
     *
     * @return Genre[]
     */
    public static function findAll(): array
    {
        $genreRequest = MyPdo::getInstance()->prepare(
            <<<'SQL'
			SELECT id, name
			FROM genre
			SQL
        );
        $genreRequest->execute();
        return $genreRequest->fetchAll(\PDO::FETCH_CLASS, Genre::class);
    }
}
