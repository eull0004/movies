<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Movie
{
    private int $id;
    private string $title;
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public static function findById(int $movieId): Movie
    {
        $movieData = MyPdo::getInstance()->prepare(
            <<<'SQL'
			SELECT id, title
			FROM movie
			WHERE id = ?
			SQL
        );
        $movieData->execute([$movieId]);
        $movie = $movieData->fetchObject(Movie::class);
        if ($movie === false) {
            throw new EntityNotFoundException('Movie not found.');
        }
        return $movie;
    }
}
