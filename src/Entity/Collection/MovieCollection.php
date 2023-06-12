<?php

declare(strict_types=1);

namespace Entity\Collection;

use Entity\Movie;
use Database\MyPdo;

class MovieCollection
{
    /**
     * This method is used to get all the movies from the database
     * It will fetch them in an array of Movie objects
     * Movie objects being defined in the by an id and name properties
     * @return Movie[]
     */
    public static function findAll(): array
    {
        $movieDataReq = MyPDO::getInstance()->prepare(
            <<<'SQL'
			SELECT id, posterId,originalTitle, overview, releaseDate, runtime, tagline, title
			FROM movie
			ORDER BY title
			SQL
        );
        $movieDataReq->execute();
        return $movieDataReq->fetchAll(\PDO::FETCH_CLASS, Movie::class);
    }
}
