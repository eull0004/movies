<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use Entity\Cast;

class People
{
    private int $id;
    private ?int $avatarId;
    private ?string $birthday;
    private ?string $deathday;
    private string $name;
    private ?string $biography;
    private ?string $placeOfBirth;
    public function getId(): int
    {
        return $this->id;
    }
    public function getAvatarId(): ?int
    {
        return $this->avatarId;
    }
    public function getBirthday(): string
    {
        return $this->birthday;
    }
    public function getDeathday(): ?string
    {
        return $this->deathday;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getBiography(): string
    {
        return $this->biography;
    }
    public function getPlaceOfBirth(): string
    {
        return $this->placeOfBirth;
    }
    /**
     * find the people's using an people id
     * @param int $peopleId
     * @return People
     * @throws EntityNotFoundException if people not found in database
     *
     */
    public static function findById(int $peopleId): People
    {
        $peopleRequest = MyPdo::getInstance()->prepare(
            <<<'SQL'
			SELECT id, avatarId, birthday, deathday, name, biography, placeOfBirth 
			FROM people
			WHERE id = ?
			SQL
        );
        $peopleRequest->execute([$peopleId]);
        $people = $peopleRequest->fetchObject(People::class);
        if (!$people) {
            throw new EntityNotFoundException('People not found');
        }
        return $people;
    }
    /**
     * find the people's related Cast to a certain movie using the movie id
     * and the people related intance id
     * @param int $peopleId
     * @return People
     * @throws EntityNotFoundException if people not found in database
     *
     */
    public function getCastByMovieId(int $movieId): Cast
    {
        $castRequest = MyPdo::getInstance()->prepare(
            <<<'SQL'
			SELECT id, movieId, peopleId, role, orderIndex
			FROM cast
			WHERE movieId = :movieId
			AND peopleId = :peopleId
			SQL
        );
        $castRequest->execute([
            ':movieId' => $movieId,
            ':peopleId' => $this->getId()
        ]);
        $cast = $castRequest->fetchObject(Cast::class);
        if (!$cast) {
            throw new EntityNotFoundException('Cast not found');
        }
        return $cast;
    }
}
