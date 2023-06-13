<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Genre
{
    private int $id;
    private string $name;
    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * find the genre's using an genre id
     * @param int $genreId
     * @return Genre
     * @throws EntityNotFoundException if genre not found in database
     *
     */
    public static function findById(int $genreId): Genre
    {
        $genreRequest = MyPdo::getInstance()->prepare(
            <<<'SQL'
			SELECT id, name
			FROM genre
			WHERE id = ?
			SQL
        );
        $genreRequest->execute([$genreId]);
        $genre = $genreRequest->fetchObject(Genre::class);
        if (!$genre) {
            throw new EntityNotFoundException('Genre not found');
        }
        return $genre;
    }
}
