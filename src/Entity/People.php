<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class People
{
    private int $id;
    private ?string $avatarId;
    private string $birthday;
    private ?string $deathday;
    private string $name;
    private string $biography;
    private string $placeOfBirth;


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of avatarId
     */
    public function getAvatarId()
    {
        return $this->avatarId;
    }

    /**
     * Get the value of birthday
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Get the value of deathday
     */
    public function getDeathday()
    {
        return $this->deathday;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of biography
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * Get the value of placeOfBirth
     */
    public function getPlaceOfBirth()
    {
        return $this->placeOfBirth;
    }
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
