<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class People
{
    private int $id;
    private string $avatarId;
    private string $birthday;
    private ?string $deathday;
    private string $name;
    private string $biography;
    private string $placeOfBirth;
    public function getId(): int
    {
        return $this->id;
    }
    public function getAvatarId(): string
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
}
