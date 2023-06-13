<?php

declare(strict_types=1);

namespace Entity\Collection;

use Entity\Cast;
use Database\MyPdo;

class CastCollection
{
    /**
     * find all the movie's casts using his id
     *
     * @param  int $movieId
     * @return Cast[]
     */
    public static function findByMovieId(int $movieId): array
    {
        $castRequest = MyPdo::getInstance()->prepare(
            <<<'SQL'
			SELECT id, movieId, peopleId, role, orderIndex
			FROM cast
			WHERE movieId = ?
			SQL
        );
        $castRequest->execute([$movieId]);
        $cast = $castRequest->fetchAll(\PDO::FETCH_CLASS, Cast::class);
        return $cast;
    }
}
