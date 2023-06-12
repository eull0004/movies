<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Cast
{
    private int $id;
    private int $movieId;
    private int $peopleId;
    private string $role;
    private int $orderIndex;


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of movieId
     */
    public function getMovieId()
    {
        return $this->movieId;
    }

    /**
     * Get the value of peopleId
     */
    public function getPeopleId()
    {
        return $this->peopleId;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Get the value of orderIndex
     */
    public function getOrderIndex()
    {
        return $this->orderIndex;
    }
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
}
