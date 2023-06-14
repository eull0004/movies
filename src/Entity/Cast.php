<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use Entity\Movie;
use Entity\People;

class Cast
{
    private int $id;
    private int $movieId;
    private int $peopleId;
    private string $role;
    private int $orderIndex;



    public function getId(): int
    {
        return $this->id;
    }


    public function getMovieId(): int
    {
        return $this->movieId;
    }


    public function getPeopleId(): int
    {
        return $this->peopleId;
    }


    public function getRole(): string
    {
        return $this->role;
    }


    public function getOrderIndex(): int
    {
        return $this->orderIndex;
    }
    /**
     * find the movie's using anCastid
     * @param int $idCast
     * @return Cast
     * @throws EntityNotFoundException if cast not found in database
     *
     */
    public static function findById(int $idCast): Cast
    {
        $castRequest = MyPdo::getInstance()->prepare(
            <<<'SQL'
			SELECT id, movieId, peopleId, role, orderIndex
			FROME cast
			WHERE id = ?
			SQL
        );
        $castRequest->execute([$idCast]);
        $cast = $castRequest->fetchObject(Cast::class);
        if (!$cast) {
            throw new EntityNotFoundException('Cast with id ' . $idCast . ' does not exist.');
        }
        return $cast;
    }
    /**
     * find the people (actor) using the cast instance related people id
     * @return People
     * @throws EntityNotFoundException if People not found in database
     *
     */
    public function getPeople(): People
    {
        $people = People::findById($this->getPeopleId());
        return $people;
    }
    /**
     * find the movie using an the cast instance related movie id
     * @return Movie
     * @throws EntityNotFoundException if Movie not found in database
     *
     */
    public function getMovie(): Movie
    {
        $movie = Movie::findById($this->getMovieId());
        return $movie;
    }
}
